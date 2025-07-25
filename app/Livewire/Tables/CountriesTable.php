<?php

namespace App\Livewire\Tables;

use App\Models\Country;
use App\Traits\LivewireAlert;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\IncrementColumn;

class CountriesTable extends DataTableComponent
{
    
    use LivewireAlert;

    public function builder(): Builder
    {
        return Country::query() 
            ->select('countries.*')
            ->whereIn('id',[10,121,122,189]); 
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            IncrementColumn::make('No.'),
            
            Column::make('Country', "name")
            ->searchable(),

            Column::make('Currency', "currency"),

            Column::make('Currency Label', "currency_label"),

            Column::make('Conversion Rate', "conversion_rate"),

            Column::make('GST Rate', 'gst_rate'),

            Column::make('Action', "id")
            ->format(function ($row) {
                return view('livewire.shipping.partials._country-table-edit', ['row' => $row]);
            })

        ];
    }

}



