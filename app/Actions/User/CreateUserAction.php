<?php

namespace App\Actions\User;

use App\Models\User;
use RuntimeException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\DataTransferObjects\UserDto;
use Illuminate\Support\Facades\Hash;
use App\Jobs\TriggerUserNotificationJob;
use App\Actions\AdSpend\CreateAdSpendAction;

class CreateUserAction
{
    public function handle(UserDto $dto): User
    {

        return DB::transaction(static function () use ($dto) {

            $password = Str::random(8);

            $user = User::create([
                'name'     => $dto->name,
                'email'    => $dto->email,
                'password' => Hash::make($password),
                'role'  => $dto->role,
            ]);

            $user->assignRole($dto->role);

            //TriggerUserNotificationJob::dispatch($user,$password,true);

            return $user;
        });
    }

}
