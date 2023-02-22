@extends('layouts.home')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
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
    </div>
</div>
@endsection