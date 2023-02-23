@extends('layouts.dashboard.app')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card shadow">
                <div class="card-body">
                    <h6 class="fs-6 fw-light">Data Jabatan</h6>
                    <h4 class="fw-bold">{{ $positionCount }}</h4>

                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow">
                <div class="card-body">
                    <h6 class="fs-6 fw-light">Karyawan</h6>
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
    </div>
@endsection