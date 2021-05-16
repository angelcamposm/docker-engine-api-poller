<?php

namespace Acamposm\DockerEngineApiPoller\Resources;

use Acamposm\DockerEngineApiPoller\DockerServer;
use Acamposm\DockerEngineApiPoller\Exceptions\ContainerNotDefinedException;
use Acamposm\DockerEngineApiPoller\Interfaces\ApiResourceInterface;

class Containers implements ApiResourceInterface
{
    public const PATH = '/containers';

    private DockerServer $server;

    /**
     * Containers constructor.
     *
     * @param DockerServer $server
     */
    public function __construct(DockerServer $server)
    {
        $this->server = $server;
    }

    /**
     * Returns a list of containers.
     *
     * @param bool $all
     *
     * @return string
     */
    public function list(bool $all = false): string
    {
        if ($all) {
            return $this->server->getUrl().self::PATH.'/json?all=true';
        }

        return $this->server->getUrl().self::PATH.'/json';
    }

    /**
     * Return low-level information about a container.
     *
     * @param string|null $id
     *
     * @throws ContainerNotDefinedException
     *
     * @return string
     */
    public function inspect(string $id = ''): string
    {
        if ($id === '') {
            throw new ContainerNotDefinedException();
        }

        return $this->server->getUrl().self::PATH."/{$id}/json";
    }

    /**
     * Get container stats based on resource usage.
     *
     * @param string $id
     *
     * @throws ContainerNotDefinedException
     *
     * @return string
     */
    public function stats(string $id = ''): string
    {
        if ($id === '') {
            throw new ContainerNotDefinedException();
        }

        return $this->server->getUrl().self::PATH."/{$id}/stats?stream=false";
    }
}
