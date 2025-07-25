<?php

use Livewire\Volt\Component;
use App\Models\Subject;
use App\Models\enrollmentToggle;
use Livewire\Attributes\On;

new class extends Component {

    public Subject $subject;

    public enrollmentToggle $enrollmentToggle;

    public function mount()
    {
        $this->enrollmentToggle = enrollmentToggle::first();
    }

    public function editGroup($groupId)
    {
        $this->dispatch('editGroup', $groupId);
    }

    public function deleteClass($classId)
    {
        try {
            $this->form->deleteSubjectClass($classId);

            $this->alertSuccess(
                __('Class has been deleted successfully.'),
                [
                    'timer' => 3000,
                    'onConfirmed' => 'close-modal',
                    'onProgressFinished' => 'close-modal',
                    'onDismissed' => 'close-modal'
                ]
            );

        } catch (Throwable $e) {

            $this->alertError($e->getMessage());
        }
       
    }

    #[On('subjectUpdated')]
    public function refreshDetails()
    {
        $this->subject->refresh();
    }
}; ?>

<div class="tab-pane fade show active" id="subject_classes" role="tab-panel" wire:ignore.self>
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <x-card-title class="d-flex w-100 align-items-center justify-content-between">
                <h3 class="fw-bold m-0">Subject Classes</h3>
                <div>
                    @if($enrollmentToggle->enrollment === 'Pre-Enrollment')
                    @role("Super-Admin")
                    <x-modal-button name="Add Class" modal="createClassModal" />
                    @endrole
                    @endif
                    @if($enrollmentToggle->enrollment === 'Semester in Progress')
                    <x-modal-button name="Schedule Class" modal="scheduleClassModal" icon="ki-calendar"/>
                    @endif
                </div>
            </x-card-title>
        </div>

        <div class="card-body p-9">
            <div class="card-body pt-0">
                @forelse ($subject->classes as $class)
                <div class="mb-5">
                    <h5 class="fw-bold text-primary mb-3">
                        {{ ucfirst($class->class_type) }} Class - {{ $class->duration }} Hour(s)
                        @if($enrollmentToggle->enrollment === 'Pre-Enrollment')
                        @role("Super-Admin")
                        <button class="btn btn-sm btn-danger ms-5" wire:click="deleteClass({{ $class->id }})">
                            <i class="fs-4 ki-outline ki-file-deleted"></i>
                            Delete Class
                        </button>
                        @endrole
                        @endif
                    </h5>



                    @if ($class->classGroups->isNotEmpty())
                    <div class="row">
                        @foreach ($class->classGroups as $group)
                        <div class="col-md-6 col-lg-4">
                            <div class="card border shadow-sm mb-3">
                                <div class="card-body position-relative">
                                    @if($enrollmentToggle->enrollment === 'Pre-Enrollment')
                                    @role("Super-Admin")
                                    <x-modal-button class="btn btn-sm btn-warning position-absolute top-0 end-0 m-2"
                                        name="Edit Class" modal="editGroupModal" icon="ki-pencil"
                                        wire:click="editGroup({{ $group->id }})" />
                                    @endrole
                                    @endif
                                    @if($enrollmentToggle->enrollment === 'Scheduling' || $enrollmentToggle->enrollment
                                    === 'Semester in Progress')
                                    @hasanyrole('Super-Admin')
                                    <x-modal-button class="btn btn-sm btn-primary position-absolute top-0 end-0 m-2"
                                        name="Edit Class" modal="editGroupModal2" icon="ki-pencil"
                                        wire:click="editGroup({{ $group->id }})" />
                                    @endhasanyrole
                                    @endif

                                    <h6 class="card-title mb-2 fw-semibold">
                                        Group: {{ $group->group }}
                                    </h6>
                                    <h6 class="card-title mb-2 fw-semibold">
                                        Lecturer: {{ $group->lecturerUser->name ?? 'Not Assigned' }}
                                    </h6>
                                    <h6 class="card-title mb-2 fw-semibold">
                                        Capacity: {{ $group->capacity }}
                                    </h6>
                                    <h6 class="card-title mb-2 fw-semibold">
                                        Location: {{ $group->room->location ?? 'Not Assigned' }}
                                    </h6>
                                    <h6 class="card-title mb-2 fw-semibold">
                                        @if(isset($group->time))
                                        Time: {{ $group->day }} {{ $group->startTime }} - {{ $group->endTime }}
                                        @else
                                        Time: Not Assigned
                                        @endif
                                    </h6>
                                </div>
                            </div>
                        </div>

                        @endforeach
                    </div>
                    @else
                    <div class="alert alert-warning">No groups found for this class.</div>
                    @endif
                </div>
                @empty
                <div class="alert alert-info">No classes have been created for this subject.</div>
                @endforelse
            </div>
        </div>"

    </div>
</div>
