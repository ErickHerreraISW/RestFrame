<?php

    function rest_frame_autoload($className) : void
    {
        require_once $className . ".php";
    }

    spl_autoload_register("rest_frame_autoload");

?>