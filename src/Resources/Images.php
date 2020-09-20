<?php

namespace Acamposm\DockerEngineApiPoller\Resources;

use Acamposm\DockerEngineApiPoller\DockerServer;
use Acamposm\DockerEngineApiPoller\Exceptions\ImageNotDefinedException;
use Acamposm\DockerEngineApiPoller\Interfaces\ApiResourceInterface;

class Images implements ApiResourceInterface
{
    const PATH = '/images';

    private DockerServer $server;

    /**
     * Images constructor.
     * @param DockerServer $server
     */
    public function __construct(DockerServer $server)
    {
        $this->server = $server;
    }

    /**
     * Returns a list of images on the server.
     *
     * @return string
     */
    public function list(): string
    {
        return $this->server->getUrl().self::PATH.'/json';
    }

    /**
     * Return low-level information about an image.
     *
     * @param string $id
     * @return string
     * @throws ImageNotDefinedException
     */
    public function inspect(string $id = ''): string
    {
        if ($id === '') {
            throw new ImageNotDefinedException();
        }

        return $this->server->getUrl().self::PATH."/{$id}/json";
    }
}