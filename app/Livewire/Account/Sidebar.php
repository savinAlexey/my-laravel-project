<?php

// app/Livewire/Account/Sidebar.php
namespace App\Livewire\Account;



use Symfony\Component\HttpFoundation\RedirectResponse;

class Sidebar extends BaseAccountData
{
    public function mount()
    {
        $this->loadSharedData(auth()->id());
    }

    public function logout(): void
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        $this->redirect('/', navigate: true);
    }
}

