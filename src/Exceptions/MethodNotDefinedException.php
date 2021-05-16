<?php

namespace Acamposm\DockerEngineApiPoller\Exceptions;

use Exception;

class MethodNotDefinedException extends Exception
{
    public function __construct($message = 'Method not defined in API resource.')
    {
        parent::__construct($message);
    }
}
