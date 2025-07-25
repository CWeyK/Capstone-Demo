<?php

use Livewire\Volt\Component;
use App\Models\Programme;
use Livewire\Attributes\On;
use Carbon\Carbon;

new class extends Component {

    public Programme $programme;

    #[On('programmeRefresh')]
    public function refreshProgramme(){
        $this->programme->refresh();
    }

}; ?>

<div>
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            <div class="d-flex flex-wrap flex-sm-nowrap">
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center mb-2">
                                <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $programme->name
                                    }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap flex-stack">
                        <div class="d-flex flex-column flex-grow-1 pe-8">
                            <div class="d-flex flex-wrap">
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="fs-2 fw-bold">
                                            {{ $programme->subjects->count() }}
                                        </div>
                                    </div>
                                    <div class="fw-semibold fs-6 text-gray-400 text-center">
                                        <div class="d-flex justify-content-center">
                                            <span class="badge badge-light-primary mt-2">
                                                Subjects
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="fs-2 fw-bold">
                                            {{ $programme->students->count() }}
                                        </div>
                                    </div>
                                    <div class="fw-semibold fs-6 text-gray-400 text-center">
                                        <div class="d-flex justify-content-center">
                                            <span class="badge badge-light-primary mt-2">
                                                Students
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="fs-2 fw-bold">
                                            {{ $programme->subjects->flatMap->lecturers->unique('id')->count() }}
                                        </div>
                                    </div>
                                    <div class="fw-semibold fs-6 text-gray-400 text-center">
                                        <div class="d-flex justify-content-center">
                                            <span class="badge badge-light-primary mt-2">
                                                Lecturers
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="fs-2 fw-bold">
                                           {{ $programme->subjects->flatMap->classes->flatMap->classGroups->unique('id')->count() }}
                                        </div>
                                    </div>
                                    <div class="fw-semibold fs-6 text-gray-400 text-center">
                                        <div class="d-flex justify-content-center">
                                            <span class="badge badge-light-primary mt-2">
                                                Classes
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                        href="#programme_subjects" wire:ignore.self>Subjects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                        href="#programme_students" wire:ignore.self>Students</a>
                </li>
            </ul>
        </div>
    </div>
</div>
