<?php

namespace App\Application\Route;

use App\Domain\Route\Route;
use App\Domain\Route\RouteNotFoundException;

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
        $regexMatchedRoutes = [];

        foreach($this->routes as $route) {
            if(!in_array($method, $route->methods)) {
                continue;
            }

            // We can't get more specific than an exact match.
            if($route->path === $path) {
                return $route;
            }

            // Make a list of potential other matches
            if(preg_match("|^$route->path$|", $path)) {
                $regexMatchedRoutes[] = $route;
            }
        }

        if(count($regexMatchedRoutes) > 0) {
            // @todo how do we actually find the "best" match?
            // As Routes as sorted alphabetically we can return the first one
            return $regexMatchedRoutes[0];
        }

        throw new RouteNotFoundException("Route $path not configured");
    }
}
