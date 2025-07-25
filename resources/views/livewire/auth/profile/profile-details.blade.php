<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {

    public ?User $user = null;

    public function mount(): void
    {
        if ($this->user === null) {
            $this->user = Auth::user();
        }
    }
}; ?>

<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
    <div class="card-header cursor-pointer">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Profile Details</h3>
        </div>
        @if(Route::is('admin.users.show'))
        <a href="{{ route('admin.users.settings', $user->id) }}" wire:navigate class="btn btn-sm btn-primary align-self-center">Edit Profile</a>
        @else
        <a href="{{ route('admin.account.settings') }}" wire:navigate class="btn btn-sm btn-primary align-self-center">Edit Profile</a>
        @endif
    </div>

    <div class="card-body p-9">
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Full Name</label>
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">{{ $user->name }}</span>
            </div>
        </div>

        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Email</label>
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">{{ $user->email }}</span>
                <span class="badge badge-success">Verified</span>
            </div>
        </div>

        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Contact Phone</label>
            <div class="col-lg-8 d-flex align-items-center">
                <span class="fw-bold fs-6 text-gray-800 me-2">{{ $user->phoneNumber ?? '-' }}</span>
            </div>
        </div>

        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Gender</label>
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">{{ ($user->gender?->label()) ?? '-' }}</span>
            </div>
        </div>

        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Date of Birth</label>
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">{{ $user->dob ?? '-' }}</span>
            </div>
        </div>

        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Country</label>
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">Malaysia</span>
            </div>
        </div>
    </div>
</div>
