<?php
namespace App\Services;

use App\Models\Room;
use App\Models\ClassGroup;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ScheduleExportService
{
    public function export(): string
    {
        $rooms = Room::select('id', 'location', 'capacity')->get();

        $classes = ClassGroup::with([
            'subjectClass.subject',
            'students:id',
        ])->get()->map(function ($group) {
            $subjectName = $group->subjectClass->subject->name ?? 'Unknown Subject';
            $type = ucfirst($group->subjectClass->class_type ?? 'Unknown');
            return [
                'id'       => $group->id,
                'name'     => "{$subjectName} - {$type} Group {$group->group}",
                'students' => $group->students->pluck('id')->toArray(),
                'lecturer' => $group->lecturer,
                'duration' => $group->subjectClass->duration,
            ];
        });

        $output = [
            'rooms' => Room::all(['id', 'location', 'capacity']),
            'classes' => $classes,
        ];

        $filename = 'input_data.json';

        $outputPath = base_path('scheduler'); // this points to PROJECT_ROOT/scheduler

        if (!File::exists($outputPath)) {
            File::makeDirectory($outputPath, 0755, true);
        }

        file_put_contents(
            $outputPath . '/' . $filename,
            json_encode($output, JSON_PRETTY_PRINT)
        );
        

        return $filename;
    }
}

?>
