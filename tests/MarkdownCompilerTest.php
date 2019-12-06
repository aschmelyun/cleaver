<?php

namespace Tests;

use Aschmelyun\Cleaver\Compilers\MarkdownCompiler;
use Aschmelyun\Cleaver\Engines\FileEngine;

class MarkdownCompilerTest extends TestCase
{

    /**
     * @test
     */
    public function will_create_data_object_from_markdown_file()
    {
        $content = '
        ---
        view: layout.test
        path: /
        title: This is a test
        ---
        
        # This is a test
        ';
        $contentFile = 'test.md';

        file_put_contents(FileEngine::contentDir() . $contentFile, $content);
        $compiler = new MarkdownCompiler($contentFile);

        $expected = 'layout.test';
        $actual = $compiler->json->view;
        $this->assertEquals($expected, $actual);

        $expected = '/';
        $actual = $compiler->json->path;
        $this->assertEquals($expected, $actual);

        $expected = 'This is a test';
        $actual = $compiler->json->title;
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function will_return_false_for_formatting_markdown_files_without_view_set()
    {
        $content = '
        ---
        path: /
        title: This is a test
        ---
        
        # This is a test
        ';
        $contentFile = 'test.md';

        file_put_contents(FileEngine::contentDir() . $contentFile, $content);
        $compiler = new MarkdownCompiler($contentFile);

        $this->assertFalse($compiler->checkFormatting());
    }

    /**
     * @test
     */
    public function will_return_false_for_formatting_markdown_files_without_path_set()
    {
        $content = '
        ---
        view: layout.test
        title: This is a test
        ---
        
        # This is a test
        ';
        $contentFile = 'test.md';

        file_put_contents(FileEngine::contentDir() . $contentFile, $content);
        $compiler = new MarkdownCompiler($contentFile);

        $this->assertFalse($compiler->checkFormatting());
    }

    /**
     * @test
     */
    public function will_return_true_for_formatting_markdown_files_with_view_and_path_set()
    {
        $content = '
        ---
        view: layout.test
        path: /
        title: This is a test
        ---
        
        # This is a test
        ';
        $contentFile = 'test.md';

        file_put_contents(FileEngine::contentDir() . $contentFile, $content);
        $compiler = new MarkdownCompiler($contentFile);

        $this->assertTrue($compiler->checkFormatting());
    }

}