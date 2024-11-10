# Pushover handler for Monolog

[![Build Status](https://github.com/audunru/monolog-pushover-http/actions/workflows/validate.yml/badge.svg)](https://github.com/audunru/monolog-pushover-http/actions/workflows/validate.yml)
[![Coverage Status](https://coveralls.io/repos/github/audunru/monolog-pushover-http/badge.svg?branch=main)](https://coveralls.io/github/audunru/monolog-pushover-http?branch=main)
[![StyleCI](https://github.styleci.io/repos/12345/shield?branch=main)](https://github.styleci.io/repos/12345)

Monolog (a PHP logging library) uses _handlers_ to send log messages to various destinations. This is one such handler, for sending Monolog log messages to [Pushover](https://pushover.net).

This package uses [Guzzle](https://docs.guzzlephp.org/) by default, but you can replace that with another PSR compatible HTTP client if you wish.

# Installation

## Step 1: Install with Composer

```bash
composer require audunru/monolog-pushover-http
```

## Step 2: Publish configuration

Publish the configuration file by running:

```php
php artisan vendor:publish --tag=monolog-pushover-http-config
```

# Configuration

Add pushover to the channels section of `config/logging.php`:

```php
'channels' => [
    'pushover' => [
        'driver'  => 'monolog',
        'handler' => \audunru\MonologPushoverHttp\Handlers\PushoverHandler::class,
        'with'    => [
            'token' => env('PUSHOVER_TOKEN'),
            'users' => env('PUSHOVER_USER'),
        ],
    ],
],
```

Log something to Pushover:

```php
Log::channel("pushover")->error("Test");
```

# Alternatives

[jonshawpzbp/monolog-pushovercurl](https://github.com/JonShawPZBP/MonologPushoverCurl)

[Monolog's own PushoverHandler](https://github.com/Seldaek/monolog/blob/main/src/Monolog/Handler/PushoverHandler.php)
