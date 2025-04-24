<?php

namespace App\Livewire\Users;

use App\Models\SubscriptionPlan;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use YooKassa\Client;

class Checkout extends Component
{
    public $plan;

    public function mount($plan)
    {
        // Загружаем план по переданному ID
        $this->plan = SubscriptionPlan::findOrFail($plan);
    }

    /**
     * @return RedirectResponse
     */
    public function pay()
    {
        try {
            $client = new Client();
            $client->setAuth(
                config('services.yookassa.shop_id'),
                config('services.yookassa.secret_key')
            );

            // Создание платежа через YooKassa
            $payment = $client->createPayment([
                'amount' => [
                    'value' => number_format($this->plan->price, 2, '.', ''),
                    'currency' => $this->plan->currency ?? 'RUB',
                ],
                'payment_method_data' => [
                    'type' => 'bank_card',
                    'save_payment_method' => true,
                ],
                'confirmation' => [
                    'type' => 'redirect',
                    'return_url' => route('account.payment.success'),
                ],
                'description' => 'Подписка на ' . $this->plan->platform->name,
                'metadata' => [
                    'user_id' => auth()->id(),
                    'plan_id' => $this->plan->id,
                ],
                'capture' => true
            ]);

            // Перенаправление на страницу подтверждения платежа
            return redirect()->away($payment->getConfirmation()->getConfirmationUrl());
        } catch (\Exception $e) {
            // Обработка ошибок и редирект на страницу с ошибкой
            session()->flash('error', 'Произошла ошибка при создании оплаты: ' . $e->getMessage());
            return redirect()->route('account.payment.failed');
        }
    }

    public function render()
    {
        return view('livewire.user.checkout')->layout('layouts.app');
    }
}
