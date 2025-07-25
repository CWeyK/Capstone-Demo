<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Http;
use App\Traits\LivewireAlert;
use App\Models\enrollmentToggle;;
use App\Services\ScheduleExportService;
use App\Services\ScheduleImportService;
use App\Services\ScheduleVerifyService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

new class extends Component {

    use LivewireAlert;

    public enrollmentToggle $enrollmentToggle;

    public function mount()
    {
        $this->enrollmentToggle = enrollmentToggle::firstOrCreate([], ['enrollment' => 'Pre-Enrollment']);
    }

    public function enrollment(){
        $this->enrollmentToggle->update(['enrollment' => 'Enrollment']);
        $this->enrollmentToggle->refresh();
        $this->alertSuccess('Enrollment has started. Students can now enroll in subjects.');
    }

    public function scheduling(){
        $this->enrollmentToggle->update(['enrollment' => 'Scheduling']);
        $this->enrollmentToggle->refresh();
        $this->export();
        $this->alertSuccess('Enrollment has ended. You can now generate the schedule.');
    }

    public function semester(){
        $this->enrollmentToggle->update(['enrollment' => 'Semester in Progress']);
        $this->enrollmentToggle->refresh();
        $this->alertSuccess('Semester has started.');
    }

    public function preenrollment(){
        $this->enrollmentToggle->update(['enrollment' => 'Pre-Enrollment']);
        //Clear all enrollments
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear pivot table first
        DB::table('class_group_user')->truncate();       // Student enrollments
        DB::table('subject_lecturers')->truncate();      // Subject-lecturer pivot
        DB::table('class_groups')->truncate();           // Class group entries
        DB::table('subject_classes')->truncate();        // Subject class types

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        
        $this->enrollmentToggle->refresh();
        $this->alertSuccess('Pre-Enrollment has been reset. All previous enrollments cleared.');
    }

    public function export() {
        $filename = app(ScheduleExportService::class)->export();
    }
    
    public function import() {
        $result = app(ScheduleImportService::class)->import();
    }

    public function importAI() {
        $result = app(ScheduleImportService::class)->import('scheduler/rl_output_schedule.json');
    }

    public function generate()
    {
        app(ScheduleExportService::class)->export();

        try {
            $output = [];
            $returnCode = 0;

            $pythonPath = 'C:\\Users\\Wey\\anaconda3\\envs\\scheduler\\python.exe';
            $scriptPath = base_path('scheduler/generate_schedule.py');

            $command = "\"$pythonPath\" \"$scriptPath\" 2>&1";

            exec($command, $output, $returnCode);

            if ($returnCode !== 0) {
                $this->alertError("Schedule generation failed:\n" . implode("\n", $output));
            } else {
                $this->alertSuccess('Schedule generated successfully.');
            }

            // Import the generated schedule
            $this->import();

        } catch (\Exception $e) {
            $this->alertError('Error: ' . $e->getMessage());
        }
    }

    public function generateAI()
    {
        app(ScheduleExportService::class)->export();

        try {
            $output = [];
            $returnCode = 0;

            $pythonPath = 'C:\\Users\\Wey\\anaconda3\\envs\\scheduler\\python.exe';
            $scriptPath = base_path('scheduler/evaluate_agent.py');

            $command = "\"$pythonPath\" \"$scriptPath\" 2>&1";

            exec($command, $output, $returnCode);

            if ($returnCode !== 0) {
                $this->alertError("Schedule generation failed:\n" . implode("\n", $output));
            } else {
                $this->alertSuccess('Schedule generated successfully.');
            }

            // Import the generated schedule
            $this->importAI();

        } catch (\Exception $e) {
            $this->alertError('Error: ' . $e->getMessage());
        }
    }

    public function verify($item)
    {
        switch ($item) {
            case 'student':
                $conflicts = app(ScheduleVerifyService::class)->verifyStudentConflict();
                if (empty($conflicts)) {
                    $this->alertSuccess("No schedule conflicts found.");
                } else {
                    $this->alertError(count($conflicts) . " conflicts found. Check logs for details.");
                }
                break;
            case 'lecturer':
                $conflicts = app(ScheduleVerifyService::class)->verifyLecturerConflict();
                if (empty($conflicts)) {
                    $this->alertSuccess("No schedule conflicts found.");
                } else {
                    $this->alertError(count($conflicts) . " conflicts found. Check logs for details.");
                }
                break;
            case 'room':
                $conflicts = app(ScheduleVerifyService::class)->verifyRoomConflict();
                if (empty($conflicts)) {
                    $this->alertSuccess("No schedule conflicts found.");
                } else {
                    $this->alertError(count($conflicts) . " conflicts found. Check logs for details.");
                }
                break;
            case 'capacity':
                $conflicts = app(ScheduleVerifyService::class)->verifyRoomCapacity();
                if (empty($conflicts)) {
                    $this->alertSuccess("No room capacity issues found.");
                } else {
                    $this->alertError(count($conflicts) . " rooms exceed capacity. Check logs for details.");
                }
                break;
            case 'long':
                $gaps = app(ScheduleVerifyService::class)->countStudentLongGaps();
                if (empty($gaps)) {
                    $this->alertSuccess("No long gaps found.");
                } else {
                    $this->alertError(count($gaps) . " long gaps found. Check logs for details.");
                }
                break;
            case 'early':
                $earlyClasses = app(ScheduleVerifyService::class)->countEarlyClasses();
                if (empty($earlyClasses)) {
                    $this->alertSuccess("No early classes found.");
                } else {
                    $this->alertError($earlyClasses . " early classes found. Check logs for details.");
                }
                break;
            case 'lecturerLong':
                $lecturerClasses = app(ScheduleVerifyService::class)->countLecturerBackToBack();
                if (empty($lecturerClasses)) {
                    $this->alertSuccess("No lecturer long classes found.");
                } else {
                    $this->alertError($lecturerClasses . " lecturer long classes found. Check logs for details.");
                }
                break;
            default:
                $this->alertError('Invalid verification type.');
        }
        
        
    }

}; ?>

<div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-center gap-4">
                <!-- Card 1 -->
                <div class="card text-center" style="min-width: 200px;">
                    <div class="card-body">
                        <h5 class="card-title">Pre Enrollment</h5>
                        @if($enrollmentToggle->enrollment === 'Pre-Enrollment')
                        <span class="badge badge-light-warning mt-2">
                            Active
                        </span>
                        @else
                        <span class="badge badge-light-success mt-2">
                            Completed
                        </span>
                        @endif
                        <ul class="text-start mt-3">
                            <li>Configure rooms</li>
                            <li>Configure programmes</li>
                            <li>Configure subjects</li>
                            <li>Configure users</li>
                            <li>Set enrollment limits</li>
                        </ul>
                        <button type="button" class="btn btn-sm btn-light-primary" wire:click="enrollment()">
                            Begin Enrollment
                        </button>
                    </div>
                </div>
                <i class="bi bi-arrow-right fs-1"></i>

                <!-- Card 2 -->
                <div class="card text-center" style="min-width: 200px;">
                    <div class="card-body">
                        <h5 class="card-title">Enrollment</h5>
                        @if($enrollmentToggle->enrollment === 'Enrollment')
                        <span class="badge badge-light-warning mt-2">
                            Active
                        </span>
                        @elseif($enrollmentToggle->enrollment === 'Pre-Enrollment')
                        <span class="badge badge-light-primary mt-2">
                            Inactive
                        </span>
                        @else
                        <span class="badge badge-light-success mt-2">
                            Completed
                        </span>
                        @endif
                        <ul class="text-start mt-3">
                            <li>Student Enrollment</li>
                        </ul>

                        <button type="button" class="btn btn-sm btn-light-primary" wire:click="scheduling()">
                            End Enrollment
                        </button>
                    </div>
                </div>
                <i class="bi bi-arrow-right fs-1"></i>

                <!-- Card 3 -->
                <div class="card text-center" style="min-width: 200px;">
                    <div class="card-body">
                        <h5 class="card-title">Scheduling</h5>
                        @if($enrollmentToggle->enrollment === 'Scheduling')
                        <span class="badge badge-light-warning mt-2">
                            Active
                        </span>
                        @elseif($enrollmentToggle->enrollment === 'Semester in Progress')
                        <span class="badge badge-light-success mt-2">
                            Completed
                        </span>
                        @else
                        <span class="badge badge-light-primary mt-2">
                            Inactive
                        </span>
                        @endif
                        <ul class="text-start mt-3">
                            <li>Export enrollment data</li>
                            <li>Generate schedule</li>
                            <li>Import schedule</li>
                            <li>Verify schedule</li>
                        </ul>
                        <button type="button" class="btn btn-sm btn-light-primary" wire:click="semester()">
                            Begin Semester
                        </button>
                    </div>
                </div>
                <i class="bi bi-arrow-right fs-1"></i>

                <!-- Card 4 -->
                <div class="card text-center" style="min-width: 200px;">
                    <div class="card-body">
                        <h5 class="card-title">Semester in Progress</h5>
                        @if($enrollmentToggle->enrollment === 'Semester in Progress')
                        <span class="badge badge-light-warning mt-2">
                            Active
                        </span>
                        @else
                        <span class="badge badge-light-primary mt-2">
                            Inactive
                        </span>
                        @endif
                        <ul class="text-start mt-3">
                            <li>Class commence</li>
                            <li>Cancel class</li></li>
                            <li>Schedule additional class</li>
                        </ul>
                        <button type="button" class="btn btn-sm btn-light-primary mt-5" wire:click="preenrollment()">
                            End Semester
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header">
                <x-card-title class="d-flex w-100 align-items-center justify-content-between">
                    <h3 class="fw-bold m-0">Schedule Verification</h3>
                </x-card-title>
        </div>
        <div class="card-body">
            <div class="fv-row mb-6">
                <x-label name='Schedule Generation: ' class="fw-bold mb-2" />
                <button type="button" class="btn btn-sm btn-light-primary ms-3" wire:click="generate()">
                    Basic Generation
                </button>
                <button type="button" class="btn btn-sm btn-light-primary" wire:click="generateAI()">
                    AI Generation
                </button>
            </div>
            <x-label name='Hard Constraints Validation ' class="fw-bold mb-2" />
            <div class="fv-row mb-6">
                <x-label name='Verify Student Timeslot Conflict: ' class="fw mb-2 fs-7" />
                <button type="button" class="btn btn-sm btn-light-primary ms-3" wire:click="verify('student')">
                    Verify
                </button>
            </div>
            <div class="fv-row mb-6">
                <x-label name='Verify Lecturer Timeslot Conflict: ' class="fw mb-2 fs-7" />
                <button type="button" class="btn btn-sm btn-light-primary ms-3" wire:click="verify('lecturer')">
                    Verify
                </button>
            </div>
            <div class="fv-row mb-6">
                <x-label name='Verify Room Timeslot Conflict: ' class="fw mb-2 fs-7" />
                <button type="button" class="btn btn-sm btn-light-primary ms-3" wire:click="verify('room')">
                    Verify
                </button>
            </div>
            <div class="fv-row mb-6">
                <x-label name='Verify Room Capacity: ' class="fw mb-2 fs-7" />
                <button type="button" class="btn btn-sm btn-light-primary ms-3" wire:click="verify('capacity')">
                    Verify
                </button>
            </div>

            <x-label name='Soft Constraints Validation ' class="fw-bold mb-2" />
            <div class="fv-row mb-6">
                <x-label name='Count Long Gaps: ' class="fw mb-2 fs-7" />
                <button type="button" class="btn btn-sm btn-light-primary ms-3" wire:click="verify('long')">
                    Verify
                </button>
            </div>
            <div class="fv-row mb-6">
                <x-label name='Count Early Classes(8 am): ' class="fw mb-2 fs-7" />
                <button type="button" class="btn btn-sm btn-light-primary ms-3" wire:click="verify('early')">
                    Verify
                </button>
            </div>
        </div>
    </div>

</div>
