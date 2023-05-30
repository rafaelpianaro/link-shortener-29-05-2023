<?php

use App\Http\Controllers\Web\ShortenerController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/shortener/{id}', [ShortenerController::class, 'handle']);

// Route::get('shortener/{shortener}','Web\ShortenerController@handle');
