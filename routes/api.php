<?php

use App\Services\Swego\SwegoApiService;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;


// Webhooks
Route::post('/yookassa/webhook', [PaymentController::class, 'handleWebhook']);

Route::middleware(['auth:api', 'subscribed:swego_admin'])->get('/swego/admin/products', [SwegoApiService::class, 'getAdminProducts']);
Route::middleware(['auth:api', 'subscribed:swego_url'])->get('/swego/url/products', [SwegoApiService::class, 'getUrlProducts']);


