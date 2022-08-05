<?php

namespace MockApi\Route;

use InvalidArgumentException;

readonly class Route {
    public readonly array $headers;
    public readonly array $methods;

    public function __construct(
        public string $path,
        public ?string $response = null,
        public ?int $status = 200,
        ?array $methods = [],
        ?string $method = null,
        array $headers = [],
    ) {
        $this->methods = $this->processRequestMethods($method, $methods);

        $transformedHeaders = [];
        foreach($headers as $name => $value) {
            $transformedHeaders[] = new \MockApi\Http\Header(name: $name, value: $value);
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
}
