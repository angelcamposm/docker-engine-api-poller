<?php

namespace Acamposm\DockerEngineApiPoller;

class DockerServer
{
    protected string $protocol;
    protected string $server;
    protected int $port;

    /**
     * DockerServer constructor.
     */
    public function __construct()
    {
        $this->protocol = 'http';
        $this->server = '127.0.0.1';
        $this->port = 2375;
    }

    /**
     * Set HTTP as protocol
     *
     * @return DockerServer
     */
    public function insecure(): DockerServer
    {
        $this->protocol = 'http';

        return $this;
    }

    /**
     * Set HTTPS as protocol
     *
     * @return DockerServer
     */
    public function secure(): DockerServer
    {
        $this->protocol = 'https';

        return $this;
    }

    /**
     * Set server to query
     *
     * @param string $server
     * @return DockerServer
     */
    public function server(string $server): DockerServer
    {
        $this->server = $server;

        return $this;
    }

    /**
     * Set port where API listen for queries
     *
     * @param int $port
     * @return DockerServer
     */
    public function port(int $port): DockerServer
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Returns the server address.
     *
     * @return string
     */
    public function getServer(): string
    {
        return $this->server;
    }

    /**
     * Returns the server port.
     *
     * @return string
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * Returns the server protocol.
     *
     * @return string
     */
    public function getProtocol(): string
    {
        return $this->protocol;
    }

    /**
     * Returns the server URL.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return "{$this->protocol}://{$this->server}:{$this->port}";
    }
}