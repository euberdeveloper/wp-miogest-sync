<?php

namespace WpMiogestSync\Utils;

use wherw\ScanPath;
use Webmozart\PathUtil\Path;

class EraseThumbnails
{
    private string $path;
    private string $prefix_to_erase;

    private function getPathsToErase(): array
    {
        $scanner = new ScanPath();
        $scanner->setPath($this->path);
        $scanner->setExtension([
            'jpg',
            'png'
        ]);
        $scanner->scan();
        $allFiles = $scanner->getFiles()->toArray();
        return array_values(array_filter(
            $allFiles,
            fn ($path) => str_contains(Path::getFilename($path), $this->prefix_to_erase)
        ));
    }

    private function erasePath(string $path): void
    {
        if (file_exists($path)) {
            unlink($path);
        }
    }

    public function __construct(string $path, string $prefix_to_erase)
    {
        $this->path = $path;
        $this->prefix_to_erase = $prefix_to_erase;
    }

    public function erase(): void
    {
        foreach ($this->getPathsToErase() as $path) {
            $this->erasePath($path);
        }
    }
}
