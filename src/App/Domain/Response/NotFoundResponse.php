<?php

namespace App\Domain\Response;

use App\Domain\ValueObject\Header;

class NotFoundResponse extends Response
{
    public int $status = 404;
    public array $headers = [];

    public function __construct()
    {
        $this->headers[] = new Header(name: 'Content-type', value: 'text/plain');
    }
}
