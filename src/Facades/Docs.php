<?php

namespace YSRoot\SwaggerUI\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string content(string $filePath)
 */
class Docs extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'docs';
    }
}
