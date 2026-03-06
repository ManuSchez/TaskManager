<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return redirect()->route('admin.boards.index');
    })->name('dashboard');
});

require __DIR__ . '/settings.php';
// Aquí asegúrate de cargar tu archivo admin si es que lo haces manualmente:
require __DIR__ . '/admin.php';