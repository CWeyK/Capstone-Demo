<?php

namespace App\Livewire\Tables;

use App\Models\Subject;
use App\Models\User;
use App\Traits\LivewireAlert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Columns\IncrementColumn;

class UsersTable extends DataTableComponent
{
    use LivewireAlert;
    public ?string $role = null;
    public ?string $programmeId = null;
    public ?string $subjectId = null;

    public function builder(): Builder
    {
        return User::query()
        ->select(['id', 'name', 'email'])
        ->when($this->subjectId, function ($query) {
            $query->whereHas('lecturerSubjects', function ($q) {
                $q->where('subjects.id', $this->subjectId);
            });
        })
        ->when($this->programmeId, function ($query) {
            $query->where('programme_id', $this->programmeId);
        });
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableRowUrl(function ($row) {
                return route('admin.users.show', $row);
            })
            ->setTableRowUrlTarget(function ($row) {
                return 'navigate';
            })
            ->setHideBulkActionsWhenEmptyStatus(true)
        ;
    }
    

    public function bulkActions(): array
    {
        if (isset($this->subjectId) && Auth::user()->hasRole('Admin')) {
            return [
                'unassignLecturer' => 'Unassign',   
            ];
        } else {
            return [];
        }
    }

    public function unassignLecturer(): void
    {
        $subject = Subject::findOrFail($this->subjectId);
        $subject->lecturers()->detach($this->getSelected());

        $this->alertSuccess(
            __('Lecturer has been unassigned successfully!'),
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

            Column::make('User', "name")
                ->format(fn($value, $row) => view('livewire.user.partials._user-table', ['value' => $value, 'row' => $row]))
                ->searchable(),

            Column::make('Role', 'id')
                ->format(fn ($value, $row) => $row->getRoleNames()->join(', ')),

        ];
    }
}
