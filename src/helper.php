<?php

if (!function_exists('swagger_ui_dist_path')) {
    /**
     * Returns swagger-ui composer dist path.
     *
     * @throws  RuntimeException
     */
    function swagger_ui_dist_path(?string $asset = null): string
    {
        $allowed_files = [
            'favicon-16x16.png',
            'favicon-32x32.png',
            'oauth2-redirect.html',
            'swagger-ui-bundle.js',
            'swagger-ui-bundle.js.map',
            'swagger-ui-standalone-preset.js',
            'swagger-ui-standalone-preset.js.map',
            'swagger-ui.css',
            'swagger-ui.css.map',
            'swagger-ui.js',
            'swagger-ui.js.map',
        ];

        $defaultPath = 'vendor/swagger-api/swagger-ui/dist/';
        $path = base_path(
            config('swagger-ui.paths.swagger_ui_assets_path', $defaultPath)
        );
        if (!$asset) {
            return realpath($path);
        }

        if (!in_array($asset, $allowed_files)) {
            throw new RuntimeException(sprintf('(%s) - this swagger asset is not allowed', $asset));
        }

        return realpath($path . $asset);
    }
}

if (!function_exists('swagger_asset')) {
    /**
     * Returns asset from swagger-ui composer package.
     *
     * @throws RuntimeException
     */
    function swagger_asset(string $asset): string
    {
        $file = swagger_ui_dist_path($asset);

        if (!file_exists($file)) {
            throw new RuntimeException(sprintf('Requested swagger asset file (%s) does not exists', $asset));
        }

        return route(config('swagger-ui.routes.assets', 'docs.assets')) . '?v=' . md5_file($file);
    }
}