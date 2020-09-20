<?php

namespace Acamposm\DockerEngineApiPoller\Exceptions;

use Exception;

class NetworkNotDefinedException extends Exception
{
    public function __construct(string $message = 'Network ID or Name not defined.')
    {
        parent::__construct($message);
    }
}