<?php

    require_once "Router.php";

    class Api extends Router {

        const USER_API_ENDPOINT = "/backend/user/";

        public function __construct() {
            
            parent::__construct();

            $this->testApi();
        }

        private function testApi() {

            $this->registerRoute(Api::USER_API_ENDPOINT . "sign_in", array(
                "httpMethod" => "POST",
                "controller" => "TestController",
                "callBack"   => "postFunction"
            ));
        }

        public function route($request_uri, $request_method) {

            // Working in local with http://localhost/RestFrame/
            $modified_request_uri = str_replace("/RestFrame", "", $request_uri);

            $this->executeRoute($modified_request_uri, $request_method);
        }
    }
?>