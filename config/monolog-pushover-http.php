<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

return [
    'bindings' => [
        ClientInterface::class         => Client::class,
        RequestFactoryInterface::class => HttpFactory::class,
        StreamFactoryInterface::class  => HttpFactory::class,
    ],
];
