<?php

namespace App\DataTransferObjects;

// use App\Traits\ToArray;

readonly class UserDto
{
    // use ToArray;

    public function __construct(
        public string $name,
        public string $email,
        public string $mobile_number,
        public string $role,
    ) {}

    public static function fromAppRequest(array $validatedData): UserDto
    {
        return new self(
            name: $validatedData['name'],
            email: $validatedData['email'],
            mobile_number: $validatedData['mobile_number'],
            role: $validatedData['role'],
        );
    }
}
