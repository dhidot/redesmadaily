<?php

namespace App\Http\Livewire;

use App\Models\Department;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};


final class DepartmentTable extends PowerGridComponent
{
    use ActionButton;
    use LivewireAlert;

    public string $sortField = 'departments.created_at';
    public string $sortDirection = 'desc';

    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(),
            [
                'bulkCheckedDelete',
                'bulkCheckedEdit',
            ]
        );
    }


    public function header(): array
    {
        return [
            Button::make('destroy', 'Delete')
                ->class('btn btn-danger border-0')
                ->emit('bulkCheckedDelete', ['key' => 'id']),

            Button::add('bulk-edit-checked')
                ->caption(__('Edit'))
                ->class('btn btn-success border-0')
                ->emit('bulkCheckedEdit', []),
        ];
    }

    public function bulkCheckedDelete()
    {
        if (auth()->check()) {
            $ids = $this->checkedValues();

            if (!$ids)
                return $this->alert('warning', 'Pilih data yang ingin dihapus terlebih dahulu.', [
                    'position' => 'top-right',
                    'timer' => 3000,
                    'toast' => true,
                    'text' => '',
                    'showConfirmButton' => true,
                ]);

            try {
                Department::whereIn('id', $ids)->delete();
                $this->alert('success', 'Data berhasil dihapus.', [
                    'position' => 'top-right',
                    'timer' => 3000,
                    'toast' => true,
                    'text' => '',
                    'showConfirmButton' => true,
                ]);
            } catch (\Illuminate\Database\QueryException $ex) {
                $this->alert('error', 'Data gagal dihapus, kemungkinan ada data lain yang menggunakan data tersebut.', [
                    'position' => 'top-right',
                    'timer' => 3000,
                    'toast' => true,
                    'text' => '',
                    'showConfirmButton' => true,
                ]);
            }
        }
    }

    public function bulkCheckedEdit()
    {
        if (auth()->check()) {
            $ids = $this->checkedValues();

            if (!$ids)
                return $this->alert('warning', 'Pilih data yang ingin diedit terlebih dahulu.', [
                    'position' => 'top-right',
                    'timer' => 3000,
                    'toast' => true,
                    'text' => '',
                    'showConfirmButton' => true,
                ]);

            $ids = join('-', $ids);
            // return redirect(route('positions.edit', ['ids' => $ids])); // tidak berfungsi/menredirect
            return $this->dispatchBrowserEvent('redirect', ['url' => route('departments.edit', ['ids' => $ids])]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
     * PowerGrid datasource.
     *
     * @return Builder<\App\Models\Department>
     */
    public function datasource(): Builder
    {
        return Department::query()->latest();
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    */
    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('name')
            ->addColumn('created_at')
            ->addColumn('created_at_formatted', fn (Department $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            // Column::make('ID', 'id')
            //     ->searchable()
            //     ->sortable(),

            Column::make('Name', 'name')
                ->searchable()
                ->sortable(),

            // Column::make('Created at', 'created_at')
            //     ->hidden(),

            // Column::make('Created at', 'created_at_formatted', 'created_at')
            //     ->searchable()
        ];
    }
}
