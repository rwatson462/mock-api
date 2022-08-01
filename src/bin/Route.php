<?php

readonly class Route {
    public readonly array $headers;

    public function __construct(
        public string $path,
        public ?string $response = null,
        public ?int $status = 200,
        public ?array $methods = [],
        public ?string $method = 'GET',
        array $headers = [],
    ) {
        $transformedHeaders = [];
        foreach($headers as $name => $value) {
            $transformedHeaders[] = new \MockApi\Http\Header(name: $name, value: $value);
        }
        $this->headers = $transformedHeaders;
    }
}
