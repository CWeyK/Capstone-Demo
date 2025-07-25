<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div>
    <livewire:auth.profile.overview />

    <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
        <div class="card-header">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Profile Details</h3>
            </div>
            <a href="{{ route('admin.account.settings') }}" wire:navigate class="btn btn-sm btn-primary align-self-center">Edit Profile</a>
        </div>

        <div class="card-body p-9">
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Full Name</label>
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ Auth::user()->name }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Referral Code</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-bold fs-6 text-gray-800">{{ Auth::user()->referral_code }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Mobile Number
                    <span class="ms-1" data-bs-toggle="tooltip" title="Phone number must be active">
                        <i class="ki-outline ki-information fs-7"></i>
                    </span></label>
                <div class="col-lg-8 d-flex align-items-center">
                    <span class="fw-bold fs-6 text-gray-800 me-2">{{ Auth::user()->mobile_number }}</span>
                    <span class="badge badge-success">Verified</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Team</label>
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ Auth::user()->groupName }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

