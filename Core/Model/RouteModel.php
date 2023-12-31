<?php

    namespace Core\Model;

    class RouteModel {

        private string $route_url;

        private string $route_http_method;

        private string $route_class_obj;

        private string $route_method_name;

        public function getRouteUrl(): string
        {
            return $this->route_url;
        }

        public function setRouteUrl(string $route_url): RouteModel
        {
            $this->route_url = $route_url;
            return $this;
        }

        public function getRouteHttpMethod(): string
        {
            return $this->route_http_method;
        }

        public function setRouteHttpMethod(string $route_http_method): RouteModel
        {
            $this->route_http_method = $route_http_method;
            return $this;
        }

        public function getRouteClassObj(): string
        {
            return $this->route_class_obj;
        }

        public function setRouteClassObj(string $route_class_obj): RouteModel
        {
            $this->route_class_obj = $route_class_obj;
            return $this;
        }

        public function getRouteMethodName(): string
        {
            return $this->route_method_name;
        }

        public function setRouteMethodName(string $route_method_name): RouteModel
        {
            $this->route_method_name = $route_method_name;
            return $this;
        }
    }
?>