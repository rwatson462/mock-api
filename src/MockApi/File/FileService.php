<?php

namespace MockApi\File;

class FileService
{
    public static function findFiles(string $directory): array
    {
        $filesInDirectory = scandir($directory);

        $files = [];
        foreach($filesInDirectory as $file) {
            if($file[0] === '.') {
                continue;
            }

            if(is_dir($directory . '/' . $file)) {
                $moreFiles = self::findFiles($directory . '/' . $file);
                $files = array_merge($files, $moreFiles);
                continue;
            }

            $files[] = $directory . '/' . $file;
        }

        return $files;
    }

    public static function getContentsOfFiles(array $filenames): array
    {
        $fileContents = [];

        foreach($filenames as $filename) {
            $fileContents[$filename] = file_get_contents($filename);
        }

        return $fileContents;
    }

    public static function flattenIniFiles(array $files): array
    {
        return array_merge(
            ...array_values(
                array_map(
                    static fn($file) => parse_ini_string($file, true),
                    $files
                )
            )
        );
    }
}
