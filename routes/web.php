<?php

use Illuminate\Support\Facades\Route;
use App\Support\Merchandise;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/shop', function () {
    return view('shop');
})->name('shop');

Route::get('/shop/{slug}', function (string $slug) {
    abort_unless($product = Merchandise::find($slug), 404);

    return view('product', compact('product'));
})->name('product.show');

Route::get('/rides', function () {
    return view('rides');
})->name('rides');

Route::get('/gallery', function () {
    return view('gallery');
})->name('gallery');

Route::get('/about', function () {
    return view('about');
})->name('about');
