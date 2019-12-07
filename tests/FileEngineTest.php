<?php

namespace Tests;

use Aschmelyun\Cleaver\Engines\FileEngine;

class FileEngineTest extends TestCase
{

    /**
     * @test
     */
    public function will_display_content_dir()
    {
        $expected = realpath(__DIR__ . '/../resources/content/');
        $actual = realpath(FileEngine::contentDir());

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function will_display_output_dir()
    {
        $expected = realpath(__DIR__ . '/../dist/');
        $actual = realpath(FileEngine::outputDir());

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function will_clean_output_dir_of_html_files()
    {
        file_put_contents(FileEngine::outputDir() . 'index.html', '<h1>This is a test</h1>');

        $fileEngine = new FileEngine();
        $fileEngine::cleanOutputDir();

        $this->assertFalse(is_file(FileEngine::outputDir() . 'index.html'));
    }

    /**
     * @test
     */
    public function will_not_clean_output_dir_of_asset_files()
    {
        file_put_contents(FileEngine::outputDir() . 'assets/css/app.css', '.this-is-a-test{}');

        $fileEngine = new FileEngine();
        $fileEngine::cleanOutputDir();

        $this->assertTrue(is_file(FileEngine::outputDir() . 'assets/css/app.css'));
    }

}