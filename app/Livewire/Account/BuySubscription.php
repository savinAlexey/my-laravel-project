<?php

namespace App\Livewire\Account;

use Livewire\Component;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Auth;

class BuySubscription extends Component
{
    public $planId;

    public function buySubscription()
    {
        $plan = SubscriptionPlan::find($this->planId);

        if ($plan) {
            // Пример: использование Cashier для создания подписки
            Auth::user()->newSubscription('default', $plan->code)->create();

            session()->flash('message', 'Подписка успешно оформлена!');
        } else {
            session()->flash('error', 'Выбранный план не существует.');
        }
    }

    public function render()
    {
        $plans = SubscriptionPlan::all(); // Получаем все доступные планы

        return view('livewire.account.buy-subscription', compact('plans'))
            ->layout('layouts.app');
    }
}
