<?php

use Livewire\Volt\Component;
use App\Models\User;
use Livewire\Attributes\On;
use Carbon\Carbon;

new class extends Component {

    public User $user;

    #[On('userUpdated')]
    public function refreshDetails()
    {
        $this->user->refresh();
    }

}; ?>

<div>
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            <div class="d-flex flex-wrap flex-sm-nowrap">
                <div class="me-7 mb-4">
                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                        <img src={{ $user->profileImg() }} alt="image" />
                    </div>
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center mb-2">
                                <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $user->name
                                    }}</a>
                            </div>
                            <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                <a href="#"
                                    class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                    <i class="ki-outline ki-profile-circle fs-4 me-1"></i>{{ $user->roleName }}</a>
                                <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary mb-2">
                                    <i class="ki-outline ki-sms fs-4 me-1"></i>{{ $user->email }}</a>
                            </div>
                        </div>
                    </div>
                    @if($user->hasRole('Student'))
                    <div class="d-flex flex-wrap flex-stack">
                        <div class="d-flex flex-column flex-grow-1 pe-8">
                            <div class="d-flex flex-wrap">
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="fs-2 fw-bold">
                                            {{ $user->programme->name }}
                                        </div>
                                    </div>
                                    <div class="fw-semibold fs-6 text-gray-400 text-center">
                                        <div class="d-flex justify-content-center">
                                            <span class="badge badge-light-primary mt-2">
                                                Programme
                                            </span>
                                        </div>
                                    </div>
                                </div>                 
                                
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                @if($user->hasRole('Student') || $user->hasRole('Lecturer'))
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                        href="#user_schedule" wire:ignore.self>Schedule</a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>
