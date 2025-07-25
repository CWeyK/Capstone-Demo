<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.guest')] class extends Component {

    public LoginForm $form;

    public function mount()
    {
        if (!App::environment('production')) {
            $this->form->email    = 'test@mail.com';
            $this->form->password = 'test';
        }
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        try {

            $this->form->validate();

            $this->form->authenticate();

            Session::regenerate();

            $this->redirectIntended(
                default: route('admin.dashboard', absolute: false),
                navigate: true
            );

        } catch (Exception $e) {

            $this->addError('form.email', $e->getMessage());
        }
    }
}; ?>

<div>
    <div class="d-flex justify-content-center">
        <a href="javascript:void(0)" class="mb-12">
            {{-- <img src="{{ secure_asset('assets/logo/IMG_0152.png') }}" class="h-80px rounded" alt="Logo"> --}}
        </a>
    </div>

    <form class="form w-100" wire:submit="login">
        <div class="text-center mb-11">
            {{--  Name of website --}}
            <h2 class="fw-bold fs-1 text-primary mb-4" style="letter-spacing:2px;">
                {{ config('app.name') }}
            </h2>
            <h1 class="text-gray-900 fw-bolder mb-3">Sign In</h1>
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
            <x-input class="bg-transparent" placeholder="Email" autocomplete="off" autofocus wire:model="form.email"/>
            <x-input-error :messages="$errors->get('form.email')" class="mt-2"/>
        </div>

        <div class="fv-row mb-8">
            <x-input type="password" class="bg-transparent" placeholder="Password" autocomplete="off"
                     wire:model="form.password"/>
            <x-input-error :messages="$errors->get('form.password')" class="mt-2"/>
        </div>

        <div class="d-grid mb-10">
            <x-button class="btn-primary">
                <x-button-indicator :label="__('Sign In')" target="login"/>
            </x-button>
        </div>

    </form>
</div>
