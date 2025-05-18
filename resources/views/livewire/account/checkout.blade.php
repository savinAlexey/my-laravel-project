<?php

use App\Models\SubscriptionPlan;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use YooKassa\Client;

new #[Layout('layouts.app')] class extends Component {
    public SubscriptionPlan $plan;

    public function mount($plan): void
    {
        $this->plan = SubscriptionPlan::findOrFail($plan);
    }

    public function pay()
    {
        try {
            $client = $this->createYooKassaClient();
            $payment = $this->createPayment($client);

            $this->redirect($payment->getConfirmation()->getConfirmationUrl());
        } catch (\Exception $e) {
            session()->flash('error', 'Ошибка оплаты: ' . $e->getMessage());
            $this->redirectRoute('account.payment.failed', navigate: true);
        }
    }

    protected function createYooKassaClient(): Client
    {
        $client = new Client();
        $client->setAuth(
            config('services.yookassa.shop_id'),
            config('services.yookassa.secret_key')
        );
        return $client;
    }

    protected function createPayment(Client $client)
    {
        return $client->createPayment([
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
    }
}; ?>

<div class="container py-4">
    <h2 class="mb-4">Оформление подписки</h2>

    <div class="card bg-dark text-light">
        <div class="card-body">
            <h5 class="card-title">{{ $plan->platform->name }}</h5>
            <p class="card-text">{{ $plan->description }}</p>
            <p class="h4 my-3">Цена: {{ number_format($plan->price, 2) }} ₽</p>

            <button wire:click="pay" class="btn btn-success btn-lg w-100">
                <i class="bi bi-credit-card me-2"></i>Оплатить
            </button>

            <a href="{{ route('account.plans') }}"
               class="btn btn-outline-light mt-3 w-100"
               wire:navigate>
                ← Вернуться к выбору подписки
            </a>
        </div>
    </div>
</div>
