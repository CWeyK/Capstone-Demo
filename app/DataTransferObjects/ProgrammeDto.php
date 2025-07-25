<?php

namespace App\DataTransferObjects;

// use App\Traits\ToArray;

readonly class ProgrammeDto
{
    // use ToArray;

    public function __construct(
        public string $name,
    ) {}

    public static function fromAppRequest(array $validatedData): ProgrammeDto
    {
        return new self(
            name: $validatedData['name'],
        );
    }
}
