<?php

namespace App\Domain\File;

use App\Application\File\FileServiceInterface;
use App\Framework\File\File;

class FileService implements FileServiceInterface
{
    public function flattenIniFiles(array $files): array
    {
        return array_merge(
            ...array_values(
                array_map(
                    static fn(File $file): array => parse_ini_file($file->filename, true),
                    $files
                )
            )
        );
    }
}
