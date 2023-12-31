<?php

namespace Core\Model;

class Request
{
    /**
     * @var mixed
     */
    private mixed $params;

    /**
     * @var mixed
     */
    private mixed $headers;

    public function getParams(): mixed
    {
        return $this->params;
    }

    public function setParams(mixed $params): Request
    {
        $this->params = $params;
        return $this;
    }

    public function getHeaders(): mixed
    {
        return $this->headers;
    }

    public function setHeaders(mixed $headers): Request
    {
        $this->headers = $headers;
        return $this;
    }
}