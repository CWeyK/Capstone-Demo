<?php

namespace App\DataTransferObjects;

// use App\Traits\ToArray;

readonly class RoomDto
{
    // use ToArray;

    public function __construct(
        public string $location,
        public int $capacity,
    ) {}

    public static function fromAppRequest(array $validatedData): RoomDto
    {
        return new self(
            location: $validatedData['location'],
            capacity: $validatedData['capacity'],
        );
    }
}
