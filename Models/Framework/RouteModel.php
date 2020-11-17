<?php

    class RouteModel {

        private $route_url;

        private $route_http_method;

        private $route_class_obj;

        private $route_method_name;

        public  function __call($name, $arguments) {
            
            $prefix_method = substr($name, 0, 3);

            if($prefix_method == "get") {
                
                $remove_prefix = str_replace("get_", "", $name);
                return $this->$remove_prefix;
            }

            if($prefix_method == "set") {

                $remove_prefix = str_replace("set_", "", $name);
                $this->$remove_prefix = $arguments[0];
                return $this;
            }
        }
    }
?>