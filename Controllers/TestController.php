<?php

    //Exceptions
    require_once "Common/Exception/UnExpectedFailedException.php";

    // HTTP Responses
    require_once "Common/HttpResponses/HttpResponse.php";
    require_once "Common/HttpResponses/HttpExceptionResponses.php";

    // Service
    require_once "Services/TestService.php";

    class TestController {

        public function __construct() {

        }

        public function getFunction() {
            return "Hola Mundo";
        }

        public function postFunction($params) {
            
            try {
                if(!isset($params["name"])) {
                    throw new UnExpectedFailedException(array(
                        "message" => "Some parameters are missing",
                        "params" => array(
                            "name*" => "string"
                        )
                    ));
                }

                $name = $params["name"];

                $test_service = new TestService();

                return HttpResponses::success($test_service->postFunction($name));
            }
            catch(Exception $ex) {
                return HttpExceptionResponses::exceptionResponse($ex);
            }
        }
    }
?>