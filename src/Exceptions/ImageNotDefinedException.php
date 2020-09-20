<?php

namespace Acamposm\DockerEngineApiPoller\Exceptions;

use Exception;

class ImageNotDefinedException extends Exception
{
    public function __construct($message = 'Image ID or name not defined.')
    {
        parent::__construct($message);
    }
}