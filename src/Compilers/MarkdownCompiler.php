<?php

namespace Aschmelyun\Cleaver\Compilers;

use Aschmelyun\Cleaver\Engines\FileEngine;
use Symfony\Component\Finder\SplFileInfo;

class MarkdownCompiler
{

    public $json;
    public $file;

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
            $json->{$headerParts[0]} = trim($headerParts[1]);
        }

        $body = explode('---', $markdown, 3);
        $parsedown = new \ParsedownExtra();
        $json->body = $parsedown->text(end($body));

        return $json;
    }

    public function checkFormatting(): bool
    {
        return (isset($this->json->view) && isset($this->json->path));
    }

}