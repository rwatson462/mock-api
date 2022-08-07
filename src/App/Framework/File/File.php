<?php

namespace App\Framework\File;

class File
{
    private ?string $contents = null;

    public function __construct(
        public readonly string $filename,
    ) {
    }

    public function contents(): string
    {
        if(!isset($this->contents)) {
            $this->contents = file_get_contents($this->filename);
        }

        return $this->contents;
    }
}
