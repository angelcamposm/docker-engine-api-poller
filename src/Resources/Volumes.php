<?php

namespace Acamposm\DockerEngineApiPoller\Resources;

use Acamposm\DockerEngineApiPoller\DockerServer;
use Acamposm\DockerEngineApiPoller\Exceptions\VolumeNotDefinedException;
use Acamposm\DockerEngineApiPoller\Interfaces\ApiResourceInterface;

class Volumes implements ApiResourceInterface
{
    public const PATH = '/volumes';

    private DockerServer $server;

    /**
     * Volumes constructor.
     *
     * @param DockerServer $server
     */
    public function __construct(DockerServer $server)
    {
        $this->server = $server;
    }

    /**
     * Returns a list of volumes.
     *
     * @return string
     */
    public function list(): string
    {
        return $this->server->getUrl().self::PATH;
    }

    /**
     * Return low-level information about a network.
     *
     * @param string $id
     *
     * @throws VolumeNotDefinedException
     *
     * @return string
     */
    public function inspect(string $id = ''): string
    {
        if ($id === '') {
            throw new VolumeNotDefinedException();
        }

        return $this->server->getUrl().self::PATH."/{$id}";
    }
}
