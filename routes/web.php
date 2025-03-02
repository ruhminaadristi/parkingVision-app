<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ParkingAreaController;
use App\Http\Controllers\Admin\ParkingSlotController;
use App\Http\Controllers\Admin\OccupancyHistoryController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;

// Public Routes (Tanpa Login)
Route::get('/', [PublicController::class, 'index'])->name('home');

// Admin Auth Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest Admin Routes (untuk admin yang belum login)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login']);
        Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [RegisterController::class, 'register']);
    });

    // Protected Admin Routes (untuk admin yang sudah login)
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('areas', ParkingAreaController::class);
        Route::resource('slots', ParkingSlotController::class);
        Route::get('/history', [OccupancyHistoryController::class, 'index'])->name('history');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports');
        Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });
});
