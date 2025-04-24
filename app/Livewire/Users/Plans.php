<?php

namespace App\Livewire\Users;

use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class Plans extends Component
{
    public function render()
    {
        $plans = SubscriptionPlan::with('platform')->get();
        return view('livewire.user.plans', compact('plans'))->layout('layouts.app');
    }

    public function subscribe($planId)
    {
        $user = Auth::user();

        // Пример: редирект на фейковую страницу оплаты
        return Redirect::route('account.checkout', ['plan' => $planId]);
    }
}
