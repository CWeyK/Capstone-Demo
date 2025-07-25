<?php

namespace App\Livewire\Tables;

use App\Models\User;
use App\Models\Subject;
use App\Models\ClassGroupUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Columns\IncrementColumn;

class EnrollmentsTable extends DataTableComponent
{
    public ?string $userId = null;
    public function builder(): Builder
    {
        return ClassGroupUser::query()
        ->where('user_id', $this->userId)
        ->with(['user', 'classGroup.subjectClass.subject']);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
        ->setSearchStatus(false);
        
    }
    
    public function columns(): array
    {
        return [    
            IncrementColumn::make('No.'),

            Column::make('Subject', 'classGroup.subjectClass.subject.name'),

            Column::make('Class Type', 'classGroup.subjectClass.class_type'),

            Column::make('Group', 'classGroup.group'),

        ];
    }
}
