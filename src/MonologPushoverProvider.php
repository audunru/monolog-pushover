<?php

namespace audunru\MonologPushover;

use audunru\MonologPushover\Handlers\PushoverHandler;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MonologPushoverProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('monolog-pushover')
            ->hasConfigFile();
    }

    public function registeringPackage()
    {
        $bindings = config('monolog-pushover.bindings', []);

        foreach ($bindings as $abstract => $implementation) {
            $this->app->when(PushoverHandler::class)
                ->needs($abstract)
                ->give($implementation);
        }
    }
}
