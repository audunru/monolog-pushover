<?php

namespace audunru\MonologPushover\Tests;

use audunru\MonologPushover\MonologPushoverProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * @SuppressWarnings("unused")
     */
    protected function getPackageProviders($app)
    {
        return [MonologPushoverProvider::class];
    }
}
