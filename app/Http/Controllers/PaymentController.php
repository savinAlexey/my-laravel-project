<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionOrder;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use YooKassa\Client;
use YooKassa\Common\Exceptions\ApiConnectionException;
use YooKassa\Common\Exceptions\ApiException;
use YooKassa\Common\Exceptions\AuthorizeException;
use YooKassa\Common\Exceptions\BadApiRequestException;
use YooKassa\Common\Exceptions\ExtensionNotFoundException;
use YooKassa\Common\Exceptions\ForbiddenException;
use YooKassa\Common\Exceptions\InternalServerError;
use YooKassa\Common\Exceptions\NotFoundException;
use YooKassa\Common\Exceptions\ResponseProcessingException;
use YooKassa\Common\Exceptions\TooManyRequestsException;
use YooKassa\Common\Exceptions\UnauthorizedException;

class PaymentController extends Controller
{
    /**
     * @throws NotFoundException
     * @throws ApiException
     * @throws ResponseProcessingException
     * @throws BadApiRequestException
     * @throws ExtensionNotFoundException
     * @throws AuthorizeException
     * @throws InternalServerError
     * @throws ForbiddenException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     * @throws ApiConnectionException
     */
    public function createSubscription(Request $request)
    {
        // Валидация входных данных
        $request->validate(['plan_id' => 'required|exists:subscription_plans,id']);

        $planId = $request->input('plan_id');
        $plan = SubscriptionPlan::findOrFail($planId);

        try {
            $client = new Client();
            $client->setAuth(
                config('services.yookassa.shop_id'),
                config('services.yookassa.secret_key')
            );

            // Создание заказа
            $order = SubscriptionOrder::create([
                'user_id' => auth()->id(),
                'subscription_plan_id' => $plan->id,
                'status' => 'pending',
            ]);

            // Создание платежа
            $payment = $client->createPayment([
                'amount' => [
                    'value' => number_format($plan->price, 2, '.', ''),
                    'currency' => $plan->currency ?? 'RUB',
                ],
                'payment_method_data' => [
                    'type' => 'bank_card',
                    'save_payment_method' => true,
                ],
                'confirmation' => [
                    'type' => 'redirect',
                    'return_url' => route('account.payment.success'),
                ],
                'description' => 'Подписка: ' . $plan->platform->name,
                'metadata' => [
                    'order_id' => $order->id,
                ],
                'capture' => true
            ]);

            // Сохранение ID платежа в заказе
            $order->update([
                'payment_id' => $payment->getId(),
            ]);

            // Перенаправление на страницу подтверждения платежа
            return redirect($payment->getConfirmation()->getConfirmationUrl());
        } catch (\Exception $e) {
            // Обработка ошибок и редирект на страницу с ошибкой
            session()->flash('error', 'Произошла ошибка при создании оплаты: ' . $e->getMessage());
            return redirect()->route('account.payment.failed');
        }
    }

    public function handleWebhook(Request $request)
    {
        \Log::info('YooKassa Webhook received', ['payload' => $request->all()]);

        $event = $request->all();
        $payment = $event['object'] ?? null;

        // Проверка, что это успешный платеж
        if (! $payment || ($payment['status'] ?? '') !== 'succeeded') {
            return response()->json(['status' => 'ignored', 'reason' => 'Not a succeeded payment']);
        }

        $paymentId = $payment['id'] ?? null;

        if (! $paymentId) {
            return response()->json(['status' => 'error', 'message' => 'Missing payment ID'], 400);
        }

        // Поиск заказа
        $order = SubscriptionOrder::where('payment_id', $paymentId)->first();

        if (! $order) {
            \Log::warning('YooKassa Webhook: Order not found', ['payment_id' => $paymentId]);
            return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
        }

        // Обновление статуса, только если ещё не оплачен
        $updated = $order->where('status', '!=', 'paid')->update(['status' => 'paid']);
        if (! $updated) {
            return response()->json(['status' => 'ok', 'message' => 'Already processed']);
        }

        // Проверка связанного плана
        if (!isset($order->plan) || !$order->plan->platform_id) {
            \Log::error('Missing subscription plan or platform ID', ['order_id' => $order->id]);
            return response()->json(['status' => 'error', 'message' => 'Plan or platform not set'], 400);
        }

        $userId = $order->user_id;
        $platformId = $order->plan->platform_id;

        // Проверка на существующую активную подписку
        $hasActive = Subscription::where('user_id', $userId)
            ->where('platform_id', $platformId)
            ->where('active', true)
            ->exists();

        if (! $hasActive) {
            Subscription::create([
                'user_id'     => $userId,
                'platform_id' => $platformId,
                'starts_at'   => now(),
                'ends_at'     => now()->addDays($order->plan->period),
                'active'      => true,
            ]);
        }

        return response()->json(['status' => 'ok']);
    }
}
