<?php

namespace YSRoot\SwaggerUI;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use YSRoot\SwaggerUI\Services\DocManager;

class SwaggerUIServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('swagger-ui')
            ->hasConfigFile('swagger-ui')
            ->hasViews();
    }

    public function packageBooted(): void
    {
        $this->app->singleton('docs', function () {
            return new DocManager(Container::getInstance());
        });

        Gate::define('viewSwaggerUI', SwaggerUI::gate());
    }
}
