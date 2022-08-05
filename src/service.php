<?php

require __DIR__ . '/autoloader.php';

use MockApi\File\FileService;
use MockApi\Http\Header;
use MockApi\Http\Request;
use MockApi\Http\Response;
use MockApi\Http\Response\NotFoundResponse;
use MockApi\Http\Response\ErrorResponse;
use MockApi\Route\Route;
use MockApi\Route\RouteFactory;
use MockApi\Route\RouteService;
use MockApi\Route\Exception\RouteNotFoundException;

define('CONFIG_DIR', dirname(__DIR__) . '/config');
define('ROUTE_DIR', CONFIG_DIR . '/routes');
define('RESPONSE_DIR', CONFIG_DIR . '/responses');

try {
    $routeService = (new RouteService)->addManyRoutes(
        RouteFactory::loadRoutesFromArray(
            FileService::flattenIniFiles(
                FileService::getContentsOfFiles(
                    FileService::findFiles(ROUTE_DIR)
                )
            )
        )
    )->sortRoutes();
} catch (Throwable $t) {
    $response = new ErrorResponse;
    $response->send($t->getMessage());
    exit;
}

$request = new Request;

try {
    $route = $routeService->find($request->path, $request->method);
} catch(Throwable $t) {
    $response = new NotFoundResponse;
    $response->send($t->getMessage());
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
