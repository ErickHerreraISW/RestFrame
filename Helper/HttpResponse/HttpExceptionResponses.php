<?php 

    namespace Helper\HttpResponse;

    use Exceptions\MethodNotAllowedException;
    use Exceptions\NotAuthorizedException;
    use Exceptions\NotFoundException;
    use Exceptions\UnExpectedFailedException;

    class HttpExceptionResponses {

        public static function exceptionResponse(\Exception $exception) {

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