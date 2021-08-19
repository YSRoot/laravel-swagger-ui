<?php

namespace YSRoot\SwaggerUI\Services\DocManagers;

use Illuminate\Support\Facades\File;

class YamlManager implements DocManagerInterface
{
    public function content(string $filePath): string
    {
        $content = File::get($filePath);

        return '';
    }
}