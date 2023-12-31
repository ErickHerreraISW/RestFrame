<?php 

namespace src\Helper\HttpResponse;

use Core\Model\Response;

class HttpResponses
{
    /**
     * @param mixed $data
     * @return Response
     */
    public static function success(mixed $data) : Response
    {
        return new Response($data, 200);
    }

    /**
     * @param mixed|null $data
     * @return Response
     */
    public static function notFound(mixed $data = null) : Response
    {
        return new Response($data, 404);
    }

    /**
     * @param mixed|null $data
     * @return Response
     */
    public static function failed(mixed $data = null) : Response
    {
         return new Response($data, 417);
    }

    /**
     * @param mixed|null $data
     * @return Response
     */
    public static function notAuthorized(mixed $data = null) : Response
    {
        return new Response($data, 401);
    }

    /**
     * @param mixed|null $data
     * @return Response
     */
    public static function internalError(mixed $data = null) : Response
    {
        return new Response($data, 500);
    }

    /**
     * @param $data
     * @return Response
     */
    public static function methodNotAllowed($data = null) : Response
    {
        return new Response($data, 405);
    }

    /**
     * @param int $response_code
     * @param mixed|null $data
     * @return Response
     */
    public static function customResponse(int $response_code, mixed $data = null) : Response
    {
        return new Response($data, $response_code);
    }
}