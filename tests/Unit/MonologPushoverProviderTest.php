<?php

namespace audunru\MonologPushover\Tests\Unit;

use audunru\MonologPushover\Tests\TestCase;

class MonologPushoverProviderTest extends TestCase
{
    public function test_pushover_handler_sends_correct_data()
    {
        $config = config('monolog-pushover');

        $this->assertEquals(
            [
                'bindings' => [
                    'Psr\Http\Client\ClientInterface' => 'GuzzleHttp\Client',
                    'Psr\Http\Message\RequestFactoryInterface' => 'GuzzleHttp\Psr7\HttpFactory',
                    'Psr\Http\Message\StreamFactoryInterface' => 'GuzzleHttp\Psr7\HttpFactory',
                ],
            ],
            $config
        );
    }
}
