<?php

namespace App\Livewire\Tables;

use App\Models\Programme;
use App\Traits\LivewireAlert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Columns\IncrementColumn;

class ProgrammesTable extends DataTableComponent
{
    use LivewireAlert;

    public function builder(): Builder
    {
        return Programme::query()->select('programmes.*');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableRowUrl(function ($row) {
                return route('admin.programmes.show', $row);
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

            Column::make('Programme Name', "name")
                ->searchable(),

        ];
    }
}
