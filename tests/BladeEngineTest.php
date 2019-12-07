<?php

namespace Tests;

use Aschmelyun\Cleaver\Engines\BladeEngine;
use Aschmelyun\Cleaver\Engines\FileEngine;

class BladeEngineTest extends TestCase
{

    /**
     * @test
     */
    public function can_create_cache_dir_with_write_permissions()
    {
        $bladeEngine = new BladeEngine();
        $this->assertTrue(is_dir($bladeEngine->cacheDir));

        $expected = '0755';
        $actual = substr(sprintf('%o', fileperms($bladeEngine->cacheDir)), -4);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function will_render_html_from_correctly_formatted_view_data()
    {
        $bladeEngine = new BladeEngine();

        $data = (object) self::VIEW_DATA_CORRECT;

        $expected = "<h1>This is a test</h1>";
        $actual = $bladeEngine->render($data);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function will_not_render_html_from_incorrectly_formatted_view_data()
    {
        $bladeEngine = new BladeEngine();

        $data = (object) self::VIEW_DATA_INCORRECT;

        $expected = null;
        $actual = $bladeEngine->render($data);

        $this->assertEquals($expected, $actual);
    }

}