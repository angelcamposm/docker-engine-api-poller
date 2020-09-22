<?php

namespace Acamposm\DockerEngineApiPoller;

use Acamposm\DockerEngineApiPoller\Enums\ResourceMethods;
use Acamposm\DockerEngineApiPoller\Exceptions\{
    ContainerNotDefinedException,
    DockerApiUnreachableException,
    ImageNotDefinedException,
    MethodNotDefinedException,
    NetworkNotDefinedException,
    VolumeNotDefinedException
};
use Acamposm\DockerEngineApiPoller\Resources\{
    Containers,
    Images,
    Networks,
    System,
    Volumes,
};

class DockerApiRequest
{
    protected array $fields;
    protected string $resource;
    protected DockerServer $server;

    /**
     * DockerApiRequest constructor.
     * @param DockerServer $server
     */
    public function __construct(DockerServer $server)
    {
        $this->fields = [];
        $this->server = $server;
    }

    /**
     * Set the resource to query.
     *
     * @param string $method
     * @param string $id
     * @return DockerApiRequest
     * @throws ContainerNotDefinedException|MethodNotDefinedException
     */
    public function containers(
        string $method = ResourceMethods::CONTAINERS_LIST,
        string $id = ''
    ): DockerApiRequest
    {
        switch ($method) {
            case ResourceMethods::CONTAINERS_INSPECT:
                $this->resource = (new Containers($this->server))->inspect($id);
                break;
            case ResourceMethods::CONTAINERS_LIST:
                $this->resource = (new Containers($this->server))->list();
                break;
            case ResourceMethods::CONTAINERS_STATS:
                $this->resource = (new Containers($this->server))->stats($id);
                break;
            default:
                throw new MethodNotDefinedException();
        }

        return $this;
    }

    /**
     * Set the resource to query.
     *
     * @param string $method
     * @param string $id
     * @return DockerApiRequest
     * @throws ImageNotDefinedException|MethodNotDefinedException
     */
    public function images(
        string $method = ResourceMethods::IMAGES_LIST,
        string $id = ''
    ): DockerApiRequest
    {
        switch ($method) {
            case ResourceMethods::IMAGES_INSPECT:
                $this->resource = (new Images($this->server))->inspect($id);
                break;
            case ResourceMethods::IMAGES_LIST:
                $this->resource = (new Images($this->server))->list();
                break;
            default:
                throw new MethodNotDefinedException();
        }

        return $this;
    }

    /**
     * Set the resource to query.
     *
     * @param string $method
     * @param string $id
     * @return DockerApiRequest
     * @throws NetworkNotDefinedException|MethodNotDefinedException
     */
    public function networks(
        string $method = ResourceMethods::NETWORKS_LIST,
        string $id = ''
    ): DockerApiRequest
    {
        switch ($method) {
            case ResourceMethods::NETWORKS_INSPECT:
                $this->resource = (new Networks($this->server))->inspect($id);
                break;
            case ResourceMethods::NETWORKS_LIST:
                $this->resource = (new Networks($this->server))->list();
                break;
            default:
                throw new MethodNotDefinedException();
        }

        return $this;
    }

    /**
     * Set the resource to query.
     *
     * @param string $method
     * @return $this
     * @throws MethodNotDefinedException
     */
    public function system(string $method = ResourceMethods::SYSTEM_VERSION)
    {
        switch ($method) {
            case ResourceMethods::SYSTEM_DATA_USAGE:
                $this->resource = (new System($this->server))->data_usage();
                break;
            case ResourceMethods::SYSTEM_INFO:
                $this->resource = (new System($this->server))->info();
                break;
            case ResourceMethods::SYSTEM_PING:
                $this->resource = (new System($this->server))->ping();
                break;
            case ResourceMethods::SYSTEM_VERSION:
                $this->resource = (new System($this->server))->version();
                break;
            default:
                throw new MethodNotDefinedException();
        }

        return $this;
    }

    /**
     * Set the resource to query.
     *
     * @param string $method
     * @param string $id
     * @return DockerApiRequest
     * @throws VolumeNotDefinedException|MethodNotDefinedException
     */
    public function volumes(
        string $method = ResourceMethods::VOLUMES_LIST,
        string $id = ''
    ): DockerApiRequest
    {
        switch ($method) {
            case ResourceMethods::VOLUMES_INSPECT:
                $this->resource = (new Volumes($this->server))->inspect($id);
                break;
            case ResourceMethods::VOLUMES_LIST:
                $this->resource = (new Volumes($this->server))->list();
                break;
            default:
                throw new MethodNotDefinedException();
        }

        return $this;
    }

    /**
     * Set the fields of results that must be returned.
     *
     * @param array $fields
     * @return $this
     */
    public function fields(array $fields): DockerApiRequest
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Filters the results with the specified fields in $fields property.
     *
     * @param array $api_data
     * @return array
     */
    private function filter(array $api_data): array
    {
        $keys = $this->fields;

        array_walk($api_data, function (&$value) use ($keys) {
            $value = array_change_key_case(
                array_intersect_key($value, array_flip((array) $keys)),
                CASE_LOWER
            );
        });

        return $api_data;
    }

    /**
     * Check if the Docker API is enabled.
     *
     * @return bool
     */
    private function checkConnectivity(): bool
    {
        return 'OK' === file_get_contents((new System($this->server))->ping());
    }

    /**
     * Convert an array to an object.
     *
     * @param array $array
     * @return object
     */
    private function toObject(array $array): object
    {
        return json_decode(json_encode($array, JSON_FORCE_OBJECT));
    }

    /**
     * Get specified resource from the Docker API.
     *
     * @return object
     * @throws DockerApiUnreachableException
     */
    public function get(): object
    {
        if (!$this->checkConnectivity()) {
            throw new DockerApiUnreachableException();
        }

        $docker_response = json_decode(
            file_get_contents($this->resource),
            true
        );

        if (count($this->fields)) {
            $docker_response = $this->filter($docker_response);
        }

        return self::toObject($docker_response);
    }
}