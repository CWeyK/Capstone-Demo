<?php

namespace App\Actions\Programme;

use App\Models\Programme;
use RuntimeException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\DataTransferObjects\ProgrammeDto;

class CreateProgrammeAction
{
    public function handle(ProgrammeDto $dto): Programme
    {

        return DB::transaction(static function () use ($dto) {

            $programme = Programme::create([
                'name'     => $dto->name,
            ]);

            return $programme;
        });
    }

}
