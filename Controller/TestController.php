<?php

    namespace Controller;

    use Exceptions\UnExpectedFailedException;
    use Helper\HttpResponse\HttpResponses;
    use Helper\HttpResponse\HttpExceptionResponses;
    use Service\TestService;

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
            catch(\Exception $ex) {
                return HttpExceptionResponses::exceptionResponse($ex);
            }
        }

        public function postFunction2($params) {
            
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
            catch(\Exception $ex) {
                return HttpExceptionResponses::exceptionResponse($ex);
            }
        }
    }
?>