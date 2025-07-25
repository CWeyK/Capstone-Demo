<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Room;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\DataTransferObjects\RoomDto;
use App\Actions\Room\CreateRoomAction;

class RoomForm extends Form
{
    public string $location = '';
    public ?int $capacity;
    public ?Room $room = null;

    protected function rules()
    {
        return [
            'location'              => ['required', 'string', Rule::unique('rooms', 'location')->ignore($this->room?->id)],
            'capacity'              => ['required', 'integer','min:1'],
        ];
    }
    public function storeRoom($validatedData)
    {
        app(CreateRoomAction::class)->handle(RoomDto::fromAppRequest($validatedData));
    }

}
