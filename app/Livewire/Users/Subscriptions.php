<?php

namespace App\Livewire\Users;

use App\Models\Subscription;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Subscriptions extends Component
{
    public function render()
    {
        $subscriptions = Subscription::with('platform')
            ->where('user_id', Auth::id())
            ->where('active', true)
            ->get();

        return view('livewire.user.subscriptions', compact('subscriptions'))
            ->layout('layouts.app');
    }
}
