<?php

use Livewire\Volt\Component;
use App\Models\Subject;
use App\Livewire\Forms\SubjectClassForm;
use App\Traits\LivewireAlert;
use App\Models\enrollmentToggle;
use Livewire\Attributes\On;

new class extends Component {

    use LivewireAlert;

    public Subject $subject;
    public SubjectClassForm $form;
    public enrollmentToggle $enrollmentToggle;

    public function mount(){
        $this->enrollmentToggle = enrollmentToggle::first();
    }

    #[On('subjectUpdated')]
    public function refreshDetails()
    {
        $this->subject->refresh();
    }

}; ?>

<div>
    <livewire:subject.subject-details :subject="$subject" />

    <div class="tab-content">
        <livewire:subject.subject-show-schedule :subject="$subject"/>
        <livewire:subject.subject-show-classes :subject="$subject"/>
        <livewire:subject.subject-show-lecturers :subject="$subject"/>
        <livewire:subject.subject-show-students :subject="$subject"/>
    </div>

    @if($enrollmentToggle->enrollment === 'Pre-Enrollment')
    <livewire:subject.subject-lecturer-modal :subject="$subject" />
    <livewire:subject.subject-class-modal :subject="$subject" />
    <livewire:subject.subject-group-modal/>
    @endif
    @if($enrollmentToggle->enrollment === 'Scheduling' || $enrollmentToggle->enrollment === 'Semester in Progress')
    <livewire:subject.subject-group-modal2/>
    <livewire:subject.subject-grouping-modal :subject="$subject"/>
    {{-- <livewire:subject.subject-class-modal2 :subject="$subject"/> --}}
    @endif
        <livewire:subject.subject-class-modal2 :subject="$subject"/>
</div>
