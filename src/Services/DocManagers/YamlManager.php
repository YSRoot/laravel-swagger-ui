<?php

namespace YSRoot\SwaggerUI\Services\DocManagers;

use http\Exception\RuntimeException;
use Illuminate\Support\Str;
use Symfony\Component\Yaml\Yaml;

class YamlManager implements DocManagerInterface
{
    const REF = '$ref';

    public function content(string $filePath): string
    {
        return Yaml::dump($this->parseYaml($filePath));
    }

    private function parseYaml(string $filePath): array
    {
        $parsedYaml = Yaml::parseFile($filePath);
        $this->extracted($parsedYaml, $filePath);

        return $parsedYaml;
    }

    private function extracted(array &$parsedYaml, string $filePath): void
    {
        foreach ($parsedYaml as $key => &$value) {
            if ($key === self::REF) {
                $pathForRef = $this->pathForRef($value);
                $parsedYaml = $this->parseYaml($pathForRef);
                break;
            }
            if (is_array($value)) {
                $this->extracted($value, $filePath);
            }
        }
    }

    private function pathForRef(string $value): string
    {
        $refsDirPrefix = config('swagger-ui.paths.refs_dir_prefix', '/docs/');
        if ($path = realpath(base_path($refsDirPrefix . $value))) {
            return $path;
        }

        if (
            Str::startsWith($value, '../')
            && $path = realpath(base_path($refsDirPrefix . Str::substr($value, 3)))
        ) {
            return $path;
        };

        throw new RuntimeException('Invalid swagger yaml files, may be contain invalid $ref');
    }
}
