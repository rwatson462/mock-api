<?php

namespace MockApi\Route;

readonly class Route {
    public readonly array $headers;
    public readonly array $methods;

    public function __construct(
        public string $path,
        public ?string $response = null,
        public ?int $status = 200,
        ?array $methods = [],
        ?string $method = 'GET',
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
        
        if($methods !== null) {
            foreach($methods as &$method) {
                $method = strtolower($method);
            }
            return $methods;
        }
        
        // default to GET method if not specified anywhere else 
        return 'get';
    }
}
