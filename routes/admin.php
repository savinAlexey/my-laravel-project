<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SubscriptionPlanController;
use App\Livewire\Admin\Settings\Platforms\PlatformManager;
use Livewire\Volt\Volt;

// Гостевые маршруты для админов
Route::prefix('admin')->middleware('guest:admin')->group(function () {
    Volt::route('login', 'admin.auth.login')->name('admin.login');
});

// Защищённые маршруты админки
Route::prefix('admin')->middleware(['auth:admin', 'verified', 'no-account'])->group(function () {
    Route::view('dashboard', 'livewire.admin.dashboard')->name('admin.dashboard');

    // Пользователи
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');

    Route::get('/admin/settings/platforms', PlatformManager::class)->name('admin.settings.platforms');

    // Настройки → Планы подписки
    Route::prefix('settings/subscription-plans')->name('admin.subscription-plans.')->group(function () {
        Route::get('/', [SubscriptionPlanController::class, 'index'])->name('index');
        Route::get('/create', [SubscriptionPlanController::class, 'create'])->name('create');
        Route::post('/', [SubscriptionPlanController::class, 'store'])->name('store');

        Route::get('/{plan}/edit', [SubscriptionPlanController::class, 'edit'])->name('edit');
        Route::put('/{plan}', [SubscriptionPlanController::class, 'update'])->name('update');
        Route::delete('/{plan}', [SubscriptionPlanController::class, 'destroy'])->name('destroy');
    });
});


