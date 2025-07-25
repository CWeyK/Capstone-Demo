<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\User;
use App\Models\ClassGroup;
use Illuminate\Support\Facades\Log;

class ScheduleVerifyService
{
    public function verifyStudentConflict()
    {
        $conflicts = [];

        $students = User::where('id', 3)->get();
        $students = User::role('Student')->with('studentGroups')->get();


        foreach ($students as $student) {
            $schedules = [];

            foreach ($student->studentGroups as $group) {
                if (!$group->time || !$group->subjectClass) continue;

                [$day, $startTimeStr] = explode('_', $group->time);
                $duration = $group->subjectClass->duration ?? 2;

                // Parse start & end times
                $start = Carbon::createFromFormat('H:i', $startTimeStr);
                $end = (clone $start)->addHours($duration);

                $schedules[] = [
                    'group_id' => $group->id,
                    'day' => $day,
                    'start' => $start,
                    'end' => $end,
                ];
            }

            // Compare all pairs for overlaps
            for ($i = 0; $i < count($schedules); $i++) {
                for ($j = $i + 1; $j < count($schedules); $j++) {
                    $a = $schedules[$i];
                    $b = $schedules[$j];

                    if ($a['day'] === $b['day']) {
                        if ($a['start']->lt($b['end']) && $b['start']->lt($a['end'])) {
                            // Overlapping time
                            $conflicts[] = [
                                'student_id' => $student->id,
                                'student_name' => $student->name,
                                'day' => $a['day'],
                                'group_ids' => [$a['group_id'], $b['group_id']],
                                'times' => [
                                    $a['start']->format('H:i') . '–' . $a['end']->format('H:i'),
                                    $b['start']->format('H:i') . '–' . $b['end']->format('H:i'),
                                ],
                            ];
                        }
                    }
                }
            }
        }

        // Log the conflicts for debugging
        Log::error('Schedule conflicts found:', $conflicts);

        // Or return $conflicts if needed
        return $conflicts;
    }

    public function verifyLecturerConflict()
    {
        $conflicts = [];

        $lecturers = User::role('Lecturer')->with('classGroups.subjectClass')->get();

        foreach ($lecturers as $lecturer) {
            $schedules = [];

            foreach ($lecturer->classGroups as $group) {
                if (!$group->time || !$group->subjectClass) continue;

                [$day, $startTimeStr] = explode('_', $group->time);
                $duration = $group->subjectClass->duration ?? 2;

                $start = Carbon::createFromFormat('H:i', $startTimeStr);
                $end = (clone $start)->addHours($duration);

                $schedules[] = [
                    'group_id' => $group->id,
                    'day' => $day,
                    'start' => $start,
                    'end' => $end,
                ];
            }

            // Check for conflicts
            for ($i = 0; $i < count($schedules); $i++) {
                for ($j = $i + 1; $j < count($schedules); $j++) {
                    $a = $schedules[$i];
                    $b = $schedules[$j];

                    if ($a['day'] === $b['day']) {
                        if ($a['start']->lt($b['end']) && $b['start']->lt($a['end'])) {
                            $conflicts[] = [
                                'lecturer_id' => $lecturer->id,
                                'lecturer_name' => $lecturer->name,
                                'day' => $a['day'],
                                'group_ids' => [$a['group_id'], $b['group_id']],
                                'times' => [
                                    $a['start']->format('H:i') . '–' . $a['end']->format('H:i'),
                                    $b['start']->format('H:i') . '–' . $b['end']->format('H:i'),
                                ],
                            ];
                        }
                    }
                }
            }
        }

        Log::error('Lecturer conflicts found:', $conflicts);
        return $conflicts;
    }

    public function verifyRoomConflict()
    {
        $conflicts = [];

        $groups = ClassGroup::with('subjectClass', 'room')->whereNotNull('time')->get();

        // Group by room
        $byRoom = $groups->groupBy('room_id');

        foreach ($byRoom as $roomId => $roomGroups) {
            $schedules = [];

            foreach ($roomGroups as $group) {
                if (!$group->time || !$group->subjectClass) continue;

                [$day, $startTimeStr] = explode('_', $group->time);
                $duration = $group->subjectClass->duration ?? 2;

                $start = Carbon::createFromFormat('H:i', $startTimeStr);
                $end = (clone $start)->addHours($duration);

                $schedules[] = [
                    'group_id' => $group->id,
                    'day' => $day,
                    'start' => $start,
                    'end' => $end,
                    'room_name' => $group->room->name ?? 'Unknown',
                ];
            }

            // Check conflicts within same room
            for ($i = 0; $i < count($schedules); $i++) {
                for ($j = $i + 1; $j < count($schedules); $j++) {
                    $a = $schedules[$i];
                    $b = $schedules[$j];

                    if ($a['day'] === $b['day']) {
                        if ($a['start']->lt($b['end']) && $b['start']->lt($a['end'])) {
                            $conflicts[] = [
                                'room_id' => $roomId,
                                'room_name' => $a['room_name'],
                                'day' => $a['day'],
                                'group_ids' => [$a['group_id'], $b['group_id']],
                                'times' => [
                                    $a['start']->format('H:i') . '–' . $a['end']->format('H:i'),
                                    $b['start']->format('H:i') . '–' . $b['end']->format('H:i'),
                                ],
                            ];
                        }
                    }
                }
            }
        }

        Log::error('Room conflicts found:', $conflicts);
        return $conflicts;
    }

    public function verifyRoomCapacity()
    {
        $violations = [];

        $groups = ClassGroup::with(['room', 'students'])->get();

        foreach ($groups as $group) {
            $room = $group->room;
            $studentCount = $group->students->count();

            if ($room && $room->capacity < $studentCount) {
                $violations[] = [
                    'subject' => $group->subjectClass->subject->name ?? 'Unknown',
                    'group_id' => $group->id,
                    'room_id' => $room->id,
                    'room_name' => $room->location,
                    'room_capacity' => $room->capacity,
                    'students_enrolled' => $studentCount,
                ];
            }
        }

        Log::warning('Room capacity violations detected:', $violations);
        return $violations;
    }

    public function countStudentLongGaps()
    {
        $longGaps = [];

        $students = User::where('id', 3)->get();
        $students = User::role('Student')->with('studentGroups.subjectClass')->get();

        foreach ($students as $student) {
            $schedulesByDay = [];

            foreach ($student->studentGroups as $group) {
                if (!$group->time || !$group->subjectClass) continue;

                [$day, $startTimeStr] = explode('_', $group->time);
                $duration = $group->subjectClass->duration ?? 2;

                $start = Carbon::createFromFormat('H:i', $startTimeStr);
                $end = (clone $start)->addHours($duration);

                $schedulesByDay[$day][] = [
                    'start' => $start,
                    'end' => $end,
                ];
            }

            $studentGaps = [];

            foreach ($schedulesByDay as $day => $daySchedules) {
                // Sort classes by start time
                usort($daySchedules, fn($a, $b) => $a['start']->lt($b['start']) ? -1 : 1);

                for ($i = 0; $i < count($daySchedules) - 1; $i++) {
                    $currentEnd = $daySchedules[$i]['end'];
                    $nextStart = $daySchedules[$i + 1]['start'];

                    $gapInMinutes = $currentEnd->diffInMinutes($nextStart);
                    $gapInHours = $gapInMinutes / 60;

                    if ($gapInHours > 2) {
                        $studentGaps[] = [
                            'day' => $day,
                            'gap_start' => $currentEnd->format('H:i'),
                            'gap_end' => $nextStart->format('H:i'),
                            'gap_hours' => round($gapInHours, 2),
                        ];
                    }
                }
            }

            if (!empty($studentGaps)) {
                $longGaps[] = [
                    'student_id' => $student->id,
                    'student_name' => $student->name,
                    'gaps' => $studentGaps,
                ];
            }
        }

        // Log or return
        Log::info('Students with long schedule gaps:', $longGaps);
        return $longGaps;
    }

    public function countEarlyClasses()
    {
        $earlyClasses = ClassGroup::query()
            ->whereNotNull('time')
            ->where(function ($query) {
                $query->whereRaw("SUBSTRING_INDEX(time, '_', -1) = '08:00'");
            });

        $count = $earlyClasses->count();

        Log::info('Early classes at 08:00:', $earlyClasses->pluck('id')->toArray());
        return $count;
    }

    // public function countLecturerBackToBack()
    // {
    //     $conflictCount = 0;

    //     $lecturers = User::with('classGroups.subjectClass')->get();

    //     foreach ($lecturers as $lecturer) {
    //         $dailySchedules = [];

    //         foreach ($lecturer->classGroups as $group) {
    //             if (!$group->time || !$group->subjectClass) continue;

    //             [$day, $timeStr] = explode('_', $group->time);
    //             $start = intval(explode(':', $timeStr)[0]);
    //             $duration = $group->subjectClass->duration ?? 2;
    //             $end = $start + $duration;

    //             $dailySchedules[$day][] = ['start' => $start, 'end' => $end];
    //         }

    //         foreach ($dailySchedules as $slots) {
    //             // Sort by start time
    //             usort($slots, fn($a, $b) => $a['start'] <=> $b['start']);

    //             for ($i = 0; $i < count($slots) - 1; $i++) {
    //                 $current = $slots[$i];
    //                 $next = $slots[$i + 1];

    //                 if ($current['end'] == $next['start']) {
    //                     $conflictCount++;
    //                 }
    //             }
    //         }
    //     }

    //     Log::info('Lecturer back-to-back class violations (no break): ' . $conflictCount);
    //     return $conflictCount;
    // }

}
