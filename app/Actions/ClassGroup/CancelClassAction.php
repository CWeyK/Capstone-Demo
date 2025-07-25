<?php

namespace App\Actions\ClassGroup;

use App\Models\ClassGroup;
use App\Jobs\TriggerCancelClassNotificationJob;


class CancelClassAction
{
    public function handle($groupId, $date)
    {
        $classGroup = ClassGroup::find($groupId);
        // Create new entry in replacement
        $replacement = $classGroup->replacement()->create([
            'date' => $date,
            'class_group_id' => $classGroup->id,
            'status' => 'cancelled',
        ]);

        TriggerCancelClassNotificationJob::dispatch($classGroup, $replacement);
    }
}
