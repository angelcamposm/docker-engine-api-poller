<?php

namespace Acamposm\DockerEngineApiPoller\Tests;

use Acamposm\DockerEngineApiPoller\DockerEngineApiPollerServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    protected function getPackageProviders($app)
    {
        return [
            DockerEngineApiPollerServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        //$app['config']->set('ping', [
        //    'count' => 5,
        //]);
    }
}