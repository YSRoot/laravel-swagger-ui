<?php

namespace YSRoot\SwaggerUI;

use Illuminate\Container\Container;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use YSRoot\SwaggerUI\Services\DocManager;

class LaravelSwaggerUIServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('swagger-ui')
            ->hasConfigFile('swagger-ui');
    }

    public function packageBooted(): void
    {
        $this->app->singleton('docs', function () {
            return new DocManager(Container::getInstance());
        });
    }
}
