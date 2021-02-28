<?php

    use Core\Router\Router;

    use Controller\TestController;

    class Routes {

        const USER_API_ENDPOINT = "/backend/test/";

        /**
         * @var array
         */
        private $routes;

        /**
         * @var Router
         */
        private $router;

        public function __construct() {

            $this->routes = array();
            $this->router = new Router();

            $this->testApi();
        }

        private function testApi() {

            // Register a route sending Controller as string
            $this->router->registerRoute(Routes::USER_API_ENDPOINT . "test", array(
                "httpMethod" => "POST",
                "controller" => "Controller\TestController",
                "callBack"   => "postFunction"
            ), $this->routes);

            // Register a route sending Controller as class object
            $this->router->registerRoute(Routes::USER_API_ENDPOINT . "test2", array(
                "httpMethod" => "POST",
                "controller" => new TestController(),
                "callBack"   => "postFunction2"
            ), $this->routes);
        }

        public function route($request_uri, $request_method) {

            // Working in local with http://localhost/RestFrame/
            $modified_request_uri = str_replace("/RestFrame", "", $request_uri);

            $this->router->executeRoute($modified_request_uri, $request_method, $this->routes);
        }
    }
?>