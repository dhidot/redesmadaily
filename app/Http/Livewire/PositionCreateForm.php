<?php

namespace App\Http\Livewire;

use App\Models\Position;
use Livewire\Component;

class PositionCreateForm extends Component
{

    public $positions;

    public function mount()
    {
        $this->positions = ['name' => ''];
    }

    public function addPositionInput()
    {
        $this->positions[] = ['name' => ''];
    }

    public function removePositionInput($index)
    {
        unset($this->positions[$index]);
        $this->positions = array_values($this->positions);
    }

    public function savePositionInput(int $index): void
    {
        // Hanya input pertama yang required
        // Karena akan difilter apakah input kedua dan input selanjutnya kosong atau tidak

        $this->validate(
            [
                'positions.0.name' => 'required',
            ],
            [
                'positions.0.name.required' => 'Nama posisi tidak boleh kosong',
            ]
        );

        // Ambil input dari posisi yang diisi
        $positions = array_filter($this->positions, function ($position) {
            return $position['name'] !== '';
        });

        // Simpan ke database
        foreach ($positions as $position) {
            Position::create($position);
        }

        redirect()->route('positions.index')->with('success', 'Posisi berhasil ditambahkan');
    }

    public function render()
    {
        return view('livewire.position-create-form');
    }
}
