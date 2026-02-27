<?php

use App\Http\Controllers\Admin\BoardController;
use Illuminate\Support\Facades\Route;

Route::resource('boards', BoardController::class);