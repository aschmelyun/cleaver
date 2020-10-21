<?php

namespace Aschmelyun\Cleaver\Compilers;

use Aschmelyun\Cleaver\Engines\FileEngine;
use Symfony\Component\Finder\SplFileInfo;
use Zttp\Zttp;

class JsonCompiler extends Compiler
{

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

}
