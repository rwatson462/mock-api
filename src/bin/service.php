<?php

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

foreach(scandir(dirname(__DIR__).'/config/routes') as $routeFile) {
    if($routeFile[0] === '.') {
        continue;
    }

    $fileRoutes = parse_ini_file(dirname(__DIR__).'/config/routes/'.$routeFile, true);

    foreach($fileRoutes as $routeName => $routeConfig) {
        $route = new Route(...$routeConfig);
        $routeService->addRoute($routeName, $route);
    }
}

$request = new \MockApi\Http\Request;

try {
    $route = $routeService->find($request->path);
} catch(RouteNotFoundException $e) {
    $response = new \MockApi\Http\Response;
    $response->status = 404;
    $response->headers[] = new \MockApi\Http\Header(name: 'Content-type', value: 'text/plain');
    $response->send($e->getMessage());
    exit;
}

$response = new \MockApi\Http\Response;
$response->headers = $route->headers;
$response->status = $route->status;

if($route->response !== null) {
    $responseFilename = dirname(__DIR__).'/config/responses/'.$route->response;
    if(file_exists($responseFilename) && is_file($responseFilename)) {
        $response->send(file_get_contents(dirname(__DIR__).'/config/responses/'.$route->response));
    }
 } else {
    $response->send();
}
