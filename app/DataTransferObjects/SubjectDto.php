<?php

namespace App\DataTransferObjects;

// use App\Traits\ToArray;

readonly class SubjectDto
{
    // use ToArray;

    public function __construct(
        public string $name,
    ) {}

    public static function fromAppRequest(array $validatedData): SubjectDto
    {
        return new self(
            name: $validatedData['name'],
        );
    }
}
