<?php

namespace MockApi\Http;

readonly class Header {
    public function __construct(
        public string $name,
        public string $value,
    ) { }

    public function __toString(): string
    {
        return $this->name . ': ' . $this->value;
    }
}
