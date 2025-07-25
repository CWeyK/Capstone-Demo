<?php

use App\Livewire\Forms\UserForm;
use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use App\Traits\LivewireAlert;

new #[Layout('components.layouts.guest')] class extends Component {
    use LivewireAlert;

    public UserForm $form;

    public LoginForm $loginForm;

    public string $code;

    public function mount()
    {
        $this->form->code = $this->code;
        $this->form->agent = User::where('referral_code', $this->code)->firstOrFail()->name;
    }

    /**
     * Handle an incoming authentication request.
     */
    public function register(): void
    {
        $validatedData = $this->form->validate([
                'name'                  => ['required', 'string'],
                'mobile_number'         => ['required', 'string'],
                'email'                 => ['required', 'string', 'email', Rule::unique('users', 'email')],
                'password'              => ['required', Password::min(8)
                                            ->mixedCase()
                                            ->numbers()
                                            ->symbols()
                                            ->uncompromised(), 
                                        'confirmed'],
            ]);

        try {

            $this->form->registerUser($validatedData, $this->code);

            $this->redirectIntended(
                default: route('admin.login', absolute: false),
                navigate: true
            );

        } catch (Exception $e) {
            $this->alertError($e->getMessage());
        }
    }
}; ?>

<div>
    <div class="d-flex justify-content-center">
        <a href="javascript:void(0)" class="mb-12">
            <img src="{{ secure_asset('assets/logo/IMG_0152.png') }}" class="h-80px rounded" alt="Logo">
        </a>
    </div>

    <form class="form w-100" wire:submit="register">
        <div class="text-center mb-11">
            <h1 class="text-gray-900 fw-bolder mb-3">Agent Registration</h1>
            <div class="text-gray-500 fw-semibold fs-6">Administrator Portal</div>
        </div>

        @if (session('message'))
            <div class="alert alert-dismissible bg-light-danger border border-danger border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-10">
                <i class="ki-duotone ki-message-text-2 fs-2hx text-danger me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                <div class="d-flex flex-column pe-0 pe-sm-10">
                    <h5 class="mb-1">Oops! Something went wrong</h5>
                    <span>{{ session('message') }}</span>
                </div>

                <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                    <i class="ki-duotone ki-cross fs-1 text-danger"><span class="path1"></span><span class="path2"></span></i>
                </button>
            </div>
        @endif

        <div class="fv-row mb-8">
            <x-label name="Referral" class="fw-bold mb-2" />
            <x-input class="bg-transparent" placeholder="Agent Name" autocomplete="off" readonly wire:model="form.agent"/>
            <x-input-error :messages="$errors->get('form.agent')" class="mt-2"/>
        </div>

        <div class="fv-row mb-8">
            <x-label name="Full Name" :required="true" class="fw-bold mb-2" />
            <x-input class="bg-transparent" placeholder="Full Name" autocomplete="off" wire:model="form.name"/>
            <x-input-error :messages="$errors->get('form.name')" class="mt-2"/>
        </div>  

        <div class="fv-row mb-8">
            <x-label name="Email Address" :required="true" class="fw-bold mb-2" />
            <x-input class="bg-transparent" type="email" placeholder="example@domain.com" autocomplete="off" wire:model="form.email"/>
            <x-input-error :messages="$errors->get('form.email')" class="mt-2"/>
        </div>

        <div class="fv-row mb-8">
            <x-label name="Mobile Number" :required="true" class="fw-bold mb-2" />
            <x-input class="bg-transparent" placeholder="01xxxxxxxx" autocomplete="off" wire:model="form.mobile_number"/>
            <x-input-error :messages="$errors->get('form.mobile_number')" class="mt-2"/>
        </div>

        <div class="fv-row mb-8">
            <x-label name="Password" :required="true" class="fw-bold mb-2" />
            <x-input type="password" class="bg-transparent" placeholder="Password" autocomplete="off" wire:model="form.password"/>
            <p class="mt-2 text-gray-500">Use 8 or more characters with a mix of letters, numbers & symbols.</p>
            <x-input-error :messages="$errors->get('form.password')" class="mt-2"/>
        </div>

        <div class="fv-row mb-8">
            <x-label name="Confirm Password" :required="true" class="fw-bold mb-2" />
            <x-input type="password" class="bg-transparent" placeholder="Password" autocomplete="off"
                     wire:model="form.password_confirmation"/>
            <x-input-error :messages="$errors->get('form.password_confirmation')" class="mt-2"/>
        </div>

        <div class="d-grid mb-10">
            <x-button class="btn-primary">
                <x-button-indicator :label="__('Submit')" target="register"/>
            </x-button>
        </div>

    </form>
</div>
