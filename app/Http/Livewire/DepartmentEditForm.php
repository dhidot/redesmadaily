<?php

namespace App\Http\Livewire;

use App\Models\Department;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;


class DepartmentEditForm extends Component
{
    public $departments = [];

    public function mount(Collection $departments)
    {
        // $this->department = $department;
        $this->departments = []; // hapus departments collection
        foreach ($departments as $department) {
            $this->departments[] = ['id' => $department->id, 'name' => $department->name];
        }
    }

    public function saveDepartments()
    {
        // tidak mengimplementasikan validasi, karena jika input kosong berarti data tersebut tidak akan diubah
        // ambil input/request dari department yang berisi
        $departments = array_filter($this->departments, function ($a) {
            return trim($a['name']) !== "";
        });

        // buat validasi jika input sama dengan nilai awal (tidak diubah) maka tidak perlu diubah
        $this->validate(
            [
                'departments.*.name' => 'required|unique:departments|min:6',
            ],
            [
                'departments.*.name.required' => 'Setidaknya input departemen pertama wajib diisi.',
                'departments.*.name.unique' => 'Nama departemen tidak boleh sama.',
                'departments.*.name.min' => 'Nama departemen minimal 6 huruf'
            ]
        );

        $affected = 0;
        foreach ($departments as $department) {
            $affected += department::find($department['id'])->update(['name' => $department['name']]);
        }

        $message = $affected === 0 ?
            "Tidak ada data jabatan yang diubah." :
            "Ada $affected data jabatan yang berhasil diedit.";

        return redirect()->route('departments.index')->with('success', $message);
    }

    public function render()
    {
        return view('livewire.department-edit-form');
    }
}
