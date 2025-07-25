<div x-data="{ open: false }" x-on:email-updated.window="open = false">
    <div class="d-flex flex-wrap align-items-center">
        <div class="kt_signin_email" x-show="!open">
            <div class="fs-6 fw-bold mb-1">{{ __('Email Address') }}</div>
            <div class="fw-semibold text-gray-600">{{ $user->email }}</div>
        </div>

        <div class="flex-row-fluid" x-show="open">
            <form wire:submit.prevent="updateEmail">
                <div class="row mb-6">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="fv-row mb-0">
                            <x-label
                                for="email"
                                :name="__('Enter New Email Address')"
                                class="mb-3 fw-bold"
                            />

                            <x-input
                                type="email"
                                id="email"
                                wire:model="email"
                                class="form-control-lg form-control-solid"
                                placeholder="Email Address"
                            />
                            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="fv-row mb-0">
                            <x-label
                                for="confirmEmailPassword"
                                :name="__('Confirm Password')"
                                class="mb-3 fw-bold"
                            />

                            <x-input
                                type="password"
                                id="confirmEmailPassword"
                                wire:model="current_password"
                                class="form-control-lg form-control-solid"
                            />
                            <x-input-error :messages="$errors->get('current_password')" class="mt-2"/>
                        </div>
                    </div>
                </div>

                <div class="d-flex">
                    <x-button class="btn-primary me-2 px-6">
                        <x-button-indicator :label="__('Update Email')" target="updateEmail"/>
                    </x-button>

                    <x-button
                        type="button"
                        x-on:click="open = ! open"
                        class="btn-color-gray-500 btn-active-light-primary px-6">
                        {{ __('Cancel') }}
                    </x-button>
                </div>
            </form>
        </div>

        <div id="kt_signin_email_button" class="ms-auto" x-show="!open">
            <x-button class="btn-light btn-active-light-primary" x-on:click="open = ! open">
                {{ __('Change Email') }}
            </x-button>
        </div>
    </div>
</div>
