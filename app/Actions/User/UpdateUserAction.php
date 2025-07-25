<?php

namespace App\Actions\User;

use App\Models\User;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;


class UpdateUserAction
{
    public function handle(User $user,  $validatedData, ?TemporaryUploadedFile $media = null): void
    {

        $user->update($validatedData);

        if($user->parent_id != $validatedData['parent'])
        {
            $user->update([
                'parent_id' => $validatedData['parent']
            ]);
        }
        
        $user->profile->update($validatedData);

        if (isset($validatedData['group'])) {
            $user->group_id = $validatedData['group'];
            $user->save();
        }

        if ($media) {
            $user->clearMediaCollection('avatar');
            $user->addMedia($media->getRealPath())->toMediaCollection('avatar');
        }
        
    }
}
