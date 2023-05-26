<?php

use App\Http\Controllers\BlogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



//

Route::get('/posts', [BlogController::class, 'index']);

Route::get('/posts/{id}', [BlogController::class, 'show']);
