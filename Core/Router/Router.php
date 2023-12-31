<?php 

namespace Core\Router;

use Core\Exception\RestFrameNotFoundException;
use Core\Model\Request;
use Core\Model\Response;
use Core\Model\RouteModel;

class Router {

    /**
     * @return void
     */
    public function getControllerRoutes() : void
    {
        try {
            $controllers = scandir("./src/Controller");

            unset($controllers[0]);
            unset($controllers[1]);

            $register_routes = array();

            foreach ($controllers as $controller) {

                $controller_name = "src\\Controller\\" . explode(".", $controller)[0];
                $reflection = new \ReflectionClass($controller_name);

                $controller_route = "";

                try {
                    $controller_route_obj = $this->getRouteComment($reflection->getDocComment());

                    if($controller_route_obj != null) {
                        $controller_route = $controller_route_obj->Route;
                    }
                }
                catch (\Exception $ex) {}

                $controller_functions = get_class_methods($controller_name);

                foreach ($controller_functions as $controller_function) {

                    if($controller_function != "__construct") {

                        try {
                            $function_route_obj = $this->getRouteComment($reflection->getMethod($controller_function)->getDocComment());

                            if($function_route_obj != null) {

                                $register_routes[] = array(
                                    "route_url"         => $controller_route . $function_route_obj->Route,
                                    "route_http_method" => $function_route_obj->Method,
                                    "route_class_obj"   => $controller_name,
                                    "route_method_name" => $controller_function,
                                    "route_middleware"  => isset($function_route_obj->Uses) ? "src\\Middleware\\" . $function_route_obj->Uses :  null
                                );
                            }
                        }
                        catch (\Exception $ex) {}
                    }
                }

                file_put_contents("./Cache/routes.json", json_encode($register_routes, JSON_PRETTY_PRINT));
            }
        }
        catch (\Exception $ex) {

            http_response_code(500);
            header("Content-type: application/json; charset=utf-8");

            print json_encode(array(
                "message" => $ex->getMessage(),
                "trace"   => $ex->getTrace()
            ), JSON_PRETTY_PRINT);
        }
    }

    /**
     * @param string $request_url
     * @param string $request_method
     * @return void
     */
    public function executeRoute(string $request_url, string $request_method) : void
    {
        try {
            if(count($_GET) > 0) {
                $request_url = substr($request_url, 0, strpos($request_url, '?'));
            }

            $route_result = $this->searchRoute($request_url);

            if(!($route_result instanceof RouteModel)) {
                throw new RestFrameNotFoundException("Route Not Found");
            }

            $route_http_method = strtoupper($route_result->getRouteHttpMethod());

            if($route_http_method != strtoupper($request_method)) {
                throw new RestFrameNotFoundException("Invalid Http Method");
            }

            $controller_name = $route_result->getRouteClassObj();
            $callback_name = $route_result->getRouteMethodName();

            if(is_string($controller_name)) {
                if(!class_exists($controller_name)) {
                    throw new \Exception("Class '" . $controller_name . "' doesn't exists");
                }
            }

            $reflection_obj = new \ReflectionClass($controller_name);

            if(!$reflection_obj->hasMethod($callback_name)) {
                throw new \Exception("Class '" . $controller_name . "' doesn't have a method called '" . $callback_name . "'");
            }

            if(is_string($controller_name)) {
                $controller_obj = new $controller_name();
            }
            else {
                $controller_obj = $controller_name;
            }

            $ref = new \ReflectionMethod($controller_name, $callback_name);
            $request_params = $this->prepareRequestData($route_http_method);

            $middleware_name = $route_result->getRouteMiddleware();

            if(is_string($middleware_name)) {
                if(!class_exists($middleware_name)) {
                    throw new \Exception("Class '" . $middleware_name . "' doesn't exists");
                }

                $middleware = new $middleware_name($request_params);
                $response = $middleware->build();

                if($response instanceof Response) {
                    $this->prepareResponseData($response);
                    return;
                }

                $newRequest = $middleware->getRequest();
                $this->returnResponse($ref, $controller_obj, $callback_name, $newRequest);
            }
            else {
                $this->returnResponse($ref, $controller_obj, $callback_name, $request_params);
            }
        }
        catch (\Exception $ex) {
            http_response_code(500);
            header("Content-type: application/json; charset=utf-8");

            print json_encode(array(
                "message" => $ex->getMessage(),
                "trace"   => $ex->getTrace()
            ), JSON_PRETTY_PRINT);
        }
    }

    /**
     * @param \ReflectionMethod $ref
     * @param mixed $controller_obj
     * @param string $callback_name
     * @param Request $request_params
     * @return void
     */
    private function returnResponse(\ReflectionMethod $ref, mixed $controller_obj, string $callback_name, Request $request_params) : void
    {
        if($ref->getNumberOfParameters() > 0) {
            $response = $controller_obj->$callback_name($request_params);
        }
        else {
            $response = $controller_obj->$callback_name();
        }

        $this->prepareResponseData($response);
    }

    /**
     * @param string $request_url
     * @return RouteModel|null
     */
    private function searchRoute(string $request_url) : ?RouteModel
    {
        $routes = json_decode(file_get_contents("./Cache/routes.json"));

        foreach($routes as $route) {

            if($route->route_url == $request_url) {

                $route_obj = new RouteModel();

                $route_obj->setRouteUrl($route->route_url)
                          ->setRouteHttpMethod($route->route_http_method)
                          ->setRouteClassObj($route->route_class_obj)
                          ->setRouteMethodName($route->route_method_name)
                          ->setRouteMiddleware($route->route_middleware);

                return $route_obj;
            }
        }

        return null;
    }

    /**
     * @param $http_method
     * @return Request
     */
    private function prepareRequestData($http_method) : Request
    {
        $params = array();

        switch($http_method) {

            case "POST":
                $content_type = getallheaders()["Content-Type"] ?? null;

                if(preg_match("/application\/json/i", $content_type)) {

                    $json_params = json_decode(file_get_contents('php://input'));
                    $params = (array)$json_params;
                }
                else if(preg_match("/multipart\/form-data/i", $content_type)) {
                    $params = $_POST;
                }
                else {
                    $params = [];
                }
            break;

            case "GET":
                $params = $_GET;
            break;
        }

        $request = new Request();

        $request->setParams($params)
                ->setHeaders(getallheaders());

        return $request;
    }

    /**
     * @param $comment_doc
     * @return mixed|null
     */
    private function getRouteComment($comment_doc) : mixed
    {
        try {
            $comment_doc = str_replace("/**", "", $comment_doc);
            $comment_doc = str_replace("*/", "", $comment_doc);

            $comment_array = explode("*", $comment_doc);

            foreach ($comment_array as $comment_line) {

                if(str_contains($comment_line, "@Router")) {

                    $first_split = explode("(", $comment_line)[1];
                    $second_split = explode(")", $first_split)[0];

                    return json_decode($second_split);
                }
            }

            return null;

        }
        catch (\Exception $ex) {
            return null;
        }
    }

    /**
     * @param $response
     * @return void
     */
    private function prepareResponseData($response) : void
    {
        if(!($response instanceof Response)) {

            http_response_code(500);

            print json_encode(array(
                "message" => "The return must be an instance of Response"
            ), JSON_PRETTY_PRINT);
        }

        http_response_code($response->getStatusCode());
        header("Content-type: application/json; charset=utf-8");

        foreach($response->getHeaders() as $key => $value) {
            header($key . ": " . $value);
        }

        print json_encode($response->getContent(), JSON_PRETTY_PRINT);
    }
}