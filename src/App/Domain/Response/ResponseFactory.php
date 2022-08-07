<?php

namespace App\Domain\Response;

use App\Application\Response\ResponseFactoryInterface;
use App\Application\Response\ResponseInterface;
use App\Application\Route\RouteInterface;
use App\Domain\Route\RouteNotFoundException;
use App\Framework\DependencyInjection\Container;
use Throwable;

class ResponseFactory implements ResponseFactoryInterface
{
    public function __construct(private readonly Container $container)
    {
    }

    public function createFromRoute(RouteInterface $route): ResponseInterface
    {
        $response = $this->container->get(ResponseInterface::class);
        $response->headers = $route->headers;
        $response->status = $route->status;

        return $response;
    }

    public function createFromException(Throwable $ex): ResponseInterface
    {
        return match($ex::class) {
            RouteNotFoundException::class => new NotFoundResponse(),
            default => new ErrorResponse(),
        };
    }
}
