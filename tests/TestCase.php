<?php

namespace audunru\MonologPushover\Tests;

use audunru\MonologPushover\MonologPushoverProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [MonologPushoverProvider::class];
    }
}
