<?php 

    function autoload_controllers($controller_name) {
        require_once "Controllers/" . $controller_name . ".php";
    }

    spl_autoload_register("autoload_controllers");
?>