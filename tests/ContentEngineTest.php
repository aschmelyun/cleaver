<?php

namespace Tests;

use Aschmelyun\Cleaver\Engines\ContentEngine;
use Aschmelyun\Cleaver\Engines\FileEngine;

class ContentEngineTest extends TestCase
{

    /**
     * @test
     */
    public function will_return_collection_of_content_files()
    {
        $fileEngine = new FileEngine();

        $expected = 'Tightenco\Collect\Support\Collection';
        $actual = ContentEngine::generateCollection($fileEngine);

        $this->assertInstanceOf($expected, $actual);

        $actual = $actual->count();
        $expected = 1;

        $this->assertEquals($expected, $actual);
    }

}