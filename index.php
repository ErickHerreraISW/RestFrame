<?php
require_once "autoload.php";

// Headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

use Core\Router\Router;

$allowed_methods = array("POST", "GET");

$api_obj = new Router();
$api_obj->getControllerRoutes();

$request =  $_SERVER["REQUEST_URI"];
$method = $_SERVER["REQUEST_METHOD"];

// Working in local with http://localhost/RestFrame/
$modified_request_uri = str_replace("/RestFrame", "", $request);

$api_obj->executeRoute($modified_request_uri, $method);