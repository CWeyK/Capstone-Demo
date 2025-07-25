<?php

use Livewire\Volt\Component;
use App\Models\Programme;
use App\Traits\LivewireAlert;

new class extends Component {

    use LivewireAlert;

    public Programme $programme;

}; ?>

<div>
    <livewire:programme.programme-details :programme="$programme" />

    <div class="tab-content">
        <div class="tab-pane fade show active" id="programme_subjects" role="tab-panel" wire:ignore.self>
            <div class="card mb-5 mb-xl-10">
                <div class="card-header">
                    <x-card-title class="d-flex w-100 align-items-center justify-content-between">
                        <h3 class="fw-bold m-0">Programme Subjects</h3>
                        @role("Super-Admin")
                        <x-modal-button name="Assign Subjects" modal="assignSubjectModal" />
                        @endrole
                    </x-card-title>
                </div>

                <div class="card-body p-9">
                    <div class="card-body pt-0">
                        <livewire:tables.subjectstable :programmeId="$programme->id" />
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="programme_students" role="tab-panel" wire:ignore.self>
            <div class="card mb-5 mb-xl-10">
                <div class="card-header">
                    <x-card-title class="d-flex w-100 align-items-center justify-content-between">
                        <h3 class="fw-bold m-0">Programme Students</h3>
                        @role("Super-Admin")
                        <x-modal-button name="Enroll Students" modal="assignStudentModal" />
                        @endrole
                    </x-card-title>
                </div>

                <div class="card-body p-9">
                    <div class="card-body pt-0">
                        <livewire:tables.userstable :programmeId="$programme->id" />
                    </div>
                </div>
            </div>
        </div>
    
    </div>

    @role("Super-Admin")
    <livewire:programme.programme-subject-modal :programme="$programme" />
    <livewire:programme.programme-student-modal :programme="$programme" />
    @endrole
</div>
