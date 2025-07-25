<?php

use Livewire\Volt\Component;
use App\Traits\LivewireAlert;
use App\Models\Subject;
use App\Livewire\Forms\EnrollmentForm;

new class extends Component {

    use LivewireAlert;

    public $subjects;
    public EnrollmentForm $form;

    public function mount()
    {
        
    }


}; ?>

<div>
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <x-card-title>
                <h3 class="fw-bold m-0">Subject Enrollment</h3>
            </x-card-title>
        </div>
        <div class="card-body p-9">
            <a wire:navigate href="{{ route('admin.enrollments.show') }}" class="btn btn-primary">Proceed to Enrollment</a>
            <livewire:tables.enrollmentstable :userId="auth()->id()"/>
        </div>
    </div>
</div>
