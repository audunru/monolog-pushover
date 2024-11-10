# Pushover handler for Monolog in Laravel

[![Build Status](https://github.com/audunru/monolog-pushover-http/actions/workflows/validate.yml/badge.svg)](https://github.com/audunru/monolog-pushover-http/actions/workflows/validate.yml)
[![Coverage Status](https://coveralls.io/repos/github/audunru/monolog-pushover-http/badge.svg?branch=master)](https://coveralls.io/github/audunru/monolog-pushover-http?branch=master)
[![StyleCI](https://github.styleci.io/repos/415400658/shield?branch=master)](https://github.styleci.io/repos/415400658)

Retrieve secrets from AWS Secrets Manager and override config variables in Laravel.

As an example, you could store your database password in AWS Secrets Manager instead of your .env file. This package does not modify your .env file or config files. Instead, the configuration values are set using Laravel's `config()` helper right after your application has started.

# Installation

```bash
composer require audunru/monolog-pushover-http
```

# Configuration

Add pushover in `config/logging.php`, then configure Laravel to use pushover as the default logging channel.

```php
'default' => env('LOG_CHANNEL', 'pushover'),
'channels' => [
    'pushover' => [
        'driver'  => 'monolog',
        'handler' => audunru\MonologPushoverHttp\Handlers\PushoverHandler::class,
        'with'    => [
            'token' => env('PUSHOVER_TOKEN'),
            'users' => env('PUSHOVER_USER'),
        ],
    ],
],
```

# Alternatives

[AWS Secrets Manager](https://github.com/TappNetwork/laravel-aws-secrets-manager)
