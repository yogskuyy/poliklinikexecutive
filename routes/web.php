<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

// Web Dashboard (Tampilan Web Lengkap untuk Desktop / Petugas / Manajemen)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// TV Display Mode (Tampilan Khusus Layar TV Ruang Tunggu Pasien - 100vh Full Screen)
Route::get('/tv', [DashboardController::class, 'tvDisplay'])->name('tv.display');

// AJAX Endpoints
Route::get('/api/visits', [DashboardController::class, 'apiVisits'])->name('api.visits');
Route::post('/visits', [DashboardController::class, 'storeVisit'])->name('visits.store');
Route::post('/visits/{id}/status', [DashboardController::class, 'updateVisitStatus'])->name('visits.status');
Route::post('/doctors/{id}/status', [DashboardController::class, 'updateDoctorStatus'])->name('doctors.status');

// Authentication Routes (Login & Logout)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Admin Panel for Dashboard Settings & Data Management (Requires Admin Login)
Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    Route::post('/running-text', [AdminController::class, 'updateRunningText'])->name('running-text.update');
    Route::post('/patients', [AdminController::class, 'storePatient'])->name('patients.store');
    Route::post('/visits/{id}/status', [AdminController::class, 'updateVisitStatus'])->name('visits.status');
    Route::post('/doctors/{id}/status', [AdminController::class, 'updateDoctorStatus'])->name('doctors.status');
    Route::post('/doctors', [AdminController::class, 'storeDoctor'])->name('doctors.store');
});
