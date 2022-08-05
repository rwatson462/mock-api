<?php

namespace MockApi\Http\Response;

use MockApi\Http\Header;
use MockApi\Http\Response;

class ErrorResponse extends Response
{
    public int $status = 500;
    public array $headers = [];

    public function __construct()
    {
        $this->headers[] = new Header(name: 'Content-type', value: 'text/plain');
    }
}