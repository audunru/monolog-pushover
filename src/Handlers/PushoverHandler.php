<?php

namespace audunru\MonologPushover\Handlers;

use Monolog\Handler\PushoverHandler as MonologPushoverHandler;
use Monolog\Level;
use Monolog\LogRecord;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use ReflectionMethod;
use ReflectionProperty;

class PushoverHandler extends MonologPushoverHandler
{
    protected const PUSHOVER_URL = 'https://api.pushover.net/1/messages.json';

    public function __construct(
        private ClientInterface $httpClient,
        private RequestFactoryInterface $requestFactory,
        private StreamFactoryInterface $streamFactory,
        string $token,
        $users,
        ?string $title = null,
        int|string|Level $level = Level::Critical,
        bool $bubble = true,
        bool $useSSL = true,
        int|string|Level $highPriorityLevel = Level::Critical,
        int|string|Level $emergencyLevel = Level::Emergency,
        int $retry = 30,
        int $expire = 25200,
        bool $persistent = false,
        float $timeout = 0.0,
        float $writingTimeout = 10.0,
        ?float $connectionTimeout = null,
        ?int $chunkSize = null,
    ) {
        parent::__construct(
            $token,
            $users,
            $title,
            $level,
            $bubble,
            $useSSL,
            $highPriorityLevel,
            $emergencyLevel,
            $retry,
            $expire,
            $persistent,
            $timeout,
            $writingTimeout,
            $connectionTimeout,
            $chunkSize
        );
    }

    protected function write(LogRecord $record): void
    {
        $users = $this->getUsers();

        foreach ($users as $user) {
            $this->setUser($user);
            $content = $this->getContent($record);
            $request = $this->createRequest($content);
            $this->httpClient->sendRequest($request);
        }

        $this->setUser(null);
    }

    protected function createRequest(string $content): RequestInterface
    {
        $request = $this->requestFactory->createRequest('POST', self::PUSHOVER_URL)
            ->withHeader('Content-Type', 'application/x-www-form-urlencoded');

        $stream = $this->streamFactory->createStream($content);

        return $request->withBody($stream);
    }

    private function getContent(LogRecord $record): string
    {
        $reflectionMethod = new ReflectionMethod(MonologPushoverHandler::class, 'buildContent');
        $reflectionMethod->setAccessible(true);

        return $reflectionMethod->invoke($this, $record);
    }

    private function getUsers(): array
    {
        $reflectionProperty = new ReflectionProperty(MonologPushoverHandler::class, 'users');
        $reflectionProperty->setAccessible(true);

        return $reflectionProperty->getValue($this);
    }

    private function setUser(?string $user): void
    {
        $reflectionProperty = new ReflectionProperty(MonologPushoverHandler::class, 'user');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($this, $user);
    }
}
