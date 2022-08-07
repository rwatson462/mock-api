<?php

namespace App\Application\File;

interface FileServiceInterface
{
    public function flattenIniFiles(array $files): array;
}