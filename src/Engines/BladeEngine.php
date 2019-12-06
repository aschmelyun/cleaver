<?php

namespace Aschmelyun\Cleaver\Engines;

use Philo\Blade\Blade;

class BladeEngine
{

    public $viewsDir = __DIR__ . '/../../resources/views';
    public $cacheDir = __DIR__ . '/../../cache';

    private $blade;
    private $data;

    public function __construct()
    {
        if(!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0755);
        }

        $this->blade = new Blade($this->viewsDir, $this->cacheDir);
    }

    public function render(\stdClass $data): string
    {
        $this->data = $data;

        if(!isset($this->data->view) || !isset($this->data->path)) {
            return '';
        }

        return $this->blade->view()
            ->make($data->view, get_object_vars($data))
            ->render();
    }

    public function save(string $html): bool
    {
        return FileEngine::store($html, $this->data->path);
    }

}