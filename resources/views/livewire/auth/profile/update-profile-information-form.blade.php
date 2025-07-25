<?php

use App\Enum\UserGender;
use App\Livewire\Forms\ProfileForm;
use App\Models\User;
use App\Traits\LivewireAlert;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {

    use WithFileUploads, LivewireAlert;

    public ProfileForm $form;

    public User $user;

    public function mount(User $user){
        $this->user = $user;
        $this->form->setUser($this->user);
        $this->form->name = $this->user->name;
        $this->form->mobile_number = $this->user->mobileNumber;
        $this->form->whatsapp_number = $this->user->profile->whatsapp_number;
        $this->form->fb_domain_verification = $this->user->fb_domain_verification;
        $this->form->gender = $this->user->profile->gender;

    }
    
    public function update(): void
    {   
        $validatedData = $this->form->validate();

        try {

            $this->form->updateProfile(
                $validatedData, $this->user
            );

            $this->alertSuccess(
                __('Profile has been updated successfully.'), [
                    'timer'              => 3000,
                ]
            );

            $this->dispatch('profileUpdated');

            $this->dispatch('auth-profile-updated', name: $this->form->name);
            $this->dispatch('media-uploaded', name: auth()->user()->profileImg());

            $this->form->avatar = null;

        } catch (Throwable $e) {

            $this->alertError($e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->form->name = $this->user->name;
        $this->form->mobile_number = $this->user->mobileNumber;
        $this->form->whatsapp_number = $this->user->profile->whatsapp_number;
        $this->form->fb_domain_verification = $this->user->fb_domain_verification;
        $this->form->gender = $this->user->profile->gender;
    }
     
    public function removeAvatar(){
        $this->form->resetAvatar();
    }
}; ?>

<div>
    <div class="card mb-5 mb-xl-10">
        <div class="card-header border-0">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Profile Details</h3>
            </div>
        </div>
        <div id="kt_account_settings_profile_details" class="collapse show">
            <form id="kt_account_profile_details_form" class="form" wire:submit="update">
                <div class="card-body border-top p-9">
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Avatar</label>
                        <div class="col-lg-8">
                            <div class="image-input image-input-outline" data-kt-image-input="true"
                                style="background-image: url()">
                                <div wire:ignore class="image-input-wrapper w-125px h-125px"
                                    style="background-image: url({{ $user->profileImg() }})"></div>
                                <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                    <i class="ki-outline ki-pencil fs-7"></i>
                                    <input type="file" name="avatar" wire:model='form.avatar'
                                        accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="avatar_remove" />
                                </label>
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar"
                                    wire:ignore>
                                    <i class="ki-outline ki-cross fs-2"></i>
                                </span>
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar"
                                    wire:ignore wire:click='removeAvatar'>
                                    <i class="ki-outline ki-cross fs-2"></i>
                                </span>
                            </div>
                            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Full Name</label>
                        <div class="col-lg-8 fv-row">
                            <x-input wire:model="form.name" class="form-control-lg form-control-lg form-control-solid"
                                placeholder="Full Name" />
                            <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Mobile Number</label>
                        <div class="col-lg-8 fv-row">
                            <x-input wire:model="form.mobile_number"
                                class="form-control-lg form-control-lg form-control-solid" placeholder="01xxxxxxxxx" />
                            <x-input-error :messages="$errors->get('form.mobile_number')" class="mt-2" />
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">WhatsApp Number</label>
                        <div class="col-lg-8 fv-row">
                            <x-input wire:model="form.whatsapp_number"
                                class="form-control-lg form-control-lg form-control-solid" placeholder="01xxxxxxxxx" />
                            <x-input-error :messages="$errors->get('form.whatsapp_number')" class="mt-2" />
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Facebook Domain Verification</label>
                        <div class="col-lg-8 fv-row">
                            <x-input wire:model="form.fb_domain_verification"
                                class="form-control-lg form-control-lg form-control-solid"
                                placeholder="&lt;meta name=&quot;facebook-domain-verification&quot; content=&quot;&quot; /&gt;" />
                            <x-input-error :messages="$errors->get('form.fb_domain_verification')" class="mt-2" />
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Gender</label>
                        <div class="col-lg-8 fv-row">
                            <div class="d-flex align-items-center mt-3">
                                @foreach(UserGender::cases() as $gender)
                                <x-radio-input name="gender" :label="ucfirst(strtolower($gender->name))"
                                    :value="$gender->value" model="form.gender" />
                                @endforeach
                                <x-input-error :messages="$errors->get('form.gender')" class="mt-2" />
                            </div>
                        </div>
                    </div>


                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <x-button type="button" class="btn btn-light btn-active-light-primary me-2"
                            wire:click='resetForm'>
                            <x-button-indicator :label="__('Discard')" target="resetForm" />
                        </x-button>
                        <x-button type="submit" class="btn-primary">
                            <x-button-indicator :label="__('Update User')" target="update" />
                        </x-button>
                    </div>
            </form>
        </div>
    </div>
</div>

@script
<script>
    flatpickr('#date_of_birth', {
        dateFormat: 'Y-m-d',
        maxDate: 'today',
    });
</script>
@endscript
