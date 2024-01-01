<?php

namespace src\Middleware;

use Core\Interface\MiddlewareInterface;
use Core\Model\Request;
use Core\Model\Response;

class TestMiddleware implements MiddlewareInterface
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return true|Response
     * @throws \Exception
     */
    public function build(): true|Response
    {
        if(!isset($this->request->getHeaders()["Authorization"])) {
            return new Response(array(
                "message" => "Authorization is required"
            ), 401);
        }

        return true;
    }
}