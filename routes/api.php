<?php

use App\Http\Controllers\Api\ShortenerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('/shorteners', ShortenerController::class);
