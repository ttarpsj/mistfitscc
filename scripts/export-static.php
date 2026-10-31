<?php
use Illuminate\Contracts\Console\Kernel;
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();
$target = __DIR__ . '/../docs';
if (!is_dir($target)) mkdir($target, 0777, true);
$renderStatic = static function (string $view): string {
    $html = view($view)->render();
    $html = preg_replace('#(href|src)="(?:https?://[^"]+)?/build/#', '$1="/mistfitscc/build/', $html);
    $html = preg_replace('#(src)="(?:https?://[^"]+)?/images/#', '$1="/mistfitscc/images/', $html);
    $html = preg_replace('#href="https?://[^"/]+([^\"]*)"#', 'href="/mistfitscc$1"', $html);
    return str_replace('href="/mistfitscc/shop"', 'href="/mistfitscc/shop/"', $html);
};
file_put_contents($target . '/index.html', $renderStatic('welcome'));
if (!is_dir($target . '/shop')) mkdir($target . '/shop', 0777, true);
file_put_contents($target . '/shop/index.html', $renderStatic('shop'));
if (!is_dir($target . '/rides')) mkdir($target . '/rides', 0777, true);
file_put_contents($target . '/rides/index.html', $renderStatic('rides'));
file_put_contents($target . '/.nojekyll', '');
$source = __DIR__ . '/../public/build'; $destination = $target . '/build';
if (is_dir($destination)) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($destination, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST);
    foreach ($iterator as $item) $item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
} else {
    mkdir($destination, 0777, true);
}
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source, FilesystemIterator::SKIP_DOTS));
foreach ($iterator as $item) {
    $path = $destination . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
    if ($item->isDir()) { mkdir($path, 0777, true); continue; }
    if (!is_dir(dirname($path))) mkdir(dirname($path), 0777, true);
    copy($item, $path);
}
$imageDestination = $target . '/images'; if (!is_dir($imageDestination)) mkdir($imageDestination, 0777, true);
copy(__DIR__ . '/../public/images/mistfits-hero.png', $imageDestination . '/mistfits-hero.png');
echo "Static site exported to docs\\n";
