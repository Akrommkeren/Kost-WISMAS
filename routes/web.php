<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\OwnerController;

// Public Home
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/api/rooms', [HomeController::class, 'getRoomsData']);

// Auth Routes
Route::post('/api/login', [AuthController::class, 'login'])->name('login');
Route::post('/api/register', [AuthController::class, 'register'])->name('register');
Route::post('/api/logout', [AuthController::class, 'logout'])->name('logout');

// Tenant Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/api/tenant/dashboard', [TenantController::class, 'getDashboardData']);
    Route::post('/api/tenant/booking', [TenantController::class, 'bookRoom']);
    Route::post('/api/tenant/pay', [TenantController::class, 'uploadPaymentProof']);

    // Owner Routes
    Route::get('/api/owner/dashboard', [OwnerController::class, 'getDashboardData']);
    Route::post('/api/owner/rooms/{room}/toggle', [OwnerController::class, 'toggleRoomStatus']);
    Route::post('/api/owner/rooms/{room}/price', [OwnerController::class, 'updateRoomPrice']);
    Route::post('/api/owner/payments/{payment}/approve', [OwnerController::class, 'approvePayment']);
    Route::post('/api/owner/payments/{payment}/reject', [OwnerController::class, 'rejectPayment']);
    Route::post('/api/owner/facilities', [OwnerController::class, 'storeFacility']);
    Route::delete('/api/owner/facilities/{facility}', [OwnerController::class, 'deleteFacility']);
});
