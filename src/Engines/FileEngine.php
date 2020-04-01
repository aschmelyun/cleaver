<?php

namespace Aschmelyun\Cleaver\Engines;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;

class FileEngine
{

    private static $basePath;

    public static $contentDir;
    public static $outputDir;
    public static $mixManifest;

    public function __construct(?string $basePath = null)
    {
        self::$basePath = !empty($basePath) ? $basePath : dirname(__FILE__, 3);

        self::$contentDir = self::$basePath . '/resources/content';
        self::$outputDir = self::$basePath . '/dist';
        self::$mixManifest = self::$basePath . '/mix-manifest.json';
    }

    public static function contentDir(): string
    {
        return self::$contentDir . '/';
    }

    public static function outputDir(): string
    {
        return self::$outputDir . '/';
    }

    public static function mixManifest(): string
    {
        return self::$mixManifest;
    }

    public static function cleanOutputDir(bool $ignoreDotFiles = true, array $exclude = ['assets']): void
    {
        if(!is_dir(self::$outputDir)) {
            return;
        }

        $finder = new Finder();
        $filesystem = new Filesystem();
        $filesToRemove = $finder->files()
            ->in(self::$outputDir)
            ->ignoreDotFiles($ignoreDotFiles)
            ->exclude($exclude);

        $filesystem->remove($filesToRemove);

        $directoriesToRemove = $finder->directories()
            ->in(self::$outputDir)
            ->ignoreDotFiles($ignoreDotFiles)
            ->exclude($exclude);

        $filesystem->remove($directoriesToRemove);
    }

    public function getContentFiles(): Finder
    {
        $finder = new Finder();
        return $finder->files()
            ->in(self::$contentDir)
            ->ignoreDotFiles(true)
            ->name(['*.json', '*.md', '*.markdown'])
            ->sortByModifiedTime();
    }

    public static function mixManifestData(): array
    {
        return json_decode(
            str_replace('/dist', '', file_get_contents(self::$mixManifest)),
            true
        );
    }

    public static function store(string $html, string $path): bool
    {
        $outputDir = self::$outputDir . $path;

        if(!is_dir($outputDir))
            mkdir($outputDir, 0755, true);

        $outputPath = $outputDir . '/index.html';

        return boolval(file_put_contents($outputPath, $html));
    }

}