<?php

use App\Http\Controllers\Api\ShortenerController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/shorteners', ShortenerController::class);


