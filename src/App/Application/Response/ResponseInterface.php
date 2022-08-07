<?php

namespace App\Application\Response;

interface ResponseInterface
{
    public function send(string $content = ''): void;
}
