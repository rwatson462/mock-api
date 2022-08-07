<?php

namespace App\Application;


use App\Application\Request\RequestInterface;
use App\Application\Route\RouteService;
use App\Domain\Response\ResponseFactory;
use App\Framework\File\FileFinder;

class RequestHandler
{
    public function __construct(
        private readonly RouteService $routeService,
        private readonly ResponseFactory $responseFactory,
        private readonly FileFinder $fileFinder,
    ) {
    }

    public function handle(RequestInterface $request): void
    {
        $route = $this->routeService->find($request->path(), $request->method());

        $response = $this->responseFactory->createFromRoute($route);

        if ($route->hasResponse()) {
            $responseFile = $this->fileFinder->find(RESPONSE_DIR . '/' . $route->response);
            $response->send($responseFile->contents());
        } else {
            $response->send();
        }
    }
}
