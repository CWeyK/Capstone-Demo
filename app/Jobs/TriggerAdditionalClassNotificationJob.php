<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\ClassGroup;
use App\Models\ClassReplacement;
use Illuminate\Queue\SerializesModels;
use App\Notifications\AdditionalClassNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TriggerAdditionalClassNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public ClassGroup $classGroup;

    public ClassReplacement $replacement;

    /**
     * Create a new job instance.
     */
    public function __construct(ClassGroup $classGroup, ClassReplacement $replacement)
    {
        $this->classGroup = $classGroup;
        $this->replacement = $replacement;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $students = $this->classGroup->students;
        foreach ($students as $student) {
            $student->notify(new AdditionalClassNotification($this->classGroup, $this->replacement));
        }
                // User::find(1)->notify(new AdditionalClassNotification($this->classGroup, $this->replacement));

    }
}
