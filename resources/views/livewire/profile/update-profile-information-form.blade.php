<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('account.dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>
<section class="mb-4">
    <header class="mb-4">
        <h2 class="h5">
            {{ __('app.profile_information') }}
        </h2>

        <p class="text-muted small">
            {{ __("app.update_profile_information") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mb-3">
        <div class="mb-3">
            <x-input-label for="name" :value="__('app.name')" />
            <x-text-input
                wire:model="name"
                id="name"
                name="name"
                type="text"
                class="form-control"
                required
                autofocus
                autocomplete="name"
            />
            <x-input-error class="invalid-feedback d-block" :messages="$errors->get('name')" />
        </div>

        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input
                wire:model="email"
                id="email"
                name="email"
                type="email"
                class="form-control"
                required
                autocomplete="username"
            />
            <x-input-error class="invalid-feedback d-block" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="small text-dark">
                        {{ __('app.email_unverified') }}

                        <button
                            wire:click.prevent="sendVerification"
                            class="btn btn-link p-0 text-decoration-none"
                        >
                            {{ __('app.click_to_resend') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 small text-success">
                            {{ __('app.verification_link_sent') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <x-primary-button class="btn btn-primary">{{ __('app.save') }}</x-primary-button>

            <x-action-message class="text-success ms-3" on="profile-updated">
                {{ __('app.saved') }}
            </x-action-message>
        </div>
    </form>
</section>


