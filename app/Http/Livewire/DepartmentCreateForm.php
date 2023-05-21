<?php

namespace App\Http\Livewire;

use App\Models\Department;
use Livewire\Component;

class DepartmentCreateForm extends Component
{

    public $departments;

    public function mount()
    {
        $this->departments = [
            ['name' => '']
        ];
    }

    public function addDepartmentInput(): void
    {
        $this->departments[] = ['name' => ''];
    }

    public function removeDepartmentInput(int $index): void
    {
        unset($this->departments[$index]);
        $this->departments = array_values($this->departments);
    }

    public function saveDepartments()
    {
        // setidaknya input pertama yang hanya required,
        // karena nanti akan difilter apakah input kedua dan input selanjutnya apakah berisi
        $this->validate(
            [
                'departments.0.name' => 'required|unique:departments,name|min:6',
            ],
            [
                'departments.0.name.required' => 'Setidaknya input departemen pertama wajib diisi.',
                'departments.0.name.unique' => 'Departemen sudah ada.',
                'departments.0.name.min' => 'Nama departemen minimal 6 huruf'
            ]
        );

        // ambil input/request dari position yang berisi
        $departments = array_filter($this->departments, function ($a) {
            return trim($a['name']) !== "";
        });

        // alasan menggunakan create dibandingkan mengunakan ::insert adalah karena tidak looping untuk menambahkan created_at dan updated_at
        foreach ($departments as $department) {
            Department::create($department);
        }

        redirect()->route('departments.index')->with('success', 'Data Departemen berhasil ditambahkan.');
    }

    public function render()
    {
        return view('livewire.department-create-form');
    }
}
