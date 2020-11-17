<?php 

    //Exceptions
    require_once "Common/Exception/NotFoundException.php";
    require_once "Common/Exception/NotAuthorizedException.php";
    require_once "Common/Exception/UnExpectedFailedException.php";
    require_once "Common/Exception/MethodNotAllowedException.php";

    // Http Responses
    require_once "HttpResponse.php";

    class HttpExceptionResponses {

        public static function exceptionResponse(Exception $exception) {

            if($exception instanceof NotFoundException) {
                return HttpResponses::notFound($exception->getMessage());
            }

            if($exception instanceof NotAuthorizedException) {
                return HttpResponses::notAuthorized($exception->getMessage());
            }

            if($exception instanceof UnExpectedFailedException) {
                return HttpResponses::failed($exception->getDetails());
            }

            if($exception instanceof MethodNotAllowedException) {
                return HttpResponses::methodNotAllowed($exception->getMessage());
            }

            return HttpResponses::internalError($exception->getMessage());
        }
    }
?>