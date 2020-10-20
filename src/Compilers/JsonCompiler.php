<?php

namespace Aschmelyun\Cleaver\Compilers;

use Aschmelyun\Cleaver\Engines\FileEngine;
use Aschmelyun\Cleaver\Output\Display;
use Aschmelyun\Cleaver\Output\Console;
use Symfony\Component\Finder\SplFileInfo;
use Zttp\Zttp;

class JsonCompiler
{

    public $json;
    public $file;

    public function __construct(SplFileInfo $file)
    {
        $this->file = $file;

        $this->json = json_decode(
            $file->getContents()
        );

        foreach($this->json as $idx => $item) {
            if (
                (is_string($item)) &&
                (substr($item, 0, 5) === '/data') &&
                (substr($item, -5, 5) === '.json') &&
                (file_exists(FileEngine::$resourceDir . $item))
            ) {
                $this->json->{$idx} = json_decode(file_get_contents(FileEngine::$resourceDir . $item));
                continue;
            }

            if (
                (is_string($item)) &&
                (substr($item, 0, 5) === 'json:')
            ) {
                $url = substr($item, 5);
                if (filter_var($url, FILTER_VALIDATE_URL)) {
                    $this->json->{$idx} = (object) Zttp::get($url)->json();
                }

                continue;
            }
        }

        $this->json->mix = FileEngine::mixManifestData();
    }

    public function checkContent(bool $showErrors = true): bool
    {
        $console = Console::init();

        if ($showErrors && !isset($this->json->view)) {
            $console->error($this->file, 'the view attribute is missing');
            return false;
        }

        if (!isset($this->json->path)) {
            $path = str_replace(FileEngine::contentDir(false), '', $this->file);
            $this->json->path = pathinfo($path, PATHINFO_DIRNAME) . '/' . pathinfo($path, PATHINFO_FILENAME);
        }

        return true;
    }

}
