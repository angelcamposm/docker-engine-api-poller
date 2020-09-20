<?php

namespace Acamposm\DockerEngineApiPoller\Exceptions;

use Exception;

class VolumeNotDefinedException extends Exception
{
    public function __construct(string $message = 'Volume ID or name not defined.')
    {
        parent::__construct($message);
    }
}