<?php

namespace Acamposm\DockerEngineApiPoller\Enums;

class ResourceMethods
{
    // Containers Resources
    public const CONTAINERS_INSPECT = 'inspect';
    public const CONTAINERS_LIST = 'list';
    public const CONTAINERS_STATS = 'stats';

    // Images Resources
    public const IMAGES_INSPECT = 'inspect';
    public const IMAGES_LIST = 'list';

    // Network Resources
    public const NETWORKS_INSPECT = 'inspect';
    public const NETWORKS_LIST = 'list';

    // Volumes Resources
    public const VOLUMES_INSPECT = 'inspect';
    public const VOLUMES_LIST = 'list';

    // System Resources
    public const SYSTEM_DATA_USAGE = 'df';
    public const SYSTEM_INFO = 'info';
    public const SYSTEM_PING = 'ping';
    public const SYSTEM_VERSION = 'version';
}
