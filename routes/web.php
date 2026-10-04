<?php

use Illuminate\Support\Facades\Route;

// Serve Vue SPA
Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');
