<?php

namespace App\Actions\SubjectClass;

use App\Models\Subject;
use App\Models\SubjectClass;
use Illuminate\Support\Facades\DB;
use App\DataTransferObjects\SubjectClassDto;

class CreateSubjectClassAction
{
    public function handle(SubjectClassDto $dto, Subject $subject): SubjectClass
    {

        return DB::transaction(static function () use ($dto, $subject) {

            //Create classes
            $class = SubjectClass::create([
                'subject_id' => $subject->id,
                'class_type'     => $dto->type,
                'duration'  => $dto->duration,
            ]);

            $groupsData = [];

            for ($i = 1; $i <= $dto->group; $i++) {
                $groupsData[] = [
                    'group'    => $i,
                    'capacity' => 0, 
                ];
            }

            $class->classGroups()->createMany($groupsData);

            return $class;
        });
    }

}
