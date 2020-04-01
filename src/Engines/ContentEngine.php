<?php

namespace Aschmelyun\Cleaver\Engines;

use Aschmelyun\Cleaver\Compilers\JsonCompiler;
use Aschmelyun\Cleaver\Compilers\MarkdownCompiler;
use Aschmelyun\Cleaver\Engines\FileEngine;
use Tightenco\Collect\Support\Collection;

class ContentEngine
{

    public static function generateCollection(FileEngine $fileEngine): Collection
    {
        $content = [];
        foreach($fileEngine->getContentFiles() as $contentFile) {
            $compiler = null;
            $ext = pathinfo($contentFile, PATHINFO_EXTENSION);
            switch($ext) {
                case 'json':
                    $compiler = new JsonCompiler($contentFile);
                    break;
                case 'md':
                case 'markdown':
                    $compiler = new MarkdownCompiler($contentFile);
                    break;
                default:
                    break;
            }

            if($compiler && $compiler->checkFormatting()) {
                $content[] = $compiler->json;
            }
        }

        return new Collection($content);
    }

}