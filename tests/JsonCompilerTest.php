<?php

namespace Tests;

use Aschmelyun\Cleaver\Compilers\JsonCompiler;
use Aschmelyun\Cleaver\Engines\FileEngine;
use Symfony\Component\Finder\SplFileInfo;

class JsonCompilerTest extends TestCase
{

    /**
     * @test
     */
    public function will_create_data_object_from_json_file()
    {
        $content = [
            'view' => 'layout.test',
            'path' => '/',
            'title' => 'This is a test'
        ];
        $contentFile = FileEngine::contentDir() . 'test.json';

        file_put_contents($contentFile, json_encode($content));

        $contentFile = new SplFileInfo($contentFile, FileEngine::contentDir(), $contentFile);
        $compiler = new JsonCompiler($contentFile);

        $expected = 'layout.test';
        $actual = $compiler->json->view;
        $this->assertSame($expected, $actual);

        $expected = '/';
        $actual = $compiler->json->path;
        $this->assertSame($expected, $actual);

        $expected = 'This is a test';
        $actual = $compiler->json->title;
        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function will_return_false_for_formatting_json_files_without_view_set()
    {
        $content = [
            'path' => '/',
            'title' => 'This is a test'
        ];
        $contentFile = FileEngine::contentDir() . 'test.json';

        file_put_contents($contentFile, json_encode($content));

        $contentFile = new SplFileInfo($contentFile, FileEngine::contentDir(), $contentFile);
        $compiler = new JsonCompiler($contentFile);

        $this->assertFalse($compiler->checkFormatting());
    }

    /**
     * @test
     */
    public function will_return_false_for_formatting_json_files_without_path_set()
    {
        $content = [
            'view' => 'layout.test',
            'title' => 'This is a test'
        ];
        $contentFile = FileEngine::contentDir() . 'test.json';

        file_put_contents($contentFile, json_encode($content));

        $contentFile = new SplFileInfo($contentFile, FileEngine::contentDir(), $contentFile);
        $compiler = new JsonCompiler($contentFile);

        $this->assertFalse($compiler->checkFormatting());
    }

    /**
     * @test
     */
    public function will_return_true_for_formatting_json_files_with_view_and_path_set()
    {
        $content = [
            'view' => 'layout.test',
            'path' => '/',
            'title' => 'This is a test'
        ];
        $contentFile = FileEngine::contentDir() . 'test.json';

        file_put_contents($contentFile, json_encode($content));

        $contentFile = new SplFileInfo($contentFile, FileEngine::contentDir(), $contentFile);
        $compiler = new JsonCompiler($contentFile);

        $this->assertTrue($compiler->checkFormatting());
    }

}