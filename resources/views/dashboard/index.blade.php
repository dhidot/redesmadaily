@extends('layouts.dashboard.app')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card shadow" id="dept">
                <div class="card-body">
                    <h6 class="fs-6 fw-light">Jumlah Departemen</h6>
                    <h4 class="fw-bold">{{ $departmentCount }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow" id="pos">
                <div class="card-body">
                    <h6 class="fs-6 fw-light">Jumlah Jabatan</h6>
                    <h4 class="fw-bold">{{ $positionCount }}</h4>

                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow" id="employee">
                <div class="card-body">
                    <h6 class="fs-6 fw-light">Jumlah Karyawan</h6>
                    <h4 class="fw-bold">{{ $employeeCount }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        {{-- show this date and day --}}
        <h2>Traffic Presensi Hari ini</h2>
        {{-- Presentase presensi karyawan tetap hari ini --}}
        <div class="col-md-3">
            <div class="card shadow">
                <div class="card-body">
                    {{-- use chart js --}}
                    <canvas id="staffPresence">
                    </canvas>
                </div>
            </div>
        </div>
        {{-- Internship yang hadir hari ini --}}
        <div class="col-md-3">
            <div class="card shadow">
                <div class="card-body">
                    <canvas id="internshipPresence"></canvas>
                </div>
            </div>
        </div>
        {{-- Recap kehadiran Karyawan Part time --}}
        <div class="col-md-3">
            <div class="card shadow">
                <div class="card-body">
                    <canvas id="partTimePresence"></canvas>
                </div>
            </div>
    </div>
@endsection