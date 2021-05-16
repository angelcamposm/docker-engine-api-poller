<?php

namespace Acamposm\DockerEngineApiPoller\Tests;

use Acamposm\DockerEngineApiPoller\DockerServer;

class DockerServerTest extends TestCase
{
    public const DOCKER_ADDRESS = '192.168.10.100';
    public const DOCKER_PORT = 2375;
    public const DOCKER_PROTOCOL = 'http';
    public const DOCKER_CUSTOM_ADDRESS = '192.168.10.101';
    public const DOCKER_CUSTOM_PORT = 12375;

    protected DockerServer $server;

    public function setUp(): void
    {
        parent::setUp();

        $this->server = (new DockerServer())->insecure()
            ->server(self::DOCKER_ADDRESS)
            ->port(self::DOCKER_PORT);
    }

    /**
     * @test
     */
    public function canChangeTheProtocol()
    {
        $server = $this->server;

        $this->assertNotEquals(
            $server->secure()->getProtocol(),
            self::DOCKER_PROTOCOL
        );
    }

    /**
     * @test
     */
    public function canChangeTheAddress()
    {
        $server = $this->server;

        $this->assertNotEquals(
            $server->server(self::DOCKER_CUSTOM_ADDRESS)->getServer(),
            self::DOCKER_ADDRESS
        );
    }

    /**
     * @test
     */
    public function canChangeThePort()
    {
        $server = $this->server;

        $this->assertNotEquals(
            $server->port(self::DOCKER_CUSTOM_PORT)->getPort(),
            self::DOCKER_PORT
        );
    }

    /**
     * @test
     */
    public function canReturnAnUrl()
    {
        $url = self::DOCKER_PROTOCOL.'://'.self::DOCKER_ADDRESS.':'.self::DOCKER_PORT;

        $this->assertTrue($url === $this->server->getUrl());
    }
}
