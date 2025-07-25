<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;
use App\Traits\LivewireAlert;

new #[Layout('components.layouts.guest')] class extends Component {

    use LivewireAlert;

    #[Locked]
    public string $token = '', $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token'    => ['required'],
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)
                                            ->mixedCase()
                                            ->numbers()
                                            ->symbols()
                                            ->uncompromised(), ],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::broker('users')->reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password'       => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));
            $this->alertError(__($status));
            return;
        }

        $this->redirectRoute('admin.login', navigate: true);
    }
}; ?>

<div>
    <form class="form w-100" wire:submit="resetPassword">
        <div class="text-center mb-10">
            <h1 class="text-gray-900 fw-bolder mb-3">
                {{ __('Setup New Password') }}
            </h1>
            <div class="text-gray-500 fw-semibold fs-6">
                {{ __('Have you already reset the password ?') }}
                <a href="{{ route('admin.login') }}" wire:navigate class="link-primary fw-bold">
                    {{ __('Sign in') }}
                </a>
            </div>
        </div>

        <div class="fv-row mb-8" data-kt-password-meter="true">
            <div class="mb-1">
                <div class="position-relative mb-3">
                    <x-input type="password"
                             class="bg-transparent"
                             placeholder="Password"
                             autofocus
                             wire:model="password"
                             name="password"
                             id="password"
                             autocomplete="off" />
                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                        <i class="ki-outline ki-eye-slash fs-2"></i>
                        <i class="ki-outline ki-eye fs-2 d-none"></i>
                    </span>
                </div>
                <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                </div>
            </div>
            <div class="text-muted">
                {{ __('Use 8 or more characters with a mix of letters, numbers & symbols.') }}
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="fv-row mb-8">
            <x-input type="password"
                     class="bg-transparent"
                     placeholder="Repeat Password"
                     wire:model="password_confirmation"
                     name="password_confirmation"
                     id="password_confirmation"
                     autocomplete="off" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="d-grid mb-8">
            <x-button class="btn-primary">
                <x-button-indicator :label="__('Reset Password')" target="resetPassword"/>
            </x-button>
        </div>
    </form>

    <x-alert />
</div>
