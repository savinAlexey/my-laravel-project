<?php

namespace App\Livewire\Account;

class Subscriptions extends BaseAccountData
{
    public function mount()
    {
        $this->loadSharedData(auth()->id());
    }

    public function render()
    {
        return view('livewire.account.subscriptions')->layout('layouts.app');
    }
}
