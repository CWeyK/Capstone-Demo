<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

new #[On(['profile-updated', 'auth-profile-updated', 'email-updated'])] class extends Component {

    public ?User $user = null;

    public function mount(): void
    {
        if ($this->user === null) {
            $this->user = Auth::user();
        }
    }

    #[On('profileUpdated')] 
    public function refreshDetails()
    {
        $this->user->refresh(); 
    }
}; ?>

<div class="card mb-5 mb-xl-10">
    <div class="card-body pt-9 pb-0">

        <!--begin::Profile Details-->
        <div class="d-flex flex-wrap flex-sm-nowrap">
            <div class="me-7 mb-4">
                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                    <img src="{{ $user->profileImg() }}" alt="image">
                    <div
                        class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                </div>
            </div>

            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center mb-2">
                            <a href="javascript:void(0)"
                               class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">
                                {{ $user->name }}
                            </a>
                            <i class="ki-outline ki-verify fs-1 text-primary"></i>
                        </div>

                        <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                            <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                <i class="ki-outline ki-profile-circle fs-4 me-1"></i>
                                {{ $user->roleName }}
                            </a>

                            <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                <i class="ki-outline ki-phone fs-4 me-1"></i>
                                {{ $user->mobile_number }}
                            </a>

                            <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary mb-2">
                                <i class="ki-outline ki-sms fs-4 me-1"></i>{{ $user->email }}
                            </a>
                        </div>
                    </div>
                </div>

                <!--begin::Stats-->
                <livewire:auth.profile.stats :user="$user"/>
                <!--end::Stats-->
            </div>
        </div>
        <!--end::Profile Details-->

        <!--begin::Navs-->
        @include('livewire.auth.profile.partials._header', [
            'userId' => Route::is(['admin.users.show', 'admin.users.settings']) ? $user->id : null
        ])
        <!--begin::Navs-->
    </div>
</div>
