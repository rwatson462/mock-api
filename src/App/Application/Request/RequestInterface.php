<?php

namespace App\Application\Request;

interface RequestInterface
{
    public function method(): string;
    public function path(): string;
}
