<?php

namespace Aschmelyun\Cleaver\Compilers;

use Aschmelyun\Cleaver\Engines\FileEngine;
use Symfony\Component\Finder\SplFileInfo;

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

        $this->json->mix = FileEngine::mixManifestData();
    }

    public function checkFormatting(): bool
    {
        return (isset($this->json->view) && isset($this->json->path));
    }

}