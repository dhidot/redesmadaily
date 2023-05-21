@extends('layouts.app')

@push('style')
@powerGridStyles
@endpush

@section('buttons')
<div class="btn-toolbar mb-2 mb-md-0">
    <div>
        <a href="{{ route('departments.create') }}" class="btn btn-sm btn-primary">
            <span data-feather="plus-circle" class="align-text-bottom me-1"></span>
            Tambah Data Department
        </a>
    </div>
</div>
@endsection

@section('content')
@include('partials.alerts')
<livewire:department-table />
@endsection

@push('script')
@livewireScripts
@powerGridScripts
@include('sweetalert::alert')
<script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.addEventListener('showAlert', event => {
        alert(event.detail.message);
    });
</script>
<x-livewire-alert::scripts />
@endpush