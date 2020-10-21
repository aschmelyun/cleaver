<?php

namespace Aschmelyun\Cleaver\Output;

class Console
{

    public $builds = 0;
    public $errors = 0;

    private static $instance = null;

    private function __construct() {}

    public static function init()
    {
        if (self::$instance == null) {
            self::$instance = new Console();
        }

        return self::$instance;
    }

    public function getBuilds(): int
    {
        return $this->builds;
    }

    public function getErrors(): int
    {
        return $this->errors;
    }

    public function build(string $file, string $path): void
    {
        $this->builds++;
        echo Display::success(Display::bold(basename($file)) . ' rendered to ' . Display::bold($path));
    }

    public function error(string $file, string $error): void
    {
        $this->errors++;
        echo Display::error(Display::bold(basename($file)) . ' could not be rendered because ' . Display::bold($error));
    }

    public function end(array $buildTime): void
    {
        $fullBuildTime = round((($buildTime['end'] - $buildTime['start'])*1000), 2);

        $buildPages = $this->builds === 1 ? 'page' : 'pages';
        $errorPages = $this->errors === 1 ? 'page' : 'pages';

        echo "\n";

        if ($this->builds) {
            echo Display::complete(Display::bold($this->builds . ' ' . $buildPages) . ' built in ' . Display::bold($fullBuildTime . 'ms'));
        }

        if ($this->errors) {
            echo Display::failure(Display::bold($this->errors . ' ' . $errorPages) . ' could not be built, see ' . Display::bold('errors above'));
        }
    }

}
