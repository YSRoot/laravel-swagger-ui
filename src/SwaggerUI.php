<?php

namespace YSRoot\SwaggerUI;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

class SwaggerUI
{
    public static function routes(?callable $callback = null, array $options = []): void
    {
        $callback = $callback ?: function ($router) {
            $router->all();
        };

        Route::group($options, function (Router $router) use ($callback) {
            $callback(new RouteRegistrar($router));
        });
    }
}
