<?php 
    
    require_once "Models/Framework/RouteModel.php";

    require_once "Common/Exception/NotFoundException.php";

    // Controllers

    require_once "Controllers/TestController.php";

    class Router {

        protected $routes_array;

        public function __construct() {
            
            $this->routes_array = array();
        }

        protected function registerRoute($url, $params) {

            $route_obj = new RouteModel();

            $route_obj->setRouteUrl($url)
                      ->setRouteHttpMethod($params["httpMethod"])
                      ->setRouteClassObj($params["controller"])
                      ->setRouteMethodName($params["callBack"]);

            $this->routes_array[] = $route_obj;
        }

        protected function executeRoute($request_url, $request_method) {

            if(($route_result = $this->searchRoute($request_url)) instanceof RouteModel) {

                $route_http_method = strtoupper($route_result->getRouteHttpMethod());

                if($route_http_method != strtoupper($request_method)) {
                    
                    throw new NotFoundException("Invalid Http Method");
                }

                $controller_name = $route_result->getRouteClassObj();
                $callback_name = $route_result->getRouteMethodName();

                $controller_obj = new $controller_name();

                if($route_http_method == "POST") {
                    return $controller_obj->$callback_name($_POST);
                }

                return $controller_obj->$callback_name();
            }

            throw new NotFoundException("Route Not Found");
        }

        private function searchRoute($request_url) {

            foreach($this->routes_array as $route) {

                if($route->getRouteUrl() == $request_url) {
                    return $route;
                }
            }

            return null;
        }
    }
?>