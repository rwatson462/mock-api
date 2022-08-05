<?php

namespace MockApi\Route;

class RouteFactory
{
    public static function loadFromIniFile(string $filename): array
    {
        $fileRoutes = parse_ini_file($filename, true);

        $routes = [];

        foreach($fileRoutes as $routeName => $routeConfig) {
            $routes[$routeName] = new Route(...$routeConfig);
        }

        return $routes;
    }
}