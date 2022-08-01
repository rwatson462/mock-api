<?php

namespace MockApi\Http;

class Request
{
    public readonly string $method;
    public readonly string $path;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->path = '/' . ltrim($_SERVER['REQUEST_URI'] ?? '', '/');
    }
}