<?php

use Livewire\Volt\Component;
use App\Models\Subject;
use Livewire\Attributes\On;
use Carbon\Carbon;
use App\Models\ClassGroup;
use App\Livewire\Forms\RescheduleClassForm;
use App\Traits\LivewireAlert;
use App\Models\ClassReplacement;

new class extends Component {
    use LivewireAlert;

    public Subject $subject;

    public $groupedByDay;
    public $daysOfWeek;
    public $dayLabels;
    public Carbon $currentWeekStart;
    public $cancelledGroupIdsForWeek = [];

    public RescheduleClassForm $form;

    #[On('subjectUpdated')]
    public function refreshDetails()
    {
        $this->subject->refresh();
    }
   
    public function mount()
    {
        $this->daysOfWeek = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $this->dayLabels = [
            'Mon' => 'Monday',
            'Tue' => 'Tuesday',
            'Wed' => 'Wednesday',
            'Thu' => 'Thursday',
            'Fri' => 'Friday',
            'Sat' => 'Saturday',
            'Sun' => 'Sunday',
        ];

        // Default to this week's Monday
        $this->currentWeekStart = now()->startOfWeek(Carbon::MONDAY);

        $this->groupScheduleByDay();
    }

    public function groupScheduleByDay(): void
    {
        $weekStart = $this->currentWeekStart->copy();
        $weekEnd = $weekStart->copy()->addDays(6);

        // Cancelled group IDs for this week
        $this->cancelledGroupIdsForWeek = ClassReplacement::where('status', 'cancelled')
            ->whereBetween('date', [$weekStart->format('Y-m-d'), $weekEnd->format('Y-m-d')])
            ->pluck('class_group_id')
            ->toArray();

        // Base subject group classes (original schedule)
        $groups = $this->subject->classes->flatMap->classGroups
            ->filter(fn ($group) => $group->time)
            ->sortBy(fn ($group) => Carbon::createFromFormat('H:i', explode('_', $group->time)[1]));

        $this->groupedByDay = [];

        // Add original scheduled classes
        foreach ($groups as $group) {
            [$day, $time] = explode('_', $group->time);
            $this->groupedByDay[$day][] = [
                'group' => $group,
                'isReplacement' => false,
                'startTime' => Carbon::createFromFormat('H:i', $time),
            ];
        }

        // Add additional replacement classes
        $replacements = ClassReplacement::with(['classGroup.subjectClass', 'classGroup.room', 'classGroup.lecturerUser'])
            ->where('status', 'scheduled')
            ->whereBetween('date', [$weekStart->format('Y-m-d'), $weekEnd->format('Y-m-d')])
            ->whereIn('class_group_id', $this->subject->classes->flatMap->classGroups->pluck('id'))
            ->get();

        foreach ($replacements as $replacement) {
            $day = Carbon::parse($replacement->date)->format('D'); // e.g., Mon
            $time = Carbon::createFromFormat('H:i', $replacement->time);

            $this->groupedByDay[$day][] = [
                'replacement' => $replacement,
                'group' => $replacement->classGroup,
                'isReplacement' => true,
                'startTime' => $time,
            ];
        }

        // Sort each day's classes by start time
        foreach ($this->groupedByDay as &$classes) {
            usort($classes, fn ($a, $b) => $a['startTime']->timestamp <=> $b['startTime']->timestamp);
        }
    }


    public function goToNextWeek(): void
    {
        $this->currentWeekStart->addWeek();
        $this->groupScheduleByDay();
    }

    public function goToPreviousWeek(): void
    {
        $this->currentWeekStart->subWeek();
        $this->groupScheduleByDay();
    }

    public function cancelClass($groupId)
    {

        try {
            $classGroup = ClassGroup::findOrFail($groupId);
            $dayAbbr = explode('_', $classGroup->time)[0];  // e.g. 'Tue'
            $daysOfWeek = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            $dayIndex = array_search($dayAbbr, $daysOfWeek); // Thu = 3

            $actualDate = $this->currentWeekStart->copy()->addDays($dayIndex)->format('Y-m-d');
            $this->form->cancelClass(
                $groupId, $actualDate
            );

            $this->alertSuccess(
                __('Class has been cancelled successfully.'),
                [
                    'timer' => 3000,
                    'onConfirmed' => 'close-modal',
                    'onProgressFinished' => 'close-modal',
                    'onDismissed' => 'close-modal'
                ]
            );

            $this->groupScheduleByDay();

        } catch (Throwable $e) {

            $this->alertError($e->getMessage());
        }
    }

}; ?>

<div class="tab-pane fade" id="subject_schedule" role="tab-panel" wire:ignore.self>
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <x-card-title>
                <h3 class="fw-bold m-0">Schedule Details</h3>
            </x-card-title>
        </div>

        <div class="card-body p-9">
            <div class="d-flex justify-content-between mb-4">
                <button wire:click="goToPreviousWeek" class="btn btn-light btn-sm">
                    &larr; Previous Week
                </button>
                <div class="fw-bold">
                    Week of {{ $currentWeekStart->format('j M Y') }}
                </div>
                <button wire:click="goToNextWeek" class="btn btn-light btn-sm">
                    Next Week &rarr;
                </button>
            </div>

            <div style="overflow-x: auto; max-width: 100%;">
                <table class="table table-bordered align-top w-100" style="min-width: 800px;">
                    @foreach ($daysOfWeek as $dayAbbr)
                    <tr>
                        <td class="bg-primary text-white fw-bold" style="width: 180px;">
                            {{ $dayLabels[$dayAbbr] }}<br>
                            <small>{{ $currentWeekStart->copy()->addDays(array_search($dayAbbr, $daysOfWeek))->format('j
                                M Y') }}</small>
                        </td>

                        <td class="p-3">
                            <div style="white-space: nowrap;">
                                @forelse ($groupedByDay[$dayAbbr] ?? [] as $item)
                                @php
                                $isReplacement = $item['isReplacement'];
                                $group = $item['group'];
                                $start = $item['startTime'];
                                $duration = $group->subjectClass->duration ?? 2;
                                $end = $start->copy()->addHours($duration);
                                $isCancelled = !$isReplacement && in_array($group->id, $cancelledGroupIdsForWeek);
                                $room = $isReplacement ? $item['replacement']->room : $group->room;
                                $lecturer = $group->lecturerUser;
                                @endphp

                                <div class="d-inline-block border rounded p-3 me-3 align-top"
                                    style="width: 300px; {{ $isCancelled ? 'background-color: #f8d7da;' : ($isReplacement ? 'background-color: #fff3cd;' : '') }}">
                                    <div>
                                        <strong>
                                            {{ $group->subjectClass->subject->code }}
                                            ({{ strtoupper(substr($group->subjectClass->class_type, 0, 1)) }})
                                            {{ $start->format('H:i') }} - {{ $end->format('H:i') }}
                                            @if ($isCancelled)
                                            <span class="badge badge-danger ms-2">Cancelled</span>
                                            @elseif ($isReplacement)
                                            <span class="badge badge-warning ms-2">Additional</span>
                                            @endif
                                        </strong>
                                    </div>
                                    <div>{{ $group->subjectClass->subject->name }}</div>
                                    <div><strong>Grouping:</strong> {{ $group->group }}</div>
                                    <div><strong>Venue:</strong> {{ $room->location ?? 'N/A' }}</div>
                                    <div><strong>Lecturer:</strong> {{ $lecturer->name ?? 'TBD' }}</div>

                                    @unless($isReplacement)
                                    @hasanyrole('Super-Admin|Lecturer')
                                    <button wire:click="cancelClass({{ $group->id }})"
                                        class="btn btn-danger btn-sm mt-2">
                                        <i class="fs-4 ki-outline ki-calendar-remove"></i> Cancel class
                                    </button>
                                    @endhasanyrole
                                    @endunless
                                </div>
                                @empty
                                <span class="text-muted">No classes</span>
                                @endforelse
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
