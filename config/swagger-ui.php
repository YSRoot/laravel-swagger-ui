<?php

return [
    'title' => 'API Doc',

    'servers' => [
        [
            'url' => env('APP_URL', '/'),
        ],
    ],

    'routes' => [
        'swagger' => 'docs.swagger',

        'assets' => 'docs.assets',

        'api' => 'docs.api',
    ],

    'paths' => [
        // По умолчанию возьмет из vendor
        'swagger_ui_assets_path' => null,

        /*
         * File name of the generated YAML documentation file
        */
        'docs' => 'api-docs.yaml',

        'refs_dir_prefix' => '/docs/',
    ],

];
