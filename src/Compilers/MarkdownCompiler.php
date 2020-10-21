<?php

namespace Aschmelyun\Cleaver\Compilers;

use Aschmelyun\Cleaver\Engines\FileEngine;
use Symfony\Component\Finder\SplFileInfo;

class MarkdownCompiler extends Compiler
{

    public function __construct(SplFileInfo $file)
    {
        $this->file = $file;

        $this->json = $this->parseMarkdown(
            $file->getContents()
        );

        $this->json->mix = FileEngine::mixManifestData();
    }

    public function parseMarkdown(string $markdown): \stdClass
    {
        $json = (object) [];

        preg_match('/---(.*?)---/s', $markdown, $headers);

        $headers = explode("\n", $headers[1]);
        $headers = array_filter(array_map('trim', $headers));

        foreach($headers as $header) {
            $headerParts = explode(':', $header, 2);

            $idx = $headerParts[0];
            $item = trim($headerParts[1]);

            $json->{$idx} = $item;

            if (
                (substr($item, 0, 5) === '/data') &&
                (substr($item, -5, 5) === '.json') &&
                (file_exists(FileEngine::$resourceDir . $item))
            ) {
                $json->{$idx} = json_decode(file_get_contents(FileEngine::$resourceDir . $item));
            }

        }

        $body = explode('---', $markdown, 3);
        $parsedown = new \ParsedownExtra();
        $json->body = $parsedown->text(end($body));

        return $json;
    }

}
