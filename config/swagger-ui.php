<?php

return [
    'title' => 'API Doc',

    'routes' => [
        'swagger' => 'docs.swagger',

        'assets' => 'docs.assets',

        'api' => 'docs.api',
    ],

    'paths' => [
        'swagger_ui_assets_path' => null,

        /*
         * File name of the generated YAML documentation file
        */
        'docs' => 'api-docs.yaml',

        /*
         * Absolute paths to directory containing the swagger annotations are stored.
        */
        'annotations' => [
            base_path('app'),
        ],
    ],

];
