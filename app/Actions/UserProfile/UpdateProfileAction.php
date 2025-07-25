<?php

namespace App\Actions\UserProfile;

use App\Models\User;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;


class UpdateProfileAction
{
    public function handle(User $user,  $validatedData, ?TemporaryUploadedFile $media = null): void
    {

        $user->update($validatedData);
        $user->profile->update($validatedData);

        if ($media) {
            $user->clearMediaCollection('avatar');
            $user->addMedia($media->getRealPath())->toMediaCollection('avatar');
        }
        
    }
}
