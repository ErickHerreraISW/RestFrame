<?php

    class TestController {

        public function __construct() {

        }

        public function getFunction() {
            return "Hola Mundo";
        }

        public function postFunction($params) {
            echo "Hola " . $params["nombre"];
        }
    }
?>