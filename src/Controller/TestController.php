<?php

namespace src\Controller;

use Core\Model\Request;
use Core\Model\Response;
use src\Exceptions\UnExpectedFailedException;
use src\Helper\HttpResponse\HttpExceptionResponses;
use src\Helper\HttpResponse\HttpResponses;
use src\Service\TestService;

/**
* @Router({"Route":"/test"})
*/
class TestController
{
    /**
     * @Router({"Route":"/post-function", "Method":"POST"})
     *
     * @param Request $request
     * @return Response
     */
    public function postFunction(Request $request) : Response
    {
        try {
            $params = $request->getParams();

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

            return HttpResponses::success(array(
                "data" => $test_service->postFunction($name)
            ));
        }
        catch(\Exception $ex) {
            return HttpExceptionResponses::exceptionResponse($ex);
        }
    }

    /**
     * @Router({"Route":"/post-function-2", "Method":"POST", "Uses": "TestMiddleware"})
     *
     * @param Request $request
     * @return Response
     */
    public function postFunction2(Request $request) : Response
    {
        try {
            $params = $request->getParams();

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