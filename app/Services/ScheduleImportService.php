<?php

namespace App\Services;

use App\Models\ClassGroup;

class ScheduleImportService
{
    public function import(string $filePath = 'scheduler/output_schedule.json'): array
    {

        // Use base_path() to point to the project root directory
        $fullPath = base_path($filePath);

        if (!file_exists($fullPath)) {
            return ['success' => false, 'message' => "File not found at: $fullPath"];
        }

        $json = file_get_contents($fullPath);
        $schedule = json_decode($json, true);

        if (!is_array($schedule)) {
            return ['success' => false, 'message' => "Invalid JSON format."];
        }

        $updated = 0;
        $skipped = 0;

        //reset the schedule
        ClassGroup::query()->update(['time' => null, 'room_id' => null]);

        foreach ($schedule as $entry) {
            $group = ClassGroup::find($entry['class_id']);

            if (!$group) {
                $skipped++;
                continue;
            }
            $group->update([
                'time' => $entry['time_slot'],
                'room_id' => $entry['room_id'],
            ]);

            $updated++;
        }

        return [
            'success' => true,
            'message' => "Imported successfully.",
            'updated' => $updated,
            'skipped' => $skipped,
        ];
    }
}
