<?php

require __DIR__ . '/autoloader.php';

use App\Application\File\FileFinderInterface;
use App\Application\File\FileServiceInterface;
use App\Application\Request\RequestFactoryInterface;
use App\Application\RequestHandler;
use App\Application\Response\ResponseFactoryInterface;
use App\Application\Route\RouteFactoryInterface;
use App\Application\Route\RouteService;
use App\Framework\DependencyInjection\Container;

/**
 * CONFIGURATION
 */

define('CONFIG_DIR', dirname(__DIR__) . '/config');
const ROUTE_DIR = CONFIG_DIR . '/routes';
const RESPONSE_DIR = CONFIG_DIR . '/responses';

/**
 * DEPENDENCIES
 */

$container = new Container();
$containers = parse_ini_file(__DIR__ . '/di.ini');
foreach($containers as $interface => $class) {
    $container->set($interface, $class);
}

/**
 * APPLICATION
 */
try {
    $fileFinder = $container->get(FileFinderInterface::class);
    $fileService = $container->get(FileServiceInterface::class);
    $requestFactory = $container->get(RequestFactoryInterface::class);
    $responseFactory = $container->get(ResponseFactoryInterface::class);
    $routeService = $container->get(RouteService::class);
    $routeFactory = $container->get(RouteFactoryInterface::class);

    $fileList = $fileFinder->findFiles(ROUTE_DIR);
    $flatFileList = $fileService->flattenIniFiles($fileList);
    $routes = $routeFactory->createRoutesFromArray($flatFileList);
    $routeService->addManyRoutes($routes)->sortRoutes();

    $request = $requestFactory->createFromServerVars();
    $requestHandler = new RequestHandler($routeService, $responseFactory, $fileFinder);
    $requestHandler->handle($request);
} catch (Throwable $t) {
    $response = $container->get(ResponseFactoryInterface::class)->createFromException($t);
    $response->send($t->getMessage());
}
