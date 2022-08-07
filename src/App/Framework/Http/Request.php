<?php

namespace App\Framework\Http;

use App\Application\Request\RequestInterface;
use App\Framework\DependencyInjection\Container;

class Request implements RequestInterface
{
    public function __construct(
        private readonly Container $container,
        private readonly string $method,
        private readonly string $path,
    ) {
    }

    public function method(): string
    {
        return $this->method;
    }

    public function path(): string
    {
        return $this->path;
    }
}
