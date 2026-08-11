<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlateController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

// Ana sahypa — registrasiýa
Route::get('/', [PlateController::class, 'index'])->name('home');

// OTP (SMS tassyklama)
Route::post('/otp/send', [AuthController::class, 'sendOtp'])->name('otp.send');
Route::post('/otp/verify', [AuthController::class, 'verifyOtp'])->name('otp.verify');

// Belgi hasaba alyş
Route::post('/plate/register', [PlateController::class, 'register'])->name('plate.register');
Route::post('/plate/check', [PlateController::class, 'check'])->name('plate.check');

// Admin
Route::get('/admin/login', [AdminController::class, 'loginPage'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::delete('/admin/plate/{id}', [AdminController::class, 'deletePlate'])->name('admin.plate.delete');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');