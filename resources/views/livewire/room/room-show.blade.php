<?php

use Livewire\Volt\Component;
use App\Models\Room;
use App\Traits\LivewireAlert;
use Carbon\Carbon;
use App\Models\ClassReplacement;

new class extends Component {

    use LivewireAlert;

    public Room $room;
    
    public $groupedByDay;
    public $daysOfWeek;
    public $dayLabels;
    public Carbon $currentWeekStart;
    public $cancelledGroupIdsForWeek = [];

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
        $groups = $this->room->classGroups
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
            ->whereIn('class_group_id', $this->room->classGroups->pluck('id'))
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

}; ?>

<div>
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            <div class="d-flex flex-wrap flex-sm-nowrap">
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center mb-2">
                                <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{
                                    $room->location
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
                                            {{ $room->capacity }}
                                        </div>
                                    </div>
                                    <div class="fw-semibold fs-6 text-gray-400 text-center">
                                        <div class="d-flex justify-content-center">
                                            <span class="badge badge-light-primary mt-2">
                                                Capacity
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
                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#subject_schedule"
                        wire:ignore.self>Schedule</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content">
        <div class="tab-pane fade active show" id="subject_schedule" role="tab-panel" wire:ignore.self>
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
                                    <small>{{ $currentWeekStart->copy()->addDays(array_search($dayAbbr,
                                        $daysOfWeek))->format('j
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
                                        $isCancelled = !$isReplacement && in_array($group->id,
                                        $cancelledGroupIdsForWeek);
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

    </div>

</div>
