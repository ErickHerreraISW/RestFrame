<?php

    require_once "Router.php";

    class Api extends Router {

        const USER_API_ENDPOINT = "/backend/user/";

        public function __construct() {
            parent::__construct();

            $this->userApi();
        }

        private function userApi() {

            $this->registerRoute(Api::USER_API_ENDPOINT . "sign_in", array(
                "httpMethod" => "POST",
                "controller" => "Perro",
                "callBack"   => "Perrito"
            ));
        }

        public function ShowRoutes() {
            var_dump($this->routes_array);
        }
    }
?>