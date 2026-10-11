# monolog-pushover

A Monolog handler that sends log messages to [Pushover](https://pushover.net) via a PSR-18 HTTP client, integrated into Laravel's logging system as a `monolog` channel driver.

## Public API

No facades. Consumers wire this directly into `config/logging.php`:

```php
'pushover' => [
    'driver'  => 'monolog',
    'handler' => \audunru\MonologPushover\Handlers\PushoverHandler::class,
    'with'    => [
        'token' => env('PUSHOVER_TOKEN'),
        'users' => env('PUSHOVER_USER'),
    ],
],
```

Then call `Log::channel('pushover')->error('...')`.

The concrete handler is `src/Handlers/PushoverHandler.php`. It extends Monolog's own `PushoverHandler` but replaces the socket-based transport with PSR-18/PSR-17 interfaces (`ClientInterface`, `RequestFactoryInterface`, `StreamFactoryInterface`), injected via the constructor.

## Service Provider

`MonologPushoverProvider` publishes config and reads `monolog-pushover.bindings` to wire PSR interface → implementation bindings contextually for `PushoverHandler`. Config key: `monolog-pushover`. Publish tag: `monolog-pushover-config`.

## Dependencies

- Internal: none
- External: defaults to `guzzlehttp/guzzle` + `guzzlehttp/psr7` (via config bindings); any PSR-18/PSR-17 compatible client can be substituted by changing `config/monolog-pushover.php`

## Testing

```bash
composer test
```

Tests use Mockery to mock the PSR HTTP interfaces and assert the correct POST body is sent to `https://api.pushover.net/1/messages.json`. No real HTTP calls are made. See `tests/Unit/PushoverHandlerTest.php`.

## Conventions / Gotchas

- `PushoverHandler` uses reflection to access `buildContent`, `users`, and `user` on the parent Monolog class — these are private/protected in the upstream handler. If Monolog changes those internals, tests will catch it.
- The `bindings` config is applied contextually (only for `PushoverHandler`), so swapping the HTTP client does not affect other parts of the application.
- `users` in `logging.php` can be a single user token string or an array; the handler iterates and sends one request per user.
