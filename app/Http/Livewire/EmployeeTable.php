<?php

namespace App\Http\Livewire;

use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class EmployeeTable extends PowerGridComponent
{
    use ActionButton;
    use LivewireAlert;

    //Table sort field
    public string $sortField = 'users.created_at';
    public string $sortDirection = 'desc';

    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(),
            [
                'bulkCheckedDelete',
                'bulkCheckedEdit'
            ]
        );
    }

    public function header(): array
    {
        return [
            Button::add('bulk-checked')
                ->caption(__('Hapus'))
                ->class('btn btn-danger border-0')
                ->emit('bulkCheckedDelete', []),
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

            if (in_array(auth()->user()->id, $ids))
                return $this->alert('error', 'Tidak dapat menghapus akun sendiri.', [
                    'position' => 'top-right',
                    'timer' => 3000,
                    'toast' => true,
                    'text' => '',
                    'showConfirmButton' => true,
                ]);


            try {
                User::whereIn('id', $ids)->delete();
                $this->alert('success', 'Data berhasil dihapus.', [
                    'position' => 'top-right',
                    'timer' => 3000,
                    'toast' => true,
                    'text' => '',
                    'showConfirmButton' => true,
                ]);
            } catch (\Illuminate\Database\QueryException $ex) {
                $this->alert('error', 'Data gagal dihapus, ada data lain yang menggunakan data ini', [
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
                return $this->alert('error', 'Pilih data yang ingin diedit terlebih dahulu.', [
                    'position' => 'top-right',
                    'timer' => 3000,
                    'toast' => true,
                    'text' => '',
                    'showConfirmButton' => true,
                ]);

            $ids = join('-', $ids);
            // return redirect(route('employees.edit', ['ids' => $ids])); // tidak berfungsi/menredirect
            return $this->dispatchBrowserEvent('redirect', ['url' => route('employees.edit', ['ids' => $ids])]);
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
            Header::make()->showSearchInput()->showToggleColumns(),
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
     * @return Builder<\App\Models\User>
     */
    public function datasource(): Builder
    {
        return User::query()
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->join('positions', 'users.position_id', '=', 'positions.id')
            ->join('departments', 'users.department_id', '=', 'departments.id')
            ->select('users.*', 'roles.name as role', 'positions.name as position', 'departments.name as department');
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
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
            ->addColumn('email')
            ->addColumn('phone')
            ->addColumn('role', function (User $model) {
                return ucfirst($model->role);
            })
            ->addColumn('position', function (User $model) {
                return ucfirst($model->position);
            })
            ->addColumn('department', function (User $model) {
                return ucfirst($model->department);
            })
            ->addColumn('created_at')
            ->addColumn('created_at_formatted', fn (User $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

    /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::make('Name', 'name', 'users.name')
                ->searchable()
                ->editOnClick()
                ->sortable(),

            Column::make('Email', 'email', 'users.email')
                ->sortable()
                ->searchable(),

            Column::make('No. Telp', 'phone', 'users.phone')
                ->sortable()
                ->searchable(),

            Column::make('Department', 'department', 'departments.name')
                ->sortable()
                ->searchable(),

            Column::make('Jabatan', 'position', 'positions.name')
                ->searchable()
                ->sortable(),

            Column::make('Role', 'role', 'roles.name')
                ->searchable()
                ->sortable(),
        ];
    }
}
