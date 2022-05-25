<?php

namespace Controller;

use Exceptions\UnExpectedFailedException;
    use Helper\HttpResponse\HttpResponses;
    use Helper\HttpResponse\HttpExceptionResponses;
    use Service\TestService;

/**
* @Router({"Route":"/test"})
*/
class TestController {

    public function __construct() {

    }

    /**
     * @Router({"Route":"/post-function", "Method":"POST"})
     *
     * @param $params
     * @return void
     */
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

    /**
     * @Router({"Route":"/post-function-2", "Method":"POST"})
     *
     * @param $params
     * @return void
     */
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