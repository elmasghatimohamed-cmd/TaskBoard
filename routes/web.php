<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [TaskController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::prefix('tasks')->name('tasks.')->group(function () {
    Route::get('/archived', [TaskController::class, 'archived'])->name('archived');
    Route::patch('/{id}/restore', [TaskController::class, 'restore'])->name('restore');
    Route::delete('/{id}/force-destroy', [TaskController::class, 'forceDestroy'])->name('forceDestroy');
});

Route::resource('tasks', TaskController::class);

require __DIR__ . '/auth.php';
