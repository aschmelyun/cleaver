<?php

namespace Aschmelyun\Cleaver\Engines;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;

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

    public static function cleanOutputDir(bool $ignoreDotFiles = true, array $exclude = ['assets']): void
    {
        $finder = new Finder();
        $filesystem = new Filesystem();
        $filesToRemove = $finder->files()
            ->in(self::OUTPUT_DIR)
            ->ignoreDotFiles($ignoreDotFiles)
            ->exclude($exclude);

        $filesystem->remove($filesToRemove);

        $directoriesToRemove = $finder->directories()
            ->in(self::OUTPUT_DIR)
            ->ignoreDotFiles($ignoreDotFiles)
            ->exclude($exclude);

        $filesystem->remove($directoriesToRemove);
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