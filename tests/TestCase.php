<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{

    const VIEW_DATA_CORRECT = [
        'view' => 'layout.test',
        'path' => '/test-correct',
        'title' => 'This is a test',
        'mix' => [
            "/assets/js/app.js" => "/dist/assets/js/app.js",
            "/assets/css/app.css" => "/dist/assets/css/app.css"
        ]
    ];

    const VIEW_DATA_INCORRECT = [
        'path' => '/test-incorrect',
        'title' => 'This is a test',
        'mix' => [
            "/assets/js/app.js" => "/dist/assets/js/app.js",
            "/assets/css/app.css" => "/dist/assets/css/app.css"
        ]
    ];

}