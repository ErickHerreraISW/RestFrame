<?php

    namespace Service;

    class TestService {

        public function __construct() {
            
        }

        public function postFunction($name) {

            return "Hi Mr./Mrs " . $name;
        }
    }
?>