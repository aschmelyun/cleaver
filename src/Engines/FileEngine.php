<?php

namespace Aschmelyun\Cleaver\Engines;

use Symfony\Component\Finder\Finder;

class FileEngine
{

    const CONTENT_DIR = __DIR__ . '/../../resources/content';
    const OUTPUT_DIR = __DIR__ . '/../../dist';
    const MIX_MANIFEST_FILE = __DIR__ . '/../../mix-manifest.json';

    public static function contentDir(): string
    {
        return self::CONTENT_DIR . '/';
    }

    public static function outputDir(): string
    {
        return self::OUTPUT_DIR . '/';
    }

    public function cleanOutputDir()
    {
        $finder = new Finder();
        $filesToRemove = $finder->files()
            ->in(self::OUTPUT_DIR)
            ->ignoreDotFiles(true)
            ->exclude(['assets']);

        foreach($filesToRemove as $file)
            unlink($file);

        $directoriesToRemove = $finder->directories()
            ->in(self::OUTPUT_DIR)
            ->ignoreDotFiles(true)
            ->exclude(['assets']);

        foreach(iterator_to_array($directoriesToRemove, true) as $dir)
            rmdir($dir);
    }

    public function getContentFiles(): array
    {
        return array_diff(
            scandir(self::CONTENT_DIR),
            ['.', '..']
        );
    }

    public static function mixManifestData(): array
    {
        return json_decode(
            str_replace('/dist', '', file_get_contents(self::MIX_MANIFEST_FILE)),
            true
        );
    }

    public static function store(string $html, string $path): bool
    {
        $outputDir = self::OUTPUT_DIR . '/' . $path;

        if(!is_dir($outputDir))
            mkdir($outputDir, 0755, true);

        $outputPath = $outputDir . '/index.html';

        return boolval(file_put_contents($outputPath, $html));
    }

}