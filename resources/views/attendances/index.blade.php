@extends('layouts.app')

@push('style')
@powerGridStyles
@endpush

@section('buttons')
<div class="btn-toolbar mb-2 mb-md-0">
    <div>
        <a href="{{ route('attendances.create') }}" class="btn btn-sm btn-primary">
            <span data-feather="plus-circle" class="align-text-bottom me-1"></span>
            Tambah Data Presensi
        </a>
    </div>
</div>
@endsection

@section('content')
@include('partials.alerts')
<livewire:attendance-table />
@endsection

@push('script')
@livewireScripts
@powerGridScripts
<script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<x-livewire-alert::scripts />
@endpush