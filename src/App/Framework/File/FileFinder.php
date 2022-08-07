<?php

namespace App\Framework\File;

use App\Application\File\FileFinderInterface;

class FileFinder implements FileFinderInterface
{
    public function findFiles(string $directory): array
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

            $files[] = new File($directory . '/' . $file);
        }

        return $files;
    }

    public function find(string $filename): File
    {
        if(!file_exists($filename) || !is_file($filename)) {
            throw new FileNotFoundException($filename);
        }

        return new File($filename);
    }
}
