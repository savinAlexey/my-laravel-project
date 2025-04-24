<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
//use App\Http\Controllers\SwegoController;
//use App\Http\Controllers\AvitoController;
//use App\Http\Controllers\TelegramController;

// Webhooks
Route::post('/yookassa/webhook', [PaymentController::class, 'handleWebhook']);

// Swego API
//Route::prefix('swego')->group(function () {
//    Route::get('/products', [SwegoController::class, 'getProducts']);
//    Route::post('/filters', [SwegoController::class, 'applyFilters']);
//    // и т.д.
//});
//
//// Avito API
//Route::prefix('avito')->group(function () {
//    Route::get('/ads', [AvitoController::class, 'listAds']);
//    Route::post('/ads', [AvitoController::class, 'createAd']);
//    // и т.д.
//});
//
//// Telegram API
//Route::prefix('telegram')->group(function () {
//    Route::post('/send', [TelegramController::class, 'sendMessage']);
//    // и т.д.
//});


