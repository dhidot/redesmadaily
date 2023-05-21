<?php

namespace App\Http\Livewire;

use App\Models\Position;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PhpParser\Node\Expr\PostDec;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class PositionTable extends PowerGridComponent
{
    use ActionButton;
    use LivewireAlert;


    public string $sortField = 'positions.created_at';
    public string $sortDirection = 'desc';

    protected function getListeners()
    {
        return [
            'bulkCheckedDelete',
            'bulkCheckedEdit',
        ];
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
            try {
                Position::whereIn('id', $ids)->delete();
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
                return $this->alert('warning', 'Pilih data yang ingin diedit terlebih dahulu.', [
                    'position' => 'top-right',
                    'timer' => 3000,
                    'toast' => true,
                    'text' => '',
                    'showConfirmButton' => true,
                ]);
            $ids = join('-', $ids);
            // return redirect(route('positions.edit', ['ids' => $ids])); // tidak berfungsi/menredirect
            return $this->dispatchBrowserEvent('redirect', ['url' => route('positions.edit', ['ids' => $ids])]);
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
     * @return Builder<\App\Models\Position>
     */
    public function datasource(): Builder
    {
        return Position::query()->latest();
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

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
            ->addColumn('created_at_formatted', fn (Position $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
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

            Column::make('Name', 'name')
                ->searchable()
                ->sortable(),

            Column::make('Created at', 'created_at')
                ->hidden(),

            // Column::make('Created at', 'created_at_formatted', 'created_at')
            //     ->makeInputDatePicker()
            //     ->searchable()
        ];
    }
}
