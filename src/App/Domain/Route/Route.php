<?php

namespace App\Domain\Route;

use App\Application\Route\RouteInterface;
use App\Framework\DependencyInjection\Container;
use InvalidArgumentException;
use App\Domain\ValueObject\Header;

class Route implements RouteInterface {
    public readonly array $headers;
    public readonly array $methods;

    public function __construct(
        private readonly Container $container,
        public readonly string $path,
        public readonly ?string $response = null,
        public readonly ?int $status = 200,
        ?array $methods = [],
        ?string $method = null,
        array $headers = [],
    ) {
        $this->methods = $this->processRequestMethods($method, $methods);

        $transformedHeaders = [];
        foreach($headers as $name => $value) {
            $transformedHeaders[] = new Header(name: $name, value: $value);
        }
        $this->headers = $transformedHeaders;
    }

    private function processRequestMethods(?string $method, ?array $methods): array
    {
        if($method !== null) {
            return [strtolower($method)];
        }
        
        if($methods !== null && count($methods) > 0) {
            foreach($methods as &$method) {
                $method = strtolower($method);
            }
            return $methods;
        }
        
        throw new InvalidArgumentException('No request methods set for Route.  Either specify `methods[]` or `method` in config');
    }

    public function hasResponse(): bool
    {
        return $this->response !== null;
    }
}
