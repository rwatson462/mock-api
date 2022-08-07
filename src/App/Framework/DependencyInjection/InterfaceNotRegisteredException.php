<?php

namespace App\Framework\DependencyInjection;

use InvalidArgumentException;

class InterfaceNotRegisteredException extends InvalidArgumentException
{
    public function __construct(string $interface)
    {
        parent::__construct("Class $interface not registered in Container");
    }
}