<?php

namespace App\Http\Livewire;

use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use App\Models\Department;
use App\Mail\EmployeeCreatedMail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;

class EmployeeCreateForm extends Component
{
    public $employees;
    public $generatePassword = [];
    public Collection $roles;
    public Collection $positions;
    public Collection $departments;

    public function mount()
    {
        $this->positions = Position::all();
        $this->departments = Department::all();
        $this->roles = Role::all();
        $this->employees = [
            ['name' => '', 'email' => '', 'phone' => '', 'password' => '', 'department_id' => $this->departments->first()->id, 'role_id' => User::USER_ROLE_ID, 'position_id' => $this->positions->first()->id]
        ];
    }

    public function addEmployeeInput(): void
    {
        $this->employees[] = ['name' => '', 'email' => '', 'phone' => '', 'password' => '', 'department_id' => $this->departments->first()->id, 'role_id' => User::USER_ROLE_ID, 'position_id' => $this->positions->first()->id];
    }

    public function removeEmployeeInput(int $index): void
    {
        unset($this->employees[$index]);
        $this->employees = array_values($this->employees);
    }

    public function saveEmployees()
    {
        // cara lebih cepat, dan kemungkinan data role tidak akan diubah/ditambah
        $roleIdRuleIn = join(',', $this->roles->pluck('id')->toArray());
        $positionIdRuleIn = join(',', $this->positions->pluck('id')->toArray());
        $departmentIdRuleIn = join(',', $this->departments->pluck('id')->toArray());
        // $roleIdRuleIn = join(',', Role::all()->pluck('id')->toArray());

        // setidaknya input pertama yang hanya required,
        // karena nanti akan difilter apakah input kedua dan input selanjutnya apakah berisi
        $this->validate(
            [
                'employees.*.name' => 'required',
                'employees.*.email' => 'required|email|unique:users,email',
                'employees.*.phone' => 'required|unique:users,phone',
                'employees.*.password' => '',
                'employees.*.department_id' => 'required|in:' . $departmentIdRuleIn,
                'employees.*.role_id' => 'required|in:' . $roleIdRuleIn,
                'employees.*.position_id' => 'required|in:' . $positionIdRuleIn,
            ],
            [
                'employees.*.name.required' => 'Nama harus diisi',
                'employees.*.email.required' => 'Email harus diisi',
                'employees.*.email.email' => 'Format email harus sesuai',
                'employees.*.email.unique' => 'Alamat email sudah ada yang menggunakan',
                'employees.*.phone.required' => 'Nomor telepon harus diisi',
                'employees.*.phone.unique' => 'Nomor telpon sudah ada yang menggunakan',
                'employees.*.password' => '',
                'employees.*.department_id' => 'required|in:' . $departmentIdRuleIn,
                'employees.*.role_id' => 'required|in:' . $roleIdRuleIn,
                'employees.*.position_id' => 'required|in:' . $positionIdRuleIn,
            ]
        );
        // cek apakah no. telp yang diinput unique
        $phoneNumbers = array_map(function ($employee) {
            return trim($employee['phone']);
        }, $this->employees);
        $uniquePhoneNumbers = array_unique($phoneNumbers);

        if (count($phoneNumbers) != count($uniquePhoneNumbers)) {
            // layar browser ke paling atas agar user melihat alert error
            $this->dispatchBrowserEvent('livewire-scroll', ['top' => 0]);
            return session()->flash('failed', 'Pastikan input No. Telp tidak mangandung nilai yang sama.');
        }

        // alasan menggunakan create alih2 mengunakan ::insert adalah karena tidak looping untuk menambahkan created_at dan updated_at
        $affected = 0;
        foreach ($this->employees as $employee) {
            $employee['password'] = Str::random(8);
            // if (trim($employee['password']) === '') $employee['password'] = '123';
            $passwordBeforeHash = $employee['password'];
            $employee['password'] = Hash::make($employee['password']);
            User::create($employee);
            $email = $employee['email'];
            Mail::to($email)->send(new EmployeeCreatedMail($email, $passwordBeforeHash));
            $affected++;
        }

        redirect()->route('employees.index')->with('success', "Ada ($affected) data karyawaan yang berhasil ditambahkan.");
    }

    public function render()
    {
        // display the password to the password input field in the form view (employee-create-form.blade.php) 
        return view('livewire.employee-create-form', []);
    }
}
