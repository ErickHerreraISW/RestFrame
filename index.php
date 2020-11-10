<?php
    require_once  "Api.php";

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header("Access-Control-Allow-Methods: GET, POST");

    $request =  $_SERVER["REQUEST_URI"];
    $method = $_SERVER["REQUEST_METHOD"]; 

    $obj = new Api();
    $obj->ShowRoutes();
?>