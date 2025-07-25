<?php

namespace App\Actions\Programme;

use App\Models\Programme;


class UpdateProgrammeSubjectAction
{
    public function handle($validatedData, Programme $programme)
    {
        $programme->subjects()->syncWithoutDetaching($validatedData['subject'] ?? []);
        return $programme;
    }
}
