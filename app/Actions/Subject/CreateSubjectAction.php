<?php

namespace App\Actions\Subject;

use App\Models\Subject;
use RuntimeException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\DataTransferObjects\SubjectDto;

class CreateSubjectAction
{
    public function handle(SubjectDto $dto): Subject
    {

        return DB::transaction(static function () use ($dto) {

            $subject = Subject::create([
                'name'     => $dto->name,
            ]);

            return $subject;
        });
    }

}
