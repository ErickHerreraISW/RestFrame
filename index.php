<?php

    // Headers
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header("Access-Control-Allow-Methods: GET, POST");

    // Exceptions
    require_once "Common/Exception/NotFoundException.php";
    require_once "Common/Exception/NotAuthorizedException.php";
    require_once "Common/Exception/UnExpectedFailedException.php";
    require_once "Common/Exception/MethodNotAllowedException.php";

    // HttpResponses
    require_once "Common/HttpResponses/HttpResponse.php";
    require_once "Common/HttpResponses/HttpExceptionResponses.php";

    // Framework
    require_once  "Api.php";
    
    try {
        
        $allowed_methods = array("POST", "GET");

        $api_obj = new Api();

        $request =  $_SERVER["REQUEST_URI"];
        $method = $_SERVER["REQUEST_METHOD"];

        if(in_array(strtoupper($method), $allowed_methods) == false) {
            throw new MethodNotAllowedException("Only POST and GET method are allowed");
        }

        $api_obj->route($request, $method);
    }
    catch(Exception $ex) {
        HttpExceptionResponses::exceptionResponse($ex);
        return;
    }
?>