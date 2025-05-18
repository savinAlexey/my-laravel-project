<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated account.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section class="mb-4">
    <header class="mb-4">
        <h2 class="h5 text-dark">
            {{ __('app.update_password') }}
        </h2>

        <p class="text-muted small">
            {{ __('app.password_security_tip') }}
        </p>
    </header>

    <form wire:submit="updatePassword" class="mb-3">
        <div class="mb-3">
            <x-input-label for="update_password_current_password" :value="__('app.current_password')" />
            <x-text-input
                wire:model="current_password"
                id="update_password_current_password"
                name="current_password"
                type="password"
                class="form-control"
                autocomplete="current-password"
            />
            <x-input-error :messages="$errors->get('current_password')" class="invalid-feedback d-block" />
        </div>

        <div class="mb-3">
            <x-input-label for="update_password_password" :value="__('app.new_password')" />
            <x-text-input
                wire:model="password"
                id="update_password_password"
                name="password"
                type="password"
                class="form-control"
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->get('password')" class="invalid-feedback d-block" />
        </div>

        <div class="mb-3">
            <x-input-label for="update_password_password_confirmation" :value="__('app.confirm_password')" />
            <x-text-input
                wire:model="password_confirmation"
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                class="form-control"
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="invalid-feedback d-block" />
        </div>

        <div class="d-flex align-items-center gap-3">
            <x-primary-button class="btn btn-primary">{{ __('app.save') }}</x-primary-button>

            <x-action-message class="text-success ms-3" on="password-updated">
                {{ __('app.saved') }}
            </x-action-message>
        </div>
    </form>
</section>

