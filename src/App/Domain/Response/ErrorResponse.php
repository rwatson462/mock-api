<?php

namespace App\Domain\Response;

use App\Domain\ValueObject\Header;

class ErrorResponse extends Response
{
    public int $status = 500;
    public array $headers = [];

    public function __construct()
    {
        $this->headers[] = new Header(name: 'Content-type', value: 'text/plain');
    }
}
