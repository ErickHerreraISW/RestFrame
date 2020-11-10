<?php

    class RouteModel {

        private $route_url;

        private $route_http_method;

        private $route_class_obj;

        private $route_method_name;

        public function getRouteUrl() {
            
            return $this->route_url;
        }

        public function setRouteUrl($route_url) {
            
            $this->route_url = $route_url;
            return $this;
        }

        public function getRouteHttpMethod() {
            return $this->route_http_method;
        }

        public function setRouteHttpMethod($route_http_method) {

            $this->route_http_method = $route_http_method;
            return $this;
        }

        public function getRouteClassObj() {
            return $this->route_class_obj;
        }

        public function setRouteClassObj($route_class_obj) {
            
            $this->route_class_obj = $route_class_obj;
            return $this;
        }

        public function getRouteMethodName() {
            return $this->route_method_name;
        }

        public function setRouteMethodName($route_method_name) {
            
            $this->route_method_name = $route_method_name;
            return $this;
        }
    }
?>