@extends('layouts.auth')

@push('style')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="card">
        <div class="row text-center">
            <div class="col-md-6">
                <img src="{{ asset('img/redesma.png') }}" alt="" class="w-100">
            </div>
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <form method="POST" action="{{ route('auth.login') }}" id="login-form">
                    @csrf
                    <div class="head mb-3">
                        <h1 class="text-center">
                            <i class="bi bi-person-circle"></i>
                            <span>Log In</span>
                        </h1>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="example@gmail.com">
                        <label for="email">Email address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Password">
                        <label for="password">Password</label>
                    </div>
                    <button class="btn btn-primary mt-2" type="submit" id="login-form-button">Log In</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script type="module" src="{{ asset('js/auth/login.js') }}"></script>
@endpush