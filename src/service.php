<?php

use MockApi\Http\Header;
use MockApi\Http\Request;
use MockApi\Http\Response;
use MockApi\Route\Route;
use MockApi\Route\RouteFactory;
use MockApi\Route\RouteService;
use MockApi\Route\Exception\RouteNotFoundException;

define('CONFIG_DIR', dirname(__DIR__) . '/config');
define('ROUTE_DIR', CONFIG_DIR . '/routes');
define('RESPONSE_DIR', CONFIG_DIR . '/responses');
/**
 * Usage: php -S 0.0.0.0:8080 service.php
 * Replace 8000 with your port of choice
 */

spl_autoload_register(static function(string $classname) {
    $filename = __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $classname) . '.php';
    if(@file_exists($filename)) {
        @include $filename;
    }
});

$routeService = new RouteService;

foreach(scandir(ROUTE_DIR) as $routeFile) {
    if($routeFile[0] === '.') {
        continue;
    }

    $routes = RouteFactory::loadFromIniFile(ROUTE_DIR . '/' . $routeFile);
    $routeService->addManyRoutes($routes);
}

$request = new Request;

try {
    $route = $routeService->find($request->path, $request->method);
} catch(RouteNotFoundException $e) {
    $response = new Response;
    $response->status = 404;
    $response->headers[] = new Header(name: 'Content-type', value: 'text/plain');
    $response->send($e->getMessage());
    exit;
}

$response = new Response;
$response->headers = $route->headers;
$response->status = $route->status;

if($route->response !== null) {
    $responseFilename = RESPONSE_DIR . '/' . $route->response;
    if(file_exists($responseFilename) && is_file($responseFilename)) {
        $response->send(file_get_contents(RESPONSE_DIR . '/' . $route->response));
    }
 } else {
    $response->send();
}
