<?php

use Livewire\Volt\Component;
use Illuminate\Database\Eloquent\Model;

new class extends Component
{
    public \App\Models\User $user;
}; ?>

<div>
    <div class="d-flex flex-wrap flex-stack">
        <div class="d-flex flex-column flex-grow-1 pe-8">
            <div class="d-flex flex-wrap">
                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                    <div class="d-flex align-items-center">
                        <i class="ki-outline ki-arrow-up fs-3 text-success me-2"></i>
                        <div class="fs-2 fw-bold counted">80</div>
                    </div>
                    <div class="fw-semibold fs-6 text-gray-500">Total Projects</div>
                </div>
            </div>
        </div>

        <!--begin::Progress-->
        <livewire:auth.profile.progress :user="Auth::user()"/>
        <!--end::Progress-->
    </div>
</div>
