<?php

namespace Aschmelyun\Cleaver\Compilers;

use Aschmelyun\Cleaver\Output\Console;
use Aschmelyun\Cleaver\Engines\FileEngine;

class Compiler
{

    public $json;
    public $file;

    public function checkContent(bool $showErrors = true): bool
    {
        $console = Console::init();

        if (!isset($this->json->view)) {
            if ($showErrors) {
                $console->error($this->file, 'the view attribute is missing');
            }
            return false;
        }

        if (!isset($this->json->path)) {
            $path = str_replace(FileEngine::contentDir(false), '', $this->file);
            $this->json->path = pathinfo($path, PATHINFO_DIRNAME) . '/' . pathinfo($path, PATHINFO_FILENAME);
        }

        return true;
    }

}