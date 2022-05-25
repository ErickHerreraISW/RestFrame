<?php 

namespace Core\Router;

use Core\Exception\RestFrameNotFoundException;
use Core\Model\RouteModel;

class Router {

    /**
     * @return void
     * @throws \ReflectionException
     */
    public function getControllerRoutes()
    {
        $controllers = scandir("./Controller");

        unset($controllers[0]);
        unset($controllers[1]);

        $register_routes = array();

        foreach ($controllers as $controller) {

            $controller_name = "Controller\\" . explode(".", $controller)[0];
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
                                "route_method_name" => $controller_function
                            );
                        }
                    }
                    catch (\Exception $ex) {}
                }
            }

            file_put_contents("./Cache/routes.json", json_encode($register_routes, JSON_PRETTY_PRINT));
        }
    }

    /**
     * @param string $request_url
     * @param string $request_method
     * @return mixed
     * @throws RestFrameNotFoundException
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function executeRoute(string $request_url, string $request_method)
    {
        if(count($_GET) > 0) {
            $request_url = substr($request_url, 0, strpos($request_url, '?'));
        }

        if(($route_result = $this->searchRoute($request_url)) instanceof RouteModel) {

            $route_http_method = strtoupper($route_result->get_route_http_method());

            if($route_http_method != strtoupper($request_method)) {
                throw new RestFrameNotFoundException("Invalid Http Method");
            }

            $controller_name = $route_result->get_route_class_obj();
            $callback_name = $route_result->get_route_method_name();

            if(is_string($controller_name)) {
                if(!class_exists($controller_name)) {
                    throw new \Exception("Class '" . $controller_name . "' doesn't exists");
                }
            }

            $reflection_obj = new \ReflectionClass($controller_name);

            if(!$reflection_obj->hasMethod($callback_name)) {
                throw new \Exception("Class '" . $controller_name . "' doesn't have a method called '" . $callback_name . "'");
            }

            $controller_obj = null;

            if(is_string($controller_name)) {
                $controller_obj = new $controller_name();
            }
            else {
                $controller_obj = $controller_name;
            }

            $request_params = $this->prepareRequestData($route_http_method);

            return $controller_obj->$callback_name($request_params);
        }

        throw new RestFrameNotFoundException("Route Not Found");
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

                $route_obj->set_route_url($route->route_url)
                          ->set_route_http_method($route->route_http_method)
                          ->set_route_class_obj($route->route_class_obj)
                          ->set_route_method_name($route->route_method_name);

                return $route_obj;
            }
        }

        return null;
    }

    /**
     * @param $http_method
     * @return array
     */
    private function prepareRequestData($http_method) : array
    {
        $params = array();

        switch($http_method) {

            case "POST":
                $content_type = getallheaders()["Content-Type"];

                if(preg_match("/application\/json/i", $content_type)) {

                    $json_params = json_decode(file_get_contents('php://input'));
                    $params = (array)$json_params;
                }

                if(preg_match("/multipart\/form-data/i", $content_type)) {
                    $params = $_POST;
                }
            break;

            case "GET":
                $params = $_GET;
            break;
        }

        return $params;
    }

    /**
     * @param $comment_doc
     * @return mixed|null
     */
    private function getRouteComment($comment_doc)
    {
        try {
            $comment_doc = str_replace("/**", "", $comment_doc);
            $comment_doc = str_replace("*/", "", $comment_doc);

            $comment_array = explode("*", $comment_doc);

            foreach ($comment_array as $comment_line) {

                if(strpos($comment_line, "@Router") !== false) {

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
}