<?php

use Illuminate\Support\Facades\Route;

/**
 * This will route every web request to a single entry point,
 * which will be the entry for our Vue application.
 */
Route::get('/{any}', function () {
    return view('landing');
})->where('any', '.*');
