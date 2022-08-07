<?php

namespace App\Application\Route;

interface RouteFactoryInterface
{
    public function createRoutesFromArray(array $routeData): array;
}