<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ToddlerController;
use App\Http\Controllers\PregnantWomanController;
use App\Http\Controllers\ElderlyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Shared Dashboard Route
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // Profile Settings
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Only Routes
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);
    });

    // Kader and Admin Only Routes for Participant Management
    // Note: Parent can also access but will be limited by policies inside Controllers
    Route::resource('toddlers', ToddlerController::class);
    Route::resource('pregnant-women', PregnantWomanController::class);
    Route::resource('elderlies', ElderlyController::class);
});

require __DIR__.'/auth.php';
