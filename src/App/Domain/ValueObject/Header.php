<?php

namespace App\Domain\ValueObject;

class Header {
    public function __construct(
        public readonly string $name,
        public readonly string $value,
    ) { }

    public function __toString(): string
    {
        return $this->name . ': ' . $this->value;
    }
}
