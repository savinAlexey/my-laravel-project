<?php

use App\Livewire\Users\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="mb-4">
    <header class="mb-3">
        <h2 class="h5 text-dark">
            {{ __('app.delete_account') }}
        </h2>

        <p class="text-muted small">
            {{ __('app.delete_account_warning') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="btn btn-danger"
    >{{ __('app.delete_account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-3">

            <h2 class="h5 text-dark mb-3">
                {{ __('app.delete_account_confirmation') }}
            </h2>

            <p class="text-muted small mb-4">
                {{ __('app.delete_account_password_prompt') }}
            </p>

            <div class="mb-3">
                <x-input-label for="password" value="{{ __('app.password') }}" class="visually-hidden"/>

                <x-text-input
                    wire:model="password"
                    id="password"
                    name="password"
                    type="password"
                    class="form-control"
                    placeholder="{{ __('app.password') }}"
                />

                <x-input-error :messages="$errors->get('password')" class="invalid-feedback d-block"/>
            </div>

            <div class="d-flex justify-content-end">
                <x-secondary-button x-on:click="$dispatch('close')" class="btn btn-secondary me-2">
                    {{ __('app.cancel') }}
                </x-secondary-button>

                <x-danger-button class="btn btn-danger">
                    {{ __('app.delete_account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>

