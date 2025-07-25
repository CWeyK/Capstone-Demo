<?php

namespace App\Actions\Programme;

use App\Models\Programme;
use App\Models\User;

class UpdateProgrammeStudentAction
{
    public function handle($validatedData, Programme $programme)
    {
        User::where('id', $validatedData['students'])
            ->update(['programme_id' => $programme->id]);

    }
}
