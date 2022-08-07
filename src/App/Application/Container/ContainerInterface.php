<?php

namespace App\Application\Container;

interface ContainerInterface
{
    public function set(string $interface, string $class): void;

    public function get(string $interface, array $args = []);
}