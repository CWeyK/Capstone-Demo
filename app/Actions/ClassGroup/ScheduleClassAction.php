<?php

namespace App\Actions\ClassGroup;

use Carbon\Carbon;
use App\Models\Room;
use RuntimeException;
use App\Models\ClassGroup;
use App\Jobs\TriggerAdditionalClassNotificationJob;


class ScheduleClassAction
{
    public function handle($validatedData)
    {
        $classGroup = ClassGroup::find($validatedData['class']);

        $room = Room::find($validatedData['location']);

        // Parse the datetime from ISO format
        $dateTime = Carbon::parse($validatedData['date']);
        $date = $dateTime->format('Y-m-d');
        $time = $dateTime->format('H:i');
        $day = $dateTime->format('D'); // E.g. Mon, Tue...

        // === 1. Check Room Capacity ===
        // if ($room->capacity < $classGroup->students()->count()) {
        //     throw new RuntimeException("Room capacity exceeded for the selected room.");
        // }

        // === 2. Check Room Conflict in Replacements ===
        $conflictInReplacements = $room->replacements()
            ->where('date', $date)
            ->where('time', $time)
            ->exists();

        // === 3. Check Room Conflict in Regular ClassGroups ===
        $formattedTime = $day . '_' . $time;
        $conflictInRegularClasses = $room->classGroups()
            ->where('time', $formattedTime)
            ->exists();

        if ($conflictInReplacements || $conflictInRegularClasses) {
            throw new RuntimeException("The selected room is already booked at that date and time.");
        }
        
        // Create new entry in replacement
        $replacement = $classGroup->replacement()->create([
            'date' => Carbon::parse($validatedData['date'])->format('Y-m-d'),
            'time' => Carbon::parse($validatedData['date'])->format('H:i'),
            'class_group_id' => $classGroup->id,
            'status' => 'scheduled',
            'room_id' => $validatedData['location'],
        ]);

        TriggerAdditionalClassNotificationJob::dispatch($classGroup, $replacement);
    }
}
