<?php

namespace Acamposm\DockerEngineApiPoller\Exceptions;

use Exception;

class ContainerNotDefinedException extends Exception
{
    public function __construct(string $message = 'Container ID or name not defined.')
    {
        parent::__construct($message);
    }
}