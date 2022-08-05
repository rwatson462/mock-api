<?php

namespace MockApi\Http;

class Response
{
    public int $status = 200;
    public array $headers = [];

    public function send(string $content = ''): void
    {
        http_response_code($this->status);

        foreach($this->headers as $header) {
            header($header);
        }

        header('Content-length: ' . (int)mb_strlen($content));
        echo $content;
    }
}
