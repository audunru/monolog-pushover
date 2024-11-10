<?php

namespace audunru\MonologPushover\Tests\Unit;

use audunru\MonologPushover\Tests\TestCase;

class MonologPushoverProviderTest extends TestCase
{
    public function testPushoverHandlerSendsCorrectData()
    {
        $config = config('monolog-pushover');

        $this->assertEquals(
            [
                'bindings' => [
                    'Psr\Http\Client\ClientInterface'          => 'GuzzleHttp\Client',
                    'Psr\Http\Message\RequestFactoryInterface' => 'GuzzleHttp\Psr7\HttpFactory',
                    'Psr\Http\Message\StreamFactoryInterface'  => 'GuzzleHttp\Psr7\HttpFactory',
                ],
            ],
            $config
        );
    }
}
