<?php

use App\Livewire\Users\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>


    <!-- Сайдбар -->
<div class="sidebar" id="sidebar">
    <div class="logo">
        <i class="bi bi-person-circle me-2"></i><span class="link-text">Личный кабинет</span>
    </div>
    <a href="{{ route('account.dashboard') }}" wire:navigate>
        <i class="bi bi-house"></i>
        <span class="link-text">Главная</span>
    </a>
    <a href="{{ route('account.subscriptions') }}">
        <i class="bi bi-box-seam"></i>
        <span class="link-text">Мои подписки</span>
    </a>
    <a href="{{ route('account.plans') }}">
        <i class="bi bi-stars"></i>
        <span class="link-text">Купить подписку</span>
    </a>
    <a href="{{ route('account.profile') }}">
        <i class="bi bi-person"></i>
        <span class="link-text">{{ __('app.profile') }}</span>
    </a>
    <a href="#" wire:click="logout" role="button">
        <i class="bi bi-box-arrow-right"></i>
        <span class="link-text">{{ __('logout') }}</span>
    </a>
</div>




