<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Rute Catch-All untuk Vue Router
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');