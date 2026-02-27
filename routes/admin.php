<?php

use App\Http\Controllers\Admin\BoardController;
use Illuminate\Support\Facades\Route;

Route::resource('boards', BoardController::class);
Route::get('boards/{board}', [BoardController::class, 'show'])->name('admin.boards.show');