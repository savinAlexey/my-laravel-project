<?php

use App\Livewire\Admin\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect(route('admin.login'), navigate: true);
    }
};
?>


<!-- Сайдбар -->
<div class="sidebar" id="sidebar">
    <div class="logo">
        <i class="bi bi-speedometer2 me-2"></i><span class="link-text">Админка</span>
    </div>
    <a href="{{ route('admin.dashboard') }}" wire:navigate>
        <i class="bi bi-house"></i>
        <span class="link-text">Главная</span>
    </a>
    <a href="{{ route('admin.subscription-plans.index') }}">
        <i class="bi bi-card-checklist"></i>
        <span class="link-text">Планы подписки</span>
    </a>
    <a href="{{ route('admin.settings.platforms') }}">
        Управление платформами
    </a>
    <a href="{{ route('admin.users.index') }}">
        <i class="bi bi-people"></i>
        <span class="link-text">Пользователи</span>
    </a>
    <a href="#" wire:click="logout" role="button">
    <i class="bi bi-box-arrow-right"></i>
        <span class="link-text">{{ __('logout') }}</span>
    </a>
</div>



