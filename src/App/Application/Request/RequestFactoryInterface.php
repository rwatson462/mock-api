<?php

namespace App\Application\Request;

interface RequestFactoryInterface
{
    public function createFromServerVars(): RequestInterface;
}
