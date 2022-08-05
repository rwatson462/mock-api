<?php

namespace MockApi\Http\Response;

use MockApi\Http\Header;
use MockApi\Http\Response;

class NotFoundResponse extends Response
{
    public int $status = 404;
    public array $headers = [];

    public function __construct()
    {
        $this->headers[] = new Header(name: 'Content-type', value: 'text/plain');
    }
}