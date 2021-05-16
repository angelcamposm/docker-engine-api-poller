<?php

namespace Acamposm\DockerEngineApiPoller\Resources;

use Acamposm\DockerEngineApiPoller\DockerServer;
use Acamposm\DockerEngineApiPoller\Exceptions\NetworkNotDefinedException;
use Acamposm\DockerEngineApiPoller\Interfaces\ApiResourceInterface;

class Networks implements ApiResourceInterface
{
    public const PATH = '/networks';

    private DockerServer $server;

    /**
     * Networks constructor.
     *
     * @param DockerServer $server
     */
    public function __construct(DockerServer $server)
    {
        $this->server = $server;
    }

    /**
     * Returns a list of networks.
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
     * @param string|null $id
     *
     * @throws NetworkNotDefinedException
     *
     * @return string
     */
    public function inspect(?string $id = null): string
    {
        if (null === $id) {
            throw new NetworkNotDefinedException();
        }

        return $this->server->getUrl().self::PATH."/{$id}";
    }
}
