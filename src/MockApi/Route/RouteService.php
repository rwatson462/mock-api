<?php

namespace MockApi\Route;

use MockApi\Route\Exception\RouteNotFoundException;

class RouteService
{
    private array $routes = [];

    public function addRoute(string $routeName, Route $route): void {
        $this->routes[$routeName] = $route;
    }

    public function addManyRoutes(array $routes): void {
        foreach($routes as $routeName => $route) {
            $this->addRoute($routeName, $route);
        }
    }

    public function find(string $path, string $method): Route {
        foreach($this->routes as $route) {
            // @todo use regex to determine a match
            if($route->path === $path) {
                if(in_array($method, $route->methods)) {
                    return $route;
                }
            }
        }

        throw new RouteNotFoundException("Route $path not configured");
    }
}
