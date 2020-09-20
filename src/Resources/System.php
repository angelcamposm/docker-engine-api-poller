<?php

namespace Acamposm\DockerEngineApiPoller\Resources;

use Acamposm\DockerEngineApiPoller\DockerServer;

class System
{
    private DockerServer $server;

    /**
     * System constructor.
     * @param DockerServer $server
     */
    public function __construct(DockerServer $server)
    {
        $this->server = $server;
    }

    /**
     * Get data usage information.
     *
     * @return string
     */
    public function data_usage(): string
    {
        return $this->server->getUrl().'/system/df';
    }

    /**
     * Returns Docker system information.
     *
     * @return string
     */
    public function info(): string
    {
        return $this->server->getUrl().'/info';
    }

    /**
     * This is a dummy endpoint you can use to test if the server is accessible.
     *
     * @return string
     */
    public function ping(): string
    {
        return $this->server->getUrl().'/_ping';
    }

    /**
     * Returns the version of Docker that is running and various information
     * about the system that Docker is running on.
     *
     * @return string
     */
    public function version(): string
    {
        return $this->server->getUrl().'/version';
    }
}