<?php

namespace MockApi\Route;

use MockApi\Route\Exception\RouteNotFoundException;

class RouteService
{
    private array $routes = [];

    public function sortRoutes(): self
    {
        usort(
            $this->routes,
            static fn($routeA, $routeB) => strcmp($routeA->path, $routeB->path)
        );

        return $this;
    }

    public function addRoute(string $routeName, Route $route): self {
        $this->routes[$routeName] = $route;

        return $this;
    }

    public function addManyRoutes(array $routes): self {
        foreach($routes as $routeName => $route) {
            $this->addRoute($routeName, $route);
        }

        return $this;
    }

    public function find(string $path, string $method): Route {
        foreach($this->routes as $route) {
            if(preg_match("|^$route->path$|", $path)) {
                if(in_array($method, $route->methods)) {
                    return $route;
                }
            }
        }

        throw new RouteNotFoundException("Route $path not configured");
    }
}
