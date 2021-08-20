<?php

return [
    // Заголовок для документации
    'title' => 'API Doc',

    // Список серверов на странице документации
    'servers' => [
        [
            'url' => env('APP_URL', '/'),
        ],
    ],

    // Имена роутов которые отвечают за работу документации
    'routes' => [
        'swagger' => 'docs.swagger',

        'assets' => 'docs.assets',

        'api' => 'docs.api',
    ],

    'paths' => [
        // Путь к swagger-ui dist ассетам. По умолчанию возьмет из vendor/swagger-api/swagger-ui/dist/
        // 'swagger_ui_assets_path' => '/custom/path/../dist/',

        // Путь к файлу с YAML файлу с документацией
        // 'docs' => '/path/.../api-docs.yaml',
        'docs' => null,

        // Путь к директории где находятся все YAML файлы для `$ref`
        // 'refs_dir_prefix' => '/path/.../',
        'refs_dir_prefix' => null,
    ],

];
