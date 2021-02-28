<?php 

    namespace Core\Router;

    use Core\Exception\RestFrameNotFoundException;
    use Core\Model\RouteModel;

    class Router {

        /**
         * @param string $url
         * @param array $params
         * @param array $routes
         *
         * @return void
         */
        public function registerRoute(string $url, array $params, array &$routes) : void
        {

            $route_obj = new RouteModel();

            $route_obj->set_route_url($url)
                      ->set_route_http_method($params["httpMethod"])
                      ->set_route_class_obj($params["controller"])
                      ->set_route_method_name($params["callBack"]);

            $routes[] = $route_obj;
        }

        /**
         * @param string $request_url
         * @param string $request_method
         * 
         * @return mixed|null
         * 
         * @throws RestFrameNotFoundException
         * @throws Exception
         */
        public function executeRoute(string $request_url, string $request_method, array $routes) : ?mixed
        {

            if(($route_result = $this->searchRoute($request_url, $routes)) instanceof RouteModel) {

                $route_http_method = strtoupper($route_result->get_route_http_method());

                if($route_http_method != strtoupper($request_method)) {
                    throw new RestFrameNotFoundException("Invalid Http Method");
                }

                $controller_name = $route_result->get_route_class_obj();
                $callback_name = $route_result->get_route_method_name();

                if(is_string($controller_name)) {
                    if(class_exists($controller_name) == false) {
                        throw new \Exception("Class '" . $controller_name . "' doesn't exists");
                    }
                }

                $reflection_obj = new \ReflectionClass($controller_name);

                if($reflection_obj->hasMethod($callback_name) == false) {
                    throw new \Exception("Class '" . $controller_name . "' doesn't have a method called '" . $callback_name . "'");
                }

                $controller_obj = null;

                if(is_string($controller_name)) {
                    $controller_obj = new $controller_name();
                }
                else {
                    $controller_obj = $controller_name;
                }

                if($route_http_method == "POST") {
                    return $controller_obj->$callback_name($_POST);
                }

                return $controller_obj->$callback_name();
            }

            throw new RestFrameNotFoundException("Route Not Found");
        }

        /**
         * @param string $request_url
         * @param array $routes
         * 
         * @return RouteModel|null
         */
        private function searchRoute(string $request_url, array $routes) : ?RouteModel
        {

            foreach($routes as $route) {

                if($route->get_route_url() == $request_url) {
                    return $route;
                }
            }

            return null;
        }
    }
?>