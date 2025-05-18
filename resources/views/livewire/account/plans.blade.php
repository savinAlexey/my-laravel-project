<?php

use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.app')] class extends Component {
    public function subscribe($planId)
    {
        // Пример: редирект на страницу оплаты
        $this->redirectRoute('account.checkout', ['plan' => $planId], navigate: true);
    }
}; ?>

<div class="container py-4">
    <h2 class="mb-4">Выберите подписку</h2>

    <div class="row">
        @foreach(SubscriptionPlan::with('platform')->get() as $plan)
            <div class="col-md-4 mb-4">
                <div class="card bg-dark text-light h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $plan->platform?->name ?? 'Без платформы' }}</h5>
                        <p class="card-text">{{ $plan->description }}</p>
                        <p class="card-text">Цена: {{ number_format($plan->price, 2) }} ₽</p>
                        <button wire:click="subscribe({{ $plan->id }})" class="btn btn-primary">
                            Подписаться
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

