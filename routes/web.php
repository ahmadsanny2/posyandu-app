<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaderController;
use App\Http\Controllers\ParentUserController;
use App\Http\Controllers\ToddlerController;
use App\Http\Controllers\PregnantWomanController;
use App\Http\Controllers\ElderlyController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ToddlerMeasurementController;
use App\Http\Controllers\PregnancyRecordController;
use App\Http\Controllers\ElderlyRecordController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ReportController;
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
        Route::resource('users/kaders', KaderController::class)->parameters(['kaders' => 'kader'])->names('kaders');
        Route::resource('users/parents', ParentUserController::class)->parameters(['parents' => 'parent'])->names('parents');
    });

    // Kader and Admin Only Routes for Participant Management
    // Note: Parent can also access but will be limited by policies inside Controllers
    Route::resource('toddlers', ToddlerController::class);
    Route::resource('pregnant-women', PregnantWomanController::class);
    Route::resource('elderlies', ElderlyController::class);

    // Schedules (Jadwal Kegiatan)
    Route::resource('schedules', ScheduleController::class);
    Route::post('schedules/{schedule}/rsvp', [ScheduleController::class, 'rsvp'])->name('schedules.rsvp');

    // Medical Records Recording (Kader/Admin Only)
    Route::middleware('role:admin,kader')->group(function () {
        Route::get('schedules/{schedule}/toddlers/{toddler}/measure', [ToddlerMeasurementController::class, 'create'])->name('toddlers.measure.create');
        Route::post('toddlers/measure', [ToddlerMeasurementController::class, 'store'])->name('toddlers.measure.store');

        Route::get('schedules/{schedule}/pregnant-women/{pregnant_woman}/record', [PregnancyRecordController::class, 'create'])->name('pregnant-women.record.create');
        Route::post('pregnant-women/record', [PregnancyRecordController::class, 'store'])->name('pregnant-women.record.store');

        Route::get('schedules/{schedule}/elderlies/{elderly}/record', [ElderlyRecordController::class, 'create'])->name('elderlies.record.create');
        Route::post('elderlies/record', [ElderlyRecordController::class, 'store'])->name('elderlies.record.store');

        // Reports (Laporan) - Kader/Admin Only
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/print', [ReportController::class, 'print'])->name('reports.print');
    });

    // Articles & Galleries (Available for all authenticated actors)
    Route::resource('articles', ArticleController::class);
    Route::resource('galleries', GalleryController::class);
});

require __DIR__.'/auth.php';
