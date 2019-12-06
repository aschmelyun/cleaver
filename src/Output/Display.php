<?php

namespace Aschmelyun\Cleaver\Output;

use Codedungeon\PHPCliColors\Color;

class Display
{

    public static function success(string $line): string
    {
        return Color::bold_green() . '+ ' . Color::white() . $line . PHP_EOL;
    }

    public static function error(string $line): string
    {
        return Color::bold_red() . '- ' . Color::white() . $line . PHP_EOL;
    }

    public static function complete(string $line): string
    {
        return Color::bold_green() . '* ' . $line . ' *' . PHP_EOL;
    }

    public static function failure(string $line): string
    {
        return Color::bold_red() . '* ' . $line . ' *' . PHP_EOL;
    }

}