<?php

    namespace Exceptions;

    class UnExpectedFailedException extends \Exception {
        
        private $details;

        public function __construct($array_details) {

            parent::__construct($array_details["message"]);
            $this->details = $array_details;
        }

        public function getDetails() {
            return $this->details;
        }
    }
?>