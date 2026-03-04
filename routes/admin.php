<?php

use App\Http\Controllers\Admin\BoardController;
use App\Http\Controllers\Admin\ColumnController;
use Illuminate\Support\Facades\Route;

Route::resource('boards', BoardController::class);

Route::get('boards/{board}', [BoardController::class, 'show'])->name('boards.show');

Route::post('boards/{board}/columns', [ColumnController::class, 'store'])->name('columns.store');
Route::get('/columns/{column}/edit', [ColumnController::class, 'edit'])->name('columns.edit');
Route::put('/columns/{column}', [ColumnController::class, 'update'])->name('columns.update');
Route::delete('/columns/{column}', [ColumnController::class, 'destroy'])->name('columns.destroy');
Route::patch('/columns/{column}/toggle-finished', [ColumnController::class, 'toggleFinished'])->name('columns.toggle-finished');
