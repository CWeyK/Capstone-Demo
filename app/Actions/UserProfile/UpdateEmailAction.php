<?php

namespace App\Actions\UserProfile;

use App\Models\User;


class UpdateEmailAction
{
    public function handle(User $user,  $validatedData): void
    {

        $user->email = $validatedData['email'];
        $user->save();
        
    }
}
