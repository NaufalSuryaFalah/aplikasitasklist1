<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\TaskOrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register.post');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('tasks', TaskOrderController::class)->except(['show']);
    Route::post('tasks/{task}/claim', [TaskOrderController::class, 'claim'])->name('tasks.claim');
    Route::post('tasks/{task}/complete', [TaskOrderController::class, 'complete'])->name('tasks.complete');
    Route::get('laporan/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
    Route::resource('laporan', LaporanController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::resource('users', App\Http\Controllers\UserController::class);
});
