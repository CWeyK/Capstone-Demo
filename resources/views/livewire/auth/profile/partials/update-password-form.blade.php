<div x-data="{ open: false }" x-on:password-updated.window="open = false">
    <div class="d-flex flex-wrap align-items-center mb-10">
        <div id="kt_signin_password" x-show="!open">
            <div class="fs-6 fw-bold mb-1">{{ __('Password') }}</div>
            <div class="fw-semibold text-gray-600">************</div>
        </div>

        <div class="flex-row-fluid" x-show="open">
            <form wire:submit.prevent="updatePassword">
                <div class="row mb-1">
                    <div class="col-lg-4">
                        <div class="fv-row mb-0">
                            <x-label
                                for="currentPassword"
                                :name="__('Current Password')"
                                class="mb-3 fw-bold"
                            />

                            <x-input
                                type="password"
                                id="currentPassword"
                                wire:model="current_password"
                                class="form-control-lg form-control-solid"
                            />
                            <x-input-error :messages="$errors->get('current_password')" class="mt-2"/>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="fv-row mb-0">
                            <x-label
                                for="newPassword"
                                :name="__('New Password')"
                                class="mb-3 fw-bold"
                            />

                            <x-input
                                type="password"
                                id="newPassword"
                                wire:model="password"
                                class="form-control-lg form-control-solid"
                            />
                            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="fv-row mb-0">
                            <x-label
                                for="confirmPassword"
                                :name="__('Confirm New Password')"
                                class="mb-3 fw-bold"
                            />

                            <x-input
                                type="password"
                                id="confirmPassword"
                                wire:model="password_confirmation"
                                class="form-control-lg form-control-solid"
                            />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
                        </div>
                    </div>
                </div>

                <div class="form-text mb-5">Password must be at least 8 character and contain symbols</div>

                <div class="d-flex">
                    <x-button class="btn-primary me-2 px-6">
                        <x-button-indicator :label="__('Update Password')" target="Password"/>
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

        <div id="kt_signin_password_button" class="ms-auto" x-show="!open">
            <x-button class="btn-light btn-active-light-primary" x-on:click="open = ! open">
                {{ __('Update Password') }}
            </x-button>
        </div>
    </div>
</div>
