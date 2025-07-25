<?php

namespace App\Livewire\Tables;

use App\Models\Room;
use App\Traits\LivewireAlert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Columns\IncrementColumn;

class RoomsTable extends DataTableComponent
{
    use LivewireAlert;

    public function builder(): Builder
    {
        return Room::query()->select('rooms.*');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableRowUrl(function ($row) {
                return route('admin.rooms.show', $row);
            })
            ->setTableRowUrlTarget(function ($row) {
                return 'navigate';
            })
            ->setHideBulkActionsWhenEmptyStatus(true)
        ;
    }

    public function columns(): array
    {
        return [
            IncrementColumn::make('No.'),

            Column::make('Location', "location")
                ->searchable(),

            Column::make('Capacity', 'capacity')
                ->searchable(),

        ];
    }
}
