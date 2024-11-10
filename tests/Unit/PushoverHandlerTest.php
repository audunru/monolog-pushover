<?php

namespace audunru\MonologPushover\Tests\Unit;

use audunru\MonologPushover\Handlers\PushoverHandler;
use audunru\MonologPushover\Tests\TestCase;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Monolog\Level;
use Monolog\LogRecord;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

class PushoverHandlerTest extends TestCase
{
    public function testPushoverHandlerSendsCorrectData()
    {
        Carbon::setTestNow(Carbon::parse('2019-10-13 12:13:14'));

        $httpClient = $this->mock(ClientInterface::class);
        $requestFactory = $this->mock(RequestFactoryInterface::class);
        $streamFactory = $this->mock(StreamFactoryInterface::class);
        $request = $this->mock(RequestInterface::class);
        $stream = $this->mock(StreamInterface::class);

        $requestFactory->shouldReceive('createRequest')
            ->once()
            ->with('POST', 'https://api.pushover.net/1/messages.json')
            ->andReturn($request);

        $request->shouldReceive('withHeader')
            ->once()
            ->with('Content-Type', 'application/x-www-form-urlencoded')
            ->andReturn($request);

        $streamFactory->shouldReceive('createStream')
            ->once()
            ->with('token=test-token&user=user1&message=Vandelay+Industries+is+a+success%21&title=Test+title&timestamp=1570968794&priority=1')
            ->andReturn($stream);

        $request->shouldReceive('withBody')
            ->once()
            ->with($stream)
            ->andReturn($request);

        $httpClient->shouldReceive('sendRequest')
            ->once()
            ->with($request);

        $handler = new PushoverHandler(
            $httpClient,
            $requestFactory,
            $streamFactory,
            'test-token',
            ['user1'],
            'Test title'
        );

        $record = new LogRecord(
            datetime: new CarbonImmutable(),
            channel: 'pushover',
            level: Level::Critical,
            message: 'Vandelay Industries is a success!',
            context: [],
            extra: []
        );

        $noBubble = $handler->handle($record);

        $this->assertFalse($noBubble);
    }
}
