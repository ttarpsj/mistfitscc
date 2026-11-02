<?php

namespace App\Support;

class Merchandise
{
    public static function all(): array
    {
        $items = json_decode(file_get_contents(base_path('merchandise/products.json')), true, 512, JSON_THROW_ON_ERROR);
        foreach ($items as &$item) {
            $files = glob(public_path('images/' . $item['id'] . '/' . $item['id'] . '-*')) ?: [];
            $files = array_filter($files, fn ($file) => preg_match('/-' . '[0-9]+\.(png|jpe?g|webp)$/i', $file) && is_file($file));
            natsort($files);
            $item['images'] = array_values(array_map(fn ($file) => 'images/' . $item['id'] . '/' . basename($file), $files));
            $charts = glob(public_path('images/' . $item['id'] . '/product-chart.*')) ?: [];
            $item['sizeChart'] = $charts ? 'images/' . $item['id'] . '/' . basename($charts[0]) : null;
            $item['currency'] = 'USD';
            $item['availability'] = 'Sold Out';
            $item['type'] = $item['category'];
            $item['tone'] = 'ink';
            $item['variants'] = false;
            $item['price'] = '$' . number_format($item['price'], 2) . ' USD';
        }
        unset($item);

        return $items;
    }

    public static function find(string $slug): ?array
    {
        foreach (self::all() as $item) {
            if ($item['slug'] === $slug) {
                return $item;
            }
        }

        return null;
    }
}
