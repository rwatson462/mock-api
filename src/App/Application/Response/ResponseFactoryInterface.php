<?php

namespace App\Application\Response;

use App\Application\Route\RouteInterface;

interface ResponseFactoryInterface
{
    public function createFromRoute(RouteInterface $route): ResponseInterface;

    public function createFromException(\Throwable $ex): ResponseInterface;
}