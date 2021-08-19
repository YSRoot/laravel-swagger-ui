<?php

namespace YSRoot\SwaggerUI\Services;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Manager;
use YSRoot\SwaggerUI\Enums\DocTypeEnum;
use YSRoot\SwaggerUI\Services\DocManagers\DocManagerInterface;
use YSRoot\SwaggerUI\Services\DocManagers\YamlManager;

/**
 * @method string content(string $filePath)
 */
class DocManager extends Manager
{
    /**
     * @throws BindingResolutionException
     */
    public function createYamlDriver(): DocManagerInterface
    {
        return app()->make(YamlManager::class);
    }

    public function getDefaultDriver(): string
    {
        return DocTypeEnum::YAML;
    }
}