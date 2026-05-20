<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Houses
    Route::resource('houses', HouseController::class);
    Route::get('houses/{house}/print-qr', [HouseController::class, 'printQr'])->name('houses.print-qr');
    Route::get('houses/{house}/download-qr', [HouseController::class, 'downloadQr'])->name('houses.download-qr');
    Route::post('houses/{house}/regenerate-qr', [HouseController::class, 'regenerateQr'])->name('houses.regenerate-qr');

    // Payments
    Route::get('payments/scan', [PaymentController::class, 'scan'])->name('payments.scan');
    Route::post('payments/process', [PaymentController::class, 'processQr'])->name('payments.process');
    Route::get('/history', [App\Http\Controllers\PaymentController::class, 'history'])->name('payments.history');
    Route::delete('/history/{payment}', [App\Http\Controllers\PaymentController::class, 'destroy'])->name('payments.destroy');

    // Pengeluaran
    Route::get('/expenses', [App\Http\Controllers\ExpenseController::class, 'index'])->name('expenses.index');
    Route::post('/expenses', [App\Http\Controllers\ExpenseController::class, 'store'])->name('expenses.store');
    Route::delete('/expenses/{expense}', [App\Http\Controllers\ExpenseController::class, 'destroy'])->name('expenses.destroy');

    // Pengaturan
    Route::get('/settings', [App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
    // Notifications
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/send', [NotificationController::class, 'sendSingle'])->name('notifications.send');
    Route::post('notifications/blast', [NotificationController::class, 'sendBlast'])->name('notifications.blast');

    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

    // Settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');
});
