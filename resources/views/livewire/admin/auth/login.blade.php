<?php

use App\Livewire\Admin\Auth\LoginForm;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest-admin')] class extends Component {
    public LoginForm $form;

    public function login()
    {
        $this->form->authenticate();
        $this->redirectIntended(default: route('admin.dashboard'), navigate: true);
    }
}; ?>

<div class="container py-4">
    <x-auth-session-status class="mb-4" :status="session('status')"/>

    <div class="container d-flex justify-content-center align-items-center mt-5">
        <div class="card bg-body-secondary p-4 shadow rounded-4" style="min-width: 350px; max-width: 400px;">
            <h2 class="mb-4 text-center">Вход для Админа</h2>
            <form wire:submit="login">
                <div class="mb-3">
                    <x-input-label for="email" :value="__('Email')"/>
                    <x-text-input wire:model="form.email" id="email" class="form-control" type="email" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                </div>

                <div class="mb-3">
                    <x-input-label for="password" :value="__('Пароль')"/>
                    <x-text-input wire:model="form.password" id="password" class="form-control" type="password" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                </div>

                <div class="mb-3">
                    <x-primary-button class="btn btn-primary w-100">
                        {{ __('Вход') }}
                    </x-primary-button>
                </div>

                <div class="mb-3">
                    <label class="inline-flex items-center">
                        <input wire:model="form.remember" type="checkbox" class="rounded">
                        <span class="ms-2 text-sm">{{ __('Запомнить меня') }}</span>
                    </label>
                </div>

            </form>
        </div>
    </div>
</div>


