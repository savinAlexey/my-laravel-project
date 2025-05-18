<?php

use App\Livewire\Account\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('account.subscriptions', absolute: false), navigate: true);
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')"/>

    <div class="container d-flex justify-content-center align-items-center mt-5">
        <div class="card bg-body-secondary p-4 shadow rounded-4" style="min-width: 350px; max-width: 400px;">
            <h2 class="mb-4 text-center">Вход</h2>
            <form wire:submit="login" class="needs-validation {{ $errors->any() ? 'was-validated' : '' }}" novalidate>
                <!-- Email Address -->
                <div class="mb-3">
                    <x-input-label for="email" value="{{ __('Email') }}" required/>
                    <x-text-input
                            wire:model="form.email"
                            id="email"
                            class="form-control"
                            type="email"
                            name="email"
                            required
                            autofocus
                            autocomplete="username"
                    />
                    <x-input-error :messages="$errors->get('form.email')" icon/>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <x-input-label for="password" :value="__('Password')"/>

                    <x-text-input wire:model="form.password" id="password" class="form-control" type="password"
                                  name="password" required autocomplete="current-password"/>

                    <x-input-error :messages="$errors->get('form.password')" icon/>
                </div>

                <!-- Remember Me -->
                <div class="mb-3 form-check">
                    <input wire:model="form.remember" id="remember" type="checkbox" class="form-check-input"
                           name="remember">
                    <label for="remember_me" class="form-check-label small text-muted">
                        {{ __('Запомните меня') }}
                    </label>
                </div>

                <div class="mb-3">
                    <x-primary-button class="btn btn-primary w-100">
                        {{ __('Вход') }}
                    </x-primary-button>
                </div>
                <div class="mb-3">
                    @if (Route::has('password.request'))
                        <a class="small text-decoration-none"
                           href="{{ route('password.request') }}" wire:navigate>
                            {{ __('Забыли пароль?') }}
                        </a>
                    @endif


                </div>
            </form>
        </div>
    </div>
</div>
