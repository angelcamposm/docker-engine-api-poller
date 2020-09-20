<?php

namespace Acamposm\DockerEngineApiPoller\Interfaces;

interface ApiResourceInterface
{
    /**
     * Returns a list of resources.
     *
     * @return string
     */
    public function list(): string;

    /**
     * Return low-level information about a resource.
     *
     * @param string $id
     * @return string
     */
    public function inspect(string $id): string;
}