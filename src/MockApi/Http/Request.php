<?php

namespace MockApi\Http;

class Request
{
    public readonly string $method;
    public readonly string $path;

    public function __construct()
    {
        // Just for consistency everywhere, use lower case text.
        $this->method = strtolower($_SERVER['REQUEST_METHOD'] ?? 'get');

        // Ensure URI starts with a forward slash and doesn't end with one.
        $this->path = '/' . rtrim(ltrim(strtolower($_SERVER['REQUEST_URI'] ?? ''), '/'), '/');
    }
}
