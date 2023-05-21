<?php

namespace App\Http\Livewire;

use App\Models\Attendance;
use \Illuminate\Support\Str;

class AttendanceCreateForm extends AttendanceAbstract
{
    public function save()
    {
        // filter value before validate
        $this->position_ids = array_filter($this->position_ids, function ($id) {
            return is_numeric($id);
        });

        $position_ids = array_values($this->position_ids);

        $this->validate(
            [
                'attendance.title' => 'required|string|min:3',
                'attendance.description' => 'required|string|min:10|max:500',
                'attendance.start_time' => 'required|date_format:H:i',
                'attendance.batas_start_time' => 'required|date_format:H:i|after:start_time',
                'attendance.end_time' => 'required|date_format:H:i',
                'attendance.batas_end_time' => 'required|date_format:H:i|after:end_time',
                'attendance.code' => 'sometimes|nullable|boolean',
                'position_ids' => 'required|array',
                "position_ids.*"  => "required|distinct|numeric",
            ],
            [
                'attendance.title.required' => 'Judul harus diisi',
                'attendance.title.unique' => 'Judul sudah digunakan',
                'attendance.title.min' => 'Judul minimal terdiri dari 3 huruf',
                'attendance.description.required' => 'Deskripsi harus diisi',
                'attendance.description.min' => 'Deskripsi minimal 10 karakter',
                'attendance.start_time.required' => 'Start time harus diisi',
                'attendance.start_time.date_format:H:i' => 'Format tidak sesuai',
                'attendance.batas_start_time.required' => 'Batas start time harus diisi',
                'attendance.batas_start_time.date_format:H:i' => 'Format tidak sesuai',
                'attendance.end_time.required' => 'End time harus diisi',
                'attendance.end_time.date_format:H:i' => 'Format tidak sesuai',
                'attendance.batas_end_time.required' => 'Batas end time harus diisi',
                'attendance.batas_end_time.date_format:H:i' => 'Format tidak sesuai',
                'position_ids.required' => 'Pilih salah satu',
                "position_ids.*"  => "required|distinct|numeric",
            ]
        );

        if (array_key_exists("code", $this->attendance) && $this->attendance['code']) // jika menggunakan qrcode
            $this->attendance['code'] = Str::random();

        $attendance = Attendance::create($this->attendance);
        $attendance->positions()->attach($position_ids);

        redirect()->route('attendances.index')->with('success', "Form presensi berhasil ditambahkan.");
    }

    public function render()
    {
        return view('livewire.attendance-create-form');
    }
}
