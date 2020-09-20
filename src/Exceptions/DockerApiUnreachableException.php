<?php

namespace Acamposm\DockerEngineApiPoller\Exceptions;

use Exception;

class DockerApiUnreachableException extends Exception
{
    public function __construct($message = 'The Docker API is unreachable, or not available.')
    {
        parent::__construct($message);
    }
}