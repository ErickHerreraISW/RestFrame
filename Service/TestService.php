<?php

    namespace Service;

    class TestService {

        public function __construct() {
            
        }

        /**
         * @param string $name
         * @return string
         */
        public function postFunction($name) : string
        {

            return "Hi Mr./Mrs " . $name;
        }
    }
?>