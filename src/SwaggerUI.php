<?php

namespace YSRoot\SwaggerUI;

use Closure;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use YSRoot\SwaggerUI\Http\Middleware\EnsureIsAuthorized;

class SwaggerUI
{
    public static ?Closure $gateCallback = null;

    public static function routes(?callable $callback = null, array $options = []): void
    {
        $callback = $callback ?: function ($router) {
            $router->all();
        };

        $options = array_merge(['middleware' => [EnsureIsAuthorized::class]], $options);

        Route::group($options, function (Router $router) use ($callback) {
            $callback(new RouteRegistrar($router));
        });
    }

    public static function gate(): Closure
    {
        return static::$gateCallback ?? function (?Authorizable $authorizable, Request $request) {
            return true;
        };
    }
}
