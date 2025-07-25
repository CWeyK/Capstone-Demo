<?php

namespace App\DataTransferObjects;

// use App\Traits\ToArray;

readonly class SubjectClassDto
{
    // use ToArray;

    public function __construct(
        public string $type,
        public int $group,
        public int $duration = 1
    ) {}

    public static function fromAppRequest(array $validatedData): SubjectClassDto
    {
        return new self(
            type: $validatedData['type'],
            group: $validatedData['group'],
            duration: $validatedData['duration']
        );
    }
}
