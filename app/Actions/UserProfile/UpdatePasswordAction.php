<?php

namespace App\Actions\UserProfile;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordAction
{
    public function handle(User $user,  $validatedData): void
    {

        $user->password = Hash::make($validatedData['password']);
        $user->save();
        
    }
}
