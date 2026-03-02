<?php

use App\Http\Controllers\Admin\BoardController;
use App\Http\Controllers\Admin\ColumnController;
use Illuminate\Support\Facades\Route;

Route::resource('boards', BoardController::class);
Route::get('boards/{board}', [BoardController::class, 'show'])->name('admin.boards.show');
Route::post('boards/{board}/columns', [ColumnController::class, 'store'])->name('columns.store');