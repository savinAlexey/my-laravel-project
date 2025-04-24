<?php

namespace App\Livewire\Admin\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Logout
{
    public function __invoke(): void
    {
        Auth::guard('admin')->logout();

        Session::invalidate();
        Session::regenerateToken();
    }
}

