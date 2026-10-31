<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/shop', function () {
    return view('shop');
})->name('shop');

Route::get('/rides', function () {
    return view('rides');
})->name('rides');
