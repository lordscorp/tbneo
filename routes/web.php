<?php

use Illuminate\Support\Facades\Route;

Route::get('{any}', function() {
    return view('dashboard');
})->where('any', '.*');


// Route::get('/', function () {
//     return view('dashboard');
// });
