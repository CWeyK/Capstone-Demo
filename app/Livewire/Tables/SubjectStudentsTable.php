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

class SubjectStudentsTable extends DataTableComponent
{
    use LivewireAlert;
    public ?string $subjectId = null;

    public $subjectClasses;

    public function mount(): void
    {
        $subject = Subject::find($this->subjectId);
        $this->subjectClasses = $subject->classes->all();
    }

    public function builder(): Builder
    {
        return User::query()
        ->whereHas('studentGroups.subjectClass.subject', function ($query) {
            if ($this->subjectId) {
                $query->where('id', $this->subjectId);
            }
        })
        ->select('users.id', 'users.name', 'users.email')
        ;
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
    
    public function columns(): array
    {
        $columns = [];
        $columns[] = IncrementColumn::make('No.');
        $columns[] = Column::make('User', "name")
            ->format(fn($value, $row) => view('livewire.user.partials._user-table', ['value' => $value, 'row' => $row]))
            ->searchable();

        foreach ($this->subjectClasses as $subjectClass) {
            $columns[] = Column::make("{$subjectClass->class_type} Group", 'name')
                ->label(fn ($row) => $subjectClass->class_type . ' ' . (
                    optional($row->studentGroups->where('subject_class_id', $subjectClass->id)->first())->group ?? 'N/A'
                ));
        }
        
        $columns[] = Column::make('Action', "id")
            ->format(function ($row) {
                return view('livewire.subject.subject-table-edit', ['row' => $row, 'subject' => $this->subjectId]);
            })->unclickable();

        return $columns;
    }
}
