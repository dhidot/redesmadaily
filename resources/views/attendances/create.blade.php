@extends('layouts.app')

@push('style')
<link rel="stylesheet" href="{{ asset('tom-select/tom-select.css') }}">
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
@endpush

@section('buttons')
<div class="btn-toolbar mb-2 mb-md-0">
    <div>
        <a href="{{ route('attendances.index') }}" class="btn btn-sm btn-light">
            <span data-feather="arrow-left-circle" class="align-text-bottom"></span>
            Kembali
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-7">
        <livewire:attendance-create-form />
    </div>
</div>
@endsection