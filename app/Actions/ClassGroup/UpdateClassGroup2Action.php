<?php

namespace App\Actions\ClassGroup;

use Carbon\Carbon;
use App\Models\Room;
use RuntimeException;
use App\Models\ClassGroup;

class UpdateClassGroup2Action
{
    public function handle($validatedData, ClassGroup $group)
    {
        //Check room size
        $room = Room::find($validatedData['location']);
        if ($room->capacity < $group->students()->count()) {
            throw new RuntimeException("Room capacity exceeded for the selected room.");
        }

        //Check if time conflict
        $day = $validatedData['day']; // e.g., "Tue"
        $hour = (int) $validatedData['time']; // e.g., 14

        // Convert to Carbon time
        $startTime = Carbon::createFromTime($hour, 0);
        $duration = $group->subjectClass->duration ?? 2; // Default 2 hours
        $endTime = $startTime->copy()->addHours($duration);

        $proposedTimeString = $day . '_' . $startTime->format('H:i');

        // Check for room conflicts (excluding current class group)
        $conflictingGroups = ClassGroup::where('id', '!=', $group->id)
            ->where('room_id', $validatedData['location'])
            ->get()
            ->filter(function ($otherGroup) use ($day, $startTime, $endTime) {
                if (!$otherGroup->time || !$otherGroup->subjectClass) return false;

                [$otherDay, $otherStartRaw] = explode('_', $otherGroup->time);
                if ($otherDay !== $day) return false;

                $otherStart = Carbon::createFromFormat('H:i', $otherStartRaw);
                $otherEnd = $otherStart->copy()->addHours($otherGroup->subjectClass->duration ?? 2);

                return $startTime < $otherEnd && $endTime > $otherStart;
            });

       

        if ($conflictingGroups->isNotEmpty()) {
            throw new RuntimeException("Room conflict detected for {$day} at {$startTime->format('H:i')}.");
        }

        $proposedStart = $startTime->format('H:i');
        $proposedEnd = $endTime->format('H:i');
        $group->update([
            'room_id' => $validatedData['location'],
            'time' => $validatedData['day'] . '_' . $validatedData['time'] . ':00',
        ]);
    }
}
