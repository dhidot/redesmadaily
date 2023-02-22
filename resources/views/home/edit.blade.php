@extends('layouts.home')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                    <form action="{{ route('home.update-password') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @elseif (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <div class="form-floating mb-3">
                                <input name="old_password" id="floatingPassword" type="password" class="form-control @error('old_password') is-invalid @enderror" id="oldPasswordInput"
                                    placeholder="Old Password">
                                @error('old_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <label for="oldPasswordInput">Old Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input name="new_password" id="floatingPassword" type="password" class="form-control @error('new_password') is-invalid @enderror" id="newPasswordInput"
                                    placeholder="New Password">
                                <label for="newPasswordInput" class="form-label">New Password</label>
                                @error('new_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input name="new_password_confirmation" id="floatingPassword" type="password" class="form-control" id="confirmNewPasswordInput"
                                    placeholder="Confirm New Password">
                                <label for="confirmNewPasswordInput" class="form-label">Confirm New Password</label>
                            </div>
                            <button class="btn btn-success">Submit</button>
                        </div>
                        
                    </form>
            </div>
        </div>
    </div>
@endsection
