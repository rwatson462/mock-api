<?php

namespace App\Domain\Request;

use App\Application\Request\RequestFactoryInterface;
use App\Application\Request\RequestInterface;
use App\Framework\DependencyInjection\Container;

class RequestFactory implements RequestFactoryInterface
{
    public function __construct(private readonly Container $container)
    {
    }

    public function createFromServerVars(): RequestInterface
    {
        return $this->container->get(
            RequestInterface::class,
            [
                'method' => strtolower($_SERVER['REQUEST_METHOD'] ?? 'get'),
                'path' => '/' . rtrim(ltrim(strtolower($_SERVER['REQUEST_URI'] ?? ''), '/'), '/')
            ]
        );
    }
}
