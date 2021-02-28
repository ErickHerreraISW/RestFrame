<?php

    require_once "autoload.php";
    require_once  "routes.php";

    // Headers
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header("Access-Control-Allow-Methods: GET, POST");

    use Exceptions\MethodNotAllowedException;
    use Helper\HttpResponse\HttpExceptionResponses;
    
    try {
        
        $allowed_methods = array("POST", "GET");

        $api_obj = new Routes();

        $request =  $_SERVER["REQUEST_URI"];
        $method = $_SERVER["REQUEST_METHOD"];

        if(in_array(strtoupper($method), $allowed_methods) == false) {
            throw new MethodNotAllowedException("Only POST and GET method are allowed");
        }

        $api_obj->route($request, $method);
    }
    catch(Exception $ex) {
        
        return HttpExceptionResponses::exceptionResponse($ex);
    }
?>