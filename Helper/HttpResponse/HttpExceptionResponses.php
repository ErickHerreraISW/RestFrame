<?php 

namespace Helper\HttpResponse;

use Core\Model\Response;
use Exceptions\MethodNotAllowedException;
use Exceptions\NotAuthorizedException;
use Exceptions\NotFoundException;
use Exceptions\UnExpectedFailedException;

class HttpExceptionResponses {

    /**
     * @param \Exception $exception
     * @return Response
     */
    public static function exceptionResponse(\Exception $exception) : Response
    {

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