@extends('layouts.home')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-2">
                <div class="card-header">
                    Daftar Presensi
                </div>
                <div class="card-body">
                    @if (count($attendances) === 0)
                    <div class="alert alert-info">
                        Tidak ada form presensi yang bisa ditampilkan.
                    </div>
                    @endif
                    <ul class="list-group">
                        @foreach ($attendances as $attendance)
                        <a href="{{ route('home.show', $attendance->id) }}"
                            class="list-group-item d-flex justify-content-between align-items-start py-3">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">{{ $attendance->title }}</div>
                                <p class="mb-0">{{ $attendance->description }}</p>
                            </div>
                            @include('partials.attendance-badges')
                        </a>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    Informasi Karyawan
                </div>
                <div class="card-body">
                    <ul class="ps-3">
                        <li class="mb-1">
                            <span class="fw-bold d-block">Nama</span>
                            <span>{{ auth()->user()->name }}</span>
                        </li>
                        <li class="mb-1">
                            <span class="fw-bold d-block">Email</span>
                            <span>{{ auth()->user()->email }}</span>
                        </li>
                        <li class="mb-1">
                            <span class="fw-bold d-block">Nomor Telepon</span>
                            <span>{{ auth()->user()->phone }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection