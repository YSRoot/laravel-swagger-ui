<?php

namespace YSRoot\SwaggerUI\Services\DocManagers;

interface DocManagerInterface
{
    public function content(string $filePath): string;
}