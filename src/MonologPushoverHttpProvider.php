<?php

namespace audunru\MonologPushoverHttp;

use audunru\MonologPushoverHttp\Handlers\PushoverHandler;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MonologPushoverHttpProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('monolog-pushover-http')
            ->hasConfigFile();
    }

    public function registeringPackage()
    {
        $bindings = config('monolog-pushover-http.bindings', []);

        foreach ($bindings as $abstract => $implementation) {
            $this->app->when(PushoverHandler::class)
                ->needs($abstract)
                ->give($implementation);
        }
    }
}
