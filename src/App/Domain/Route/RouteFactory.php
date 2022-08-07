<?php

namespace App\Domain\Route;

use App\Application\Route\RouteFactoryInterface;
use App\Application\Route\RouteInterface;
use App\Framework\DependencyInjection\Container;
use RuntimeException;
use Throwable;

class RouteFactory implements RouteFactoryInterface
{
    public function __construct(private readonly Container $container)
    {
    }

    public function createRoutesFromArray(array $routeData): array
    {
        $routes = [];

        foreach($routeData as $routeName => $routeConfig) {
            try {
                $routes[$routeName] = $this->container->get(RouteInterface::class, $routeConfig);
            } catch (Throwable $t) {
                // Re-throw the error wrapping the route name in the message
                throw new RuntimeException(
                    message: "[$routeName] {$t->getMessage()} " . print_r($routeConfig,true),
                    previous: $t
                );
            }
        }

        return $routes;
    }
}
