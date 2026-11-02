<?php

namespace App\Support;

use FilesystemIterator;

final class Gallery
{
    /**
     * Return gallery photographs in a stable filename order. New files placed in
     * public/images/gallery are picked up automatically by the next render.
     *
     * @return list<string>
     */
    public static function images(): array
    {
        $directory = public_path('images/gallery');
        $files = [];

        if (is_dir($directory)) {
            foreach (new FilesystemIterator($directory, FilesystemIterator::SKIP_DOTS) as $file) {
                if ($file->isFile() && self::isGalleryImage($file->getFilename())) {
                    $files[] = $file->getPathname();
                }
            }
        }

        // Retain the three existing gallery assets until photographs are added
        // to the dedicated directory above.
        if ($files === []) {
            $files = array_values(array_filter(
                glob(public_path('images/mistfits-gallery-row-*')) ?: [],
                static fn (string $path): bool => self::isGalleryImage(basename($path)),
            ));
        }

        usort($files, static fn (string $left, string $right): int => strnatcasecmp(basename($left), basename($right)));

        $prefix = str_replace('\\', '/', rtrim(public_path(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR);

        return array_values(array_map(
            static fn (string $path): string => str_replace('\\', '/', str_replace($prefix, '', str_replace('\\', '/', $path))),
            $files,
        ));
    }

    private static function isGalleryImage(string $filename): bool
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $name = strtolower(pathinfo($filename, PATHINFO_FILENAME));

        return in_array($extension, ['png', 'jpg', 'jpeg', 'webp', 'avif'], true)
            && !str_starts_with($filename, '.')
            && !str_contains($name, 'thumb')
            && !str_contains($name, 'duplicate');
    }
}
