<?php

namespace Acamposm\DockerEngineApiPoller\Enums;

class ResourceMethods
{
    // Containers Resources
    const CONTAINERS_INSPECT = 'inspect';
    const CONTAINERS_LIST = 'list';
    const CONTAINERS_STATS = 'stats';

    // Images Resources
    const IMAGES_INSPECT = 'inspect';
    const IMAGES_LIST = 'list';

    // Network Resources
    const NETWORKS_INSPECT = 'inspect';
    const NETWORKS_LIST = 'list';

    // Volumes Resources
    const VOLUMES_INSPECT = 'inspect';
    const VOLUMES_LIST = 'list';

    // System Resources
    const SYSTEM_DATA_USAGE = 'df';
    const SYSTEM_INFO = 'info';
    const SYSTEM_PING = 'ping';
    const SYSTEM_VERSION = 'version';
}