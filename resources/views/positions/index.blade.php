@extends('layouts.app')

@push('style')
@powerGridStyles
@endpush

@section('buttons')
<div class="btn-toolbar mb-2 mb-md-0">
    <div>
        <a href="{{ route('positions.create') }}" class="btn btn-sm btn-primary">
            <span data-feather="plus-circle" class="align-text-bottom me-1"></span>
            Tambah Data Jabatan
        </a>
    </div>
</div>
@endsection

@section('content')
@include('partials.alerts')
<livewire:position-table />
@endsection

@push('script')
@livewireScripts
@powerGridScripts
<script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<x-livewire-alert::scripts />
@endpush