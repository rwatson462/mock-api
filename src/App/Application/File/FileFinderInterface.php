<?php

namespace App\Application\File;

use App\Framework\File\File;

interface FileFinderInterface
{
    public function findFiles(string $directory): array;

    public function find(string $filename): File;
}