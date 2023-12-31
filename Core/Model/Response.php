<?php

namespace Core\Model;

class Response
{
    private mixed $content;

    private int $status_code;

    private mixed $headers;

    public function __construct(mixed $content, int $status_code = 200, $headers = [])
    {
        $this->setContent($content);
        $this->setStatusCode($status_code);
        $this->setHeaders($headers);
    }

    public function getContent(): mixed
    {
        return $this->content;
    }

    public function setContent(mixed $content): Response
    {
        $this->content = $content;
        return $this;
    }

    public function getStatusCode(): int
    {
        return $this->status_code;
    }

    public function setStatusCode(int $status_code): Response
    {
        $this->status_code = $status_code;
        return $this;
    }

    public function getHeaders(): mixed
    {
        return $this->headers;
    }

    public function setHeaders(mixed $headers): Response
    {
        $this->headers = $headers;
        return $this;
    }
}