<?php

namespace Core\Interface;

use Core\Model\Request;

interface MiddlewareInterface
{
    /**
     * @param Request $request
     */
    public function __construct(Request $request);

    /**
     * @return Request
     */
    public function getRequest() : Request;

    /**
     * @return mixed
     */
    public function build() : mixed;
}