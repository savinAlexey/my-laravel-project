<?php

use App\Http\Controllers\PaymentController;
use App\Livewire\Account\Subscriptions;
use App\Livewire\Account\SwegoCatalog;
use App\Livewire\Account\SwegoSettingsForm;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerifyEmailController;
use Livewire\Volt\Volt;



// Гостевые маршруты для пользователей
Route::middleware(['guest:web', 'no-admin'])->group(function () {
    Route::view('/', 'welcome');
    Volt::route('register', 'pages.auth.register')->name('register');
    Volt::route('login', 'pages.auth.login')->name('login');
    Volt::route('forgot-password', 'pages.auth.forgot-password')->name('password.request');
    Volt::route('reset-password/{token}', 'pages.auth.reset-password')->name('password.reset');
});

Route::prefix('account')->middleware(['auth:web', 'no-admin'])->name('account.')->group(function () {
    Route::view('profile', 'profile')->name('profile');
    Route::get('subscriptions', Subscriptions::class)->name('subscriptions');
    Volt::route('plans', 'account.plans')->name('plans');
    Volt::route('checkout/{plan}', 'account.checkout')->name('checkout');

    // ✅ Создание платежа
    Route::post('/payment/create', [PaymentController::class, 'createSubscription'])->name('payment.create');

    // ✅ Успешная оплата
    Route::get('/payment/success', function () {
        return redirect()->route('account.subscriptions')->with('success', 'Подписка успешно оформлена!');
    })->name('payment.success');

    // ✅ Маршруты swego
    // Группа с проверкой подписки (для всех маршрутов, где она нужна)

    Route::middleware(['auth', 'swego.subscription'])->group(function () {
        // Настройки (требуется только подписка)
        Route::get('/swego/settings', SwegoSettingsForm::class)
            ->name('swego.settings');

        Route::get('/swego/catalog/{type}', SwegoCatalog::class)
            ->name('swego.catalog');

    });


    // Верификация почты
    Volt::route('verify-email', 'pages.auth.verify-email')->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    // Подтверждение пароля
    Volt::route('confirm-password', 'pages.auth.confirm-password')->name('password.confirm');
});

require __DIR__.'/admin.php';




