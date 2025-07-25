<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\User;
use App\Models\Group;
use App\Models\AgentRank;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\DataTransferObjects\UserDto;
use App\Actions\User\CreateUserAction;
use App\Actions\User\UpdateUserAction;
use App\Actions\User\PromoteUserAction;
use App\Actions\User\RegisterUserAction;
use App\Actions\User\UpdateUserPasswordAction;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class UserForm extends Form
{
    public string $email = '';
    public string $name = '';
    public string $mobile_number = '';
    public string $role = '';
    public ?string $password = null;
    public ?string $password_confirmation = null;
    public array $roles;
    public ?User $user = null;




    public function setUser(User $user)
    {
        $this->user = $user;
    }

    protected function rules()
    {
        return [
            'email'                 => ['required', 'string', 'email', Rule::unique('users', 'email')->ignore($this->user?->id)],
            'name'                  => ['required', 'string'],
            'mobile_number'         => [$this->user ? 'nullable' : 'required', 'string'],
            'role'                  => ['required', 'string'],
        ];
    }
    public function storeUser($validatedData)
    {
        app(CreateUserAction::class)->handle(UserDto::fromAppRequest($validatedData));
    }

    public function updateUser($validatedData, User $user)
    {
        app(UpdateUserAction::class)->handle(
            $user,
            $validatedData,
            $validatedData['avatar']
        );
    }

    public function updatePassword($validatedData, User $user)
    {
        app(UpdateUserPasswordAction::class)->handle(
            $validatedData,
            $user,
        );
    }

    public function initRoles()
    {
        return Role::where('name', '!=', 'Super-Admin')
            ->pluck('name', 'name')
            ->toArray();
    }
}
