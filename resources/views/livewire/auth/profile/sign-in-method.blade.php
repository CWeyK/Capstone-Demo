<?php

use App\Livewire\Forms\ProfileForm;
use App\Models\User;
use App\Traits\LivewireAlert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {

    use LivewireAlert;

    public ?String $email;

    public ?string $current_password;

    public ?string $password;

    public ?string $password_confirmation;

    public ProfileForm $form;

    public User $user;

    /**
     * Update the email address for the currently authenticated user.
     */
    public function updateEmail(): void
    {
        $validatedData = $this->validate([
            'current_password' => ['required', 'string'],
            'email'            => [
                'required', 'email',
                Rule::unique($this->user instanceof Admin ? (new Admin)->getTable() : (new User)->getTable())
            ],
        ]);

        try {

            $this->checkCurrentPassword($validatedData['current_password']);

            $this->form->updateEmail($validatedData, $this->user);

            $this->reset(['email', 'current_password']);

            $this->dispatch('auth-email-updated', email: $this->user->email);

            $this->alertSuccess(
                __('Email address has been updated successfully.'),
                ['timer' => 2000]
            );

        } catch (Throwable $e) {

            $this->alertError($e->getMessage());
        }
    }

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        $validatedData = $this->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string'],
        ]);

        try {

            $this->checkCurrentPassword($validatedData['current_password']);

            $this->form->updatePassword($validatedData, $this->user);

            $this->reset(['current_password', 'password', 'password_confirmation']);

            $this->dispatch('password-updated');

            $this->alertSuccess(
                __('Password has been updated successfully.'),
                ['timer' => 2000]
            );

        } catch (Throwable $e) {

            $this->alertError($e->getMessage());
        }
    }

    /**
     * Check the current password.
     *
     * @param  string  $password
     */
    private function checkCurrentPassword(string $password): void
    {
        if (!Hash::check($password, $this->user->password)) {
            $this->reset(['current_password', 'password', 'password_confirmation']);
            throw new RuntimeException(__('The provided password does not match your current password.'));
        }
    }
}; ?>

<div>
    <x-card class="mb-5 mb-xl-10">
        <x-slot name="header">
            <x-card-header :title="__('Sign-in Method')"/>
        </x-slot>

        <x-slot name="body">
            <x-card-body>
                @include('livewire.auth.profile.partials.update-email-form')
                <div class="separator separator-dashed my-6"></div>
                @include('livewire.auth.profile.partials.update-password-form')
            </x-card-body>
        </x-slot>
    </x-card>
</div>
