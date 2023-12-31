<?php

namespace Core\Interface;

use Core\Model\Request;

interface MiddlewareInterface
{
    public function __construct(Request $request);

    public function getRequest() : Request;

    public function build() : mixed;
}