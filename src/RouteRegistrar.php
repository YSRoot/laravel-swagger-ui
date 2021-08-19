<?php

namespace YSRoot\SwaggerUI;

use Illuminate\Routing\Router;
use YSRoot\SwaggerUI\Http\Controllers\SwaggerUiAssetController;
use YSRoot\SwaggerUI\Http\Controllers\SwaggerUIController;

class RouteRegistrar
{
    private Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function all(): void
    {
        $this->forDocs();
    }

    public function forDocs(): void
    {
        $this->router->group(['prefix' => 'docs', 'as' => 'docs.'], function (Router $router) {
            $router->get('swagger.yaml', [SwaggerUIController::class, 'docs'])
                ->name('swagger');

            $router->get('api', [SwaggerUIController::class, 'api'])
                ->name('api');

            $router->get('assets/{asset}', SwaggerUiAssetController::class)
                ->name('assets');
        });
    }
}
