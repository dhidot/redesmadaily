@extends('layouts.auth')

@push('style')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endpush

@section('content')
<div class="card">
    <main class="form-signin m-auto">
        <form method="POST" action="{{ route('auth.login') }}" id="login-form">
            <h1 class="h3 mb-3 fw-normal">Silahkan masuk untuk absensi</h1>

            <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email">
                <label for="email">Email address</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" name="password"
                    placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>
            <button class="w-100 btn btn-primary" type="submit" id="login-form-button">Log In</button>
        </form>
    </main>
</div>

@endsection

@push('script')
<script type="module" src="{{ asset('js/auth/login.js') }}"></script>
@endpush