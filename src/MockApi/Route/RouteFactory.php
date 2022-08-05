<?php

namespace MockApi\Route;

use RuntimeException;
use Throwable;

class RouteFactory
{
    public static function loadRoutesFromArray(array $routeData): array
    {
        $routes = [];

        foreach($routeData as $routeName => $routeConfig) {
            try {
                $routes[$routeName] = new Route(...$routeConfig);
            } catch (Throwable $t) {
                // Re-throw the error wrapping the route name in the message
                throw new RuntimeException("[$routeName] {$t->getMessage()}");
            }
        }

        return $routes;
    }
}
