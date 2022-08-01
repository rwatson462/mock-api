<?php

class RouteService
{
    private array $routes = [];

    public function addRoute(string $routeName, Route $route) {
        $this->routes[$routeName] = $route;
    }

    public function find(string $path): Route {
        // @todo use regex to determine a match
        foreach($this->routes as $route) {
            if($route->path === $path) {
                return $route;
            }
        }

        throw new RouteNotFoundException("Route $path not configured");
    }
}
