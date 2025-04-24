<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('account.dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="container d-flex justify-content-center align-items-center mt-5">
    <div class="card bg-body-secondary p-4 shadow rounded-4" style="min-width: 350px; max-width: 500px;">
        <form wire:submit="register" class="needs-validation {{ $errors->any() ? 'was-validated' : '' }}" novalidate>
            <!-- Name -->
            <div class="mb-3">
                <x-input-label for="name" :value="__('Имя')" />
                <x-text-input wire:model="name" id="name" class="form-control" type="text" name="name" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" icon />
            </div>

            <!-- Email Address -->
            <div class="mb-3">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input wire:model="email" id="email" class="form-control" type="email" name="email" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" icon />
            </div>

            <!-- Password -->
            <div class="mb-3">
                <x-input-label for="password" :value="__('Пароль')" />
                <x-text-input wire:model="password" id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" icon />
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <x-input-label for="password_confirmation" :value="__('Подтвердите пароль')" />
                <x-text-input wire:model="password_confirmation" id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" icon />
            </div>

            <div class="mb-3">
                <x-primary-button class="btn btn-primary w-100">
                    {{ __('Регистрация') }}
                </x-primary-button>
            </div>

            <div class="mb-3">
                <a href="{{ route('login') }}" wire:navigate>
                    {{ __('Уже зарегистрированы?') }}
                </a>
            </div>
        </form>
    </div>
</div>
