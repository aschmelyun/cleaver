<?php

namespace Aschmelyun\Cleaver\Compilers;

use Aschmelyun\Cleaver\Engines\FileEngine;

class JsonCompiler
{

    public $json;
    public $file;

    public function __construct(string $file)
    {
        $this->file = $file;

        $this->json = json_decode(
            file_get_contents(FileEngine::contentDir() . $file)
        );

        $this->json->mix = FileEngine::mixManifestData();
    }

    public function checkFormatting(): bool
    {
        return (isset($this->json->view) && isset($this->json->path));
    }

}