<?php

use Livewire\Volt\Component;
use App\Models\Subject;
use Livewire\Attributes\On;

new class extends Component {

    public Subject $subject;

    #[On('subjectUpdated')]
    public function refreshDetails()
    {
        $this->subject->refresh();
    }
}; ?>

    <div class="tab-pane fade" id="subject_students" role="tab-panel" wire:ignore.self>
            <div class="card mb-5 mb-xl-10">
                <div class="card-header">
                    <x-card-title class="d-flex w-100 align-items-center justify-content-between">
                        <h3 class="fw-bold m-0">Subject Students</h3>
                    </x-card-title>
                </div>

                <div class="card-body p-9">
                    <div class="card-body pt-0">
                        <livewire:tables.subjectstudentstable :subjectId="$subject->id" />
                    </div>
                </div>
            </div>
    </div>

