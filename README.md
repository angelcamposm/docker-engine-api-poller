# Docker Poller for Laravel

This package allows Laravel applications to interact with the Docker Engine API.

The Docker Engine API is an HTTP API served by Docker Engine. It is the API the Docker client uses 
to communicate with the Engine, so everything the Docker client can do can be done with the API.

- [Installation](#installation)
- [Requirements](#requirements)
- [Usage](#usage)
  - [Basic Initialization](#basic-initialization)
  - [API Resources](#api-resources)
    - [Containers](#containers)
    - [Images](#images)
    - [Networks](#networks)
    - [Volumes](#volumes)
- [Testing](#testing)
 
## Installation

You can install the package via [composer](https://getcomposer.org/) and then publish the assets:

```bash

composer require acamposm/docker-poller

php artisan vendor:publish --provider="Acamposm\DockerEngineApiPoller\DockerPollerServiceProvider"

```

***Note:*** We try to follow [SemVer v2.0.0](https://semver.org/).

## Requirements

To use this packet, you must enable first the Docker Engine API, normally the Engine API listens on 
port 2375, but it is configurable.

***Note:*** In production environments, you must always secure the API with SSL encryption and 
control who can perform request to this API.

## Usage

### Basic Initialization

First, create a DockerServer instance with the details of the docker server hosts. 

***Note:*** By default, the DockerServer class uses the default port (2375) and the protocol (http) of the Docker Engine API.

#### Docker Engine API over HTTP

```php
use Acamposm\DockerEngineApiPoller\DockerServer;

$server = (new DockerServer())->server('localhost');
```

or

```php
use Acamposm\DockerEngineApiPoller\DockerServer;

$server = (new DockerServer())->insecure()->port(12375)->server('localhost');
```

#### Docker Engine API over HTTPS
```php
use Acamposm\DockerEngineApiPoller\DockerServer;

$server = (new DockerServer())->secure()->server('localhost');
```

or 

```php
use Acamposm\DockerEngineApiPoller\DockerServer;

$server = (new DockerServer())->secure()->port(12375)->server('localhost');
```

### API Resources

#### Containers

##### Get Containers List

Get a list of the running containers in the docker host.

```php
use Acamposm\DockerEngineApiPoller\DockerServer;
use Acamposm\DockerEngineApiPoller\DockerApiRequest;
use Acamposm\DockerEngineApiPoller\Enums\ResourceMethods;

$server = (new DockerServer())->server('192.168.10.101');

$containers_list = (new DockerApiRequest($server))
  ->containers(ResourceMethods::CONTAINERS_LIST)
  ->get();
```

##### Get Container Details

To get the full details of a container...

```php
use Acamposm\DockerEngineApiPoller\DockerServer;
use Acamposm\DockerEngineApiPoller\DockerApiRequest;
use Acamposm\DockerEngineApiPoller\Enums\ResourceMethods;

$server = (new DockerServer())->server('192.168.10.101');

$container_details = (new DockerApiRequest($server))
  ->containers(ResourceMethods::CONTAINERS_INSPECT, 'container_name')
  ->get();
```

##### Get Container Stats

Get the resources used by a single container, then use the class ContainerMetrics to get the usage of a container.

```php
use Acamposm\DockerEngineApiPoller\ContainerMetrics;
use Acamposm\DockerEngineApiPoller\DockerServer;
use Acamposm\DockerEngineApiPoller\DockerApiRequest;
use Acamposm\DockerEngineApiPoller\Enums\ResourceMethods;
$server = (new DockerServer())->server('192.168.10.101');

$container_stats = (new DockerApiRequest($server))
  ->containers(ResourceMethods::CONTAINERS_STATS, 'container_name')
  ->get();

$metrics = (new ContainerMetrics($container_stats))->metrics();

var_dump($metrics);
```

The result will be a json object with the container statistics, ready to save to a database.

```json
{
  "timestamp": "2020-09-20T19:00:05.491127778Z",
  "id": "2206b35c6fecc6ce320effb68492d8a79fd5f2e5f230dda9371fca8c822428df",
  "name": "/nextcloud",
  "cpu": {
    "count": 2,
    "percent_free": 99.9960912,
    "percent_used": 0.0039088
  },
  "memory": {
    "free": 8236134400,
    "used": 105889792,
    "total": 8342024192,
    "percent_free": 98.730646308823,
    "percent_used": 1.2693536911766
  },
  "network": [
    {
      "eth0": {
        "rx_bytes": 3337270,
        "rx_packets": 3306,
        "rx_errors": 0,
        "rx_dropped": 0,
        "tx_bytes": 1002431,
        "tx_packets": 2090,
        "tx_errors": 0,
        "tx_dropped": 0
      }
    }
  ]
}
```


#### Images

##### Get Images List

To get a list with all images on the docker host.

```php
use Acamposm\DockerEngineApiPoller\DockerServer;
use Acamposm\DockerEngineApiPoller\DockerApiRequest;
use Acamposm\DockerEngineApiPoller\Enums\ResourceMethods;

$server = (new DockerServer())->server('192.168.10.101');

$images = (new DockerApiRequest($server))
  ->images(ResourceMethods::IMAGES_LIST)
  ->get();
```

##### Get Image Details

To get the full details of an image.

```php
use Acamposm\DockerEngineApiPoller\DockerServer;
use Acamposm\DockerEngineApiPoller\DockerApiRequest;
use Acamposm\DockerEngineApiPoller\Enums\ResourceMethods;

$server = (new DockerServer())->server('192.168.10.101');

$image_details = (new DockerApiRequest($server))
  ->images(ResourceMethods::IMAGES_INSPECT, 'image_name')
  ->get();
```

#### Networks

##### Get Networks List

```php
use Acamposm\DockerEngineApiPoller\DockerServer;
use Acamposm\DockerEngineApiPoller\DockerApiRequest;
use Acamposm\DockerEngineApiPoller\Enums\ResourceMethods;

$server = (new DockerServer())->server('192.168.10.101');

$networks = (new DockerApiRequest($server))
  ->networks(ResourceMethods::NETWORKS_LIST)
  ->get();
```
##### Get Network Details

To get the full details of a network in the docker host.

```php
use Acamposm\DockerEngineApiPoller\DockerServer;
use Acamposm\DockerEngineApiPoller\DockerApiRequest;
use Acamposm\DockerEngineApiPoller\Enums\ResourceMethods;

$server = (new DockerServer())->server('192.168.10.101');

$network_details = (new DockerApiRequest($server))
  ->networks(ResourceMethods::NETWORKS_INSPECT, 'network_name')
  ->get();
```

#### Volumes

##### Get Volumes List

Get a list of volumes in the docker host.

```php
use Acamposm\DockerEngineApiPoller\DockerServer;
use Acamposm\DockerEngineApiPoller\DockerApiRequest;
use Acamposm\DockerEngineApiPoller\Enums\ResourceMethods;

$server = (new DockerServer())->server('192.168.10.101');

$volumes = (new DockerApiRequest($server))
  ->volumes(ResourceMethods::VOLUMES_LIST)
  ->get();
```

##### Get Volume Details

Get a list of volumes in the docker host.

```php
use Acamposm\DockerEngineApiPoller\DockerServer;
use Acamposm\DockerEngineApiPoller\DockerApiRequest;
use Acamposm\DockerEngineApiPoller\Enums\ResourceMethods;

$server = (new DockerServer())->server('192.168.10.101');

$volume_details = (new DockerApiRequest($server))
  ->volumes(ResourceMethods::VOLUMES_INSPECT, 'volume_name')
  ->get();
```

## Testing

``` bash

composer test

```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Thank you for considering contributing to the improvement of the package. Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

If you discover any security related issues, please send an e-mail to Angel Campos via angel.campos.m@outlook.com instead of using the issue tracker. All security vulnerabilities will be promptly addressed.

## Credits

- [Angel Campos](https://github.com/angelcamposm)

## License

The package Ping is open-source package and is licensed under The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
