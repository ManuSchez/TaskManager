<?php

use App\Http\Controllers\Admin\BoardController;
use App\Http\Controllers\Admin\ColumnController;
use App\Http\Controllers\Admin\WorkspaceBoardController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    Route::resource('boards', BoardController::class);
    Route::get('boards/{board}', [BoardController::class, 'show'])->name('boards.show');
});

// Rutas de Workspaces (agrupadas para mantener orden)
Route::prefix('workspaces')->name('workspaces.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('{workspace:slug}/boards', [WorkspaceBoardController::class, 'index'])
        ->name('boards.index');
        
    Route::post('{workspace}/boards', [WorkspaceBoardController::class, 'store'])
    ->name('boards.store');
});

// Rutas de columnas
Route::prefix('columns')->name('columns.')->middleware(['auth', 'verified'])->group(function () {
    Route::post('/{board}/columns', [ColumnController::class, 'store'])->name('store');
    Route::get('/{column}/edit', [ColumnController::class, 'edit'])->name('edit');
    Route::put('/{column}', [ColumnController::class, 'update'])->name('update');
    Route::delete('/{column}', [ColumnController::class, 'destroy'])->name('destroy');
    Route::patch('/{column}/toggle-finished', [ColumnController::class, 'toggleFinished'])->name('toggle-finished');
});