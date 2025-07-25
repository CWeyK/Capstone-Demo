<?php

namespace App\Livewire\Tables;

use App\Models\Subject;
use App\Models\Programme;
use App\Traits\LivewireAlert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Columns\IncrementColumn;

class SubjectsTable extends DataTableComponent
{
    use LivewireAlert;

    public ?string $programmeId = null;
    public ?string $userId = null;
    public ?string $lecturerId = null;

    public function builder(): Builder
    {
        if (!is_null($this->userId)) {
            $this->programmeId = Auth::user()->programme->id;
        }

        return Subject::query()
        ->select('subjects.*')
        ->when($this->programmeId, function ($query) {
            $query->whereHas('programmes', function ($q) {
                $q->where('programmes.id', $this->programmeId);
            });
        })
        ->when($this->lecturerId, function ($query) {
            $query->whereHas('lecturers', function ($q) {
                $q->where('users.id', $this->lecturerId);
            });
        });
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableRowUrl(function ($row) {
                return route('admin.subjects.show', $row);
            })
            ->setTableRowUrlTarget(function ($row) {
                return 'navigate';
            })
            ->setHideBulkActionsWhenEmptyStatus(true)
        ;
    }

    public function bulkActions(): array
    {
        if (isset($this->programmeId) && $this->userId === null) {
            return [
                'unassign' => 'Unassign',   
            ];
        } else {
            return [];
        }
    }

    public function unassign(): void
    {
        $programme = Programme::findOrFail($this->programmeId);
        $programme->subjects()->detach($this->getSelected());

        $this->alertSuccess(
            __('Subject has been unassigned successfully!'),
            [
                'timer'              => 3000,
                'onConfirmed'        => 'close-modal',
                'onProgressFinished' => 'close-modal',
                'onDismissed'        => 'close-modal'
            ]
        );
        
        $this->clearSelected();
    }

    public function columns(): array
    {
        return [
            IncrementColumn::make('No.'),

            Column::make('Subject Name', "name")
                ->searchable(),

        ];
    }
}
