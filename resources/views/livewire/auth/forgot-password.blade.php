<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Traits\LivewireAlert;

new #[Layout('components.layouts.guest')] class extends Component
{
    use LivewireAlert;

    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::broker('users')->sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');
        $this->alertSuccess(__($status));
    }
}; ?>

<div>
    <form class="form w-100" wire:submit="sendPasswordResetLink">
        <div class="text-center mb-10">
            <h1 class="text-gray-900 fw-bolder mb-3">
                {{ __('Forgot Password ?') }}
            </h1>
            <div class="text-gray-500 fw-semibold fs-6">
                {{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>
        </div>

        <div class="fv-row mb-8">
            <x-input class="bg-transparent"
                     placeholder="Email"
                     autocomplete="off"
                     autofocus
                     wire:model="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="d-grid mb-8">
            <x-button class="btn-primary">
                <x-button-indicator :label="__('Email Password Reset Link')" target="sendPasswordResetLink"/>
            </x-button>
        </div>

        <div class="text-center fs-base fw-semibold">
            <a href="{{ route('admin.login') }}" wire:navigate
               class="link-primary">{{ __('Back to login') }}</a>
        </div>
    </form>

    <x-alert />
</div>
