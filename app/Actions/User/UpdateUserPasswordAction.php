<?php

namespace App\Actions\User;

use Illuminate\Support\Facades\Hash;

class UpdateUserPasswordAction
{
    public function handle($validatedData, $user)
    {
        $user->update([
            'password' => Hash::make($validatedData['password'])
        ]);
    }
}
