<?php

namespace App\Framework\DependencyInjection;

use InvalidArgumentException;

class InvalidInterfaceRegisteredException extends InvalidArgumentException
{
    public function __construct(string $interface)
    {
        parent::__construct("Invalid interface $interface registered in Container");
    }
}