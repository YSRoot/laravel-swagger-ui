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
        $parsedYaml = $this->parseYaml($filePath);
        $parsedYaml['info']['title'] = config('swagger-ui.title');
        $parsedYaml['servers'] = config('swagger-ui.servers');

        return Yaml::dump($parsedYaml);
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
                $pathForRef = $this->pathForRef($value, $filePath);
                $parsedYaml = $this->parseYaml($pathForRef);
                break;
            }
            if (is_array($value)) {
                $this->extracted($value, $filePath);
            }
        }
    }

    private function pathForRef(string $value, $previousPath): string
    {
        $refsDirPrefix = config('swagger-ui.paths.refs_dir_prefix', '/docs/');
        if ($path = realpath(base_path($refsDirPrefix . $value))) {
            return $path;
        }

        if (
            Str::startsWith($value, '../')
            && $path = realpath(pathinfo($previousPath)['dirname'] . '/' . $value)
        ) {
            return $path;
        };

        throw new RuntimeException(sprintf('Invalid yaml file: %s, `$ref: %s` can`t read', $previousPath, $value),);
    }
}
