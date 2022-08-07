<?php

namespace App\Framework\DependencyInjection;

use App\Application\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private array $containers = [];

    public function set(string $interface, string $class): void
    {
        $this->containers[$interface] = $class;
    }

    public function get(string $interface, array $args = [])
    {
        if(!isset($this->containers[$interface])) {
            throw new InterfaceNotRegisteredException($interface);
        }

        $class = $this->containers[$interface];

        // Pass in this container instance to the class we're creating as it's first parameter
        // This does require that _every_ class that uses the container has this parameter
        return new $class($this, ...$args);
    }
}
