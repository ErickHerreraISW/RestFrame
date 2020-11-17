<?php 
    
    //Framework
    require_once "Models/Framework/RouteModel.php";

    //Exceptions
    require_once "Common/Exception/NotFoundException.php";

    // Controllers
    require_once "Autoload/autoload-controllers.php";

    class Router {

        /**
         * @var array $routes_array
         */
        protected $routes_array;

        public function __construct() {
            
            $this->routes_array = array();
        }

        /**
         * $params = array(
         *     "httpMethod" => string value,
         *     "controller" => string value,
         *     "callBack"   => string value
         * );
         * 
         * @param string $url
         * @param array $params
         *
         * @return void
         */
        protected function registerRoute(string $url, array $params) {

            $route_obj = new RouteModel();

            $route_obj->set_route_url($url)
                      ->set_route_http_method($params["httpMethod"])
                      ->set_route_class_obj($params["controller"])
                      ->set_route_method_name($params["callBack"]);

            $this->routes_array[] = $route_obj;
        }

        /**
         * @param string $request_url
         * @param string $request_method
         * 
         * @return null
         * 
         * @throws NotFoundException
         * @throws Exception
         */
        protected function executeRoute(string $request_url, string $request_method) {

            if(($route_result = $this->searchRoute($request_url)) instanceof RouteModel) {

                $route_http_method = strtoupper($route_result->get_route_http_method());

                if($route_http_method != strtoupper($request_method)) {
                    throw new NotFoundException("Invalid Http Method");
                }

                $controller_name = $route_result->get_route_class_obj();
                $callback_name = $route_result->get_route_method_name();

                if(class_exists($controller_name) == false) {
                    throw new Exception("Class '" . $controller_name . "' doesn't exists");
                }

                $reflection_obj = new ReflectionClass($controller_name);

                if($reflection_obj->hasMethod($callback_name) == false) {
                    throw new Exception("Class '" . $controller_name . "' doesn't have a method called '" . $callback_name . "'");
                }

                $controller_obj = new $controller_name();

                if($route_http_method == "POST") {
                    return $controller_obj->$callback_name($_POST);
                }

                return $controller_obj->$callback_name();
            }

            throw new NotFoundException("Route Not Found");
        }

        /**
         * @param string $request_url
         * 
         * @return RouteModel|null
         */
        private function searchRoute(string $request_url) {

            foreach($this->routes_array as $route) {

                if($route->get_route_url() == $request_url) {
                    return $route;
                }
            }

            return null;
        }
    }
?>