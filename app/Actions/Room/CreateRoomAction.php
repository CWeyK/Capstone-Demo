<?php

namespace App\Actions\Room;

use App\Models\Room;
use RuntimeException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\DataTransferObjects\RoomDto;

class CreateRoomAction
{
    public function handle(RoomDto $dto): Room
    {

        return DB::transaction(static function () use ($dto) {

            $room = Room::create([
                'location'     => $dto->location,
                'capacity'    => $dto->capacity,
            ]);

            return $room;
        });
    }

}
