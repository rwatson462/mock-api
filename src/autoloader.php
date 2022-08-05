<?php

spl_autoload_register(static function(string $classname) {
    $filename = __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $classname) . '.php';
    if(@file_exists($filename)) {
        @include $filename;
    }
});