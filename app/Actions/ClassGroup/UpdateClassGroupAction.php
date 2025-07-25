<?php

namespace App\Actions\ClassGroup;

use App\Models\ClassGroup;


class UpdateClassGroupAction
{
    public function handle($validatedData, ClassGroup $group)
    {
        $group->update($validatedData); 
    }
}
