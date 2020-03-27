<?php

namespace Aschmelyun\Cleaver;

use Aschmelyun\Cleaver\Compilers\JsonCompiler;
use Aschmelyun\Cleaver\Compilers\MarkdownCompiler;
use Aschmelyun\Cleaver\Engines\BladeEngine;
use Aschmelyun\Cleaver\Engines\ContentEngine;
use Aschmelyun\Cleaver\Engines\FileEngine;
use Aschmelyun\Cleaver\Output\Display;

class Cleaver
{

    private $buildTime;
    private $buildAmount = 0;
    private $basePath;

    public function __construct(?string $basePath = null)
    {
        $this->buildTime['start'] = microtime(true);
        $this->buildTime['end'] = 0;

        $this->basePath = $basePath ? $basePath : dirname(__FILE__, 2);
    }

    public function build(): void
    {
        $blade = new BladeEngine($this->basePath);

        $fileEngine = new FileEngine($this->basePath);
        $fileEngine->cleanOutputDir();

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
                    echo Display::error($contentFile . ' was not rendered, needs to be a json or markdown file.');
                    break;
            }

            if($compiler && $compiler->checkFormatting()) {
                $compiler->json->content = ContentEngine::generateCollection($fileEngine);
                $blade->save($blade->render($compiler->json));
                echo Display::success($compiler->file . ' saved successfully.');

                $this->buildAmount++;
            } else {
                echo Display::error($compiler->file . ' could not be rendered, skipping this page.');
            }

        }

        $this->buildTime['end'] = microtime(true);

        $buildTime = round((($this->buildTime['end'] - $this->buildTime['start'])*1000), 2);
        $pages = $this->buildAmount === 1 ? 'page' : 'pages';

        echo Display::complete($this->buildAmount . ' ' . $pages . ' built in ' . $buildTime . 'ms');
    }

}