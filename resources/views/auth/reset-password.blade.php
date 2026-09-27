@extends('auth.index')

@section('authContent')
    <div class="card border-0 shadow-lg">
        <div class="card-body p-5">
            <div class="text-center">
                <h4 class="fw-bold text-dark mb-2">Reset Password</h4>
                <p class="text-muted">Enter your new password below.</p>
            </div>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ request()->email }}">

                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <div class="d-grid">
                    <button class="btn btn-dark btn-lg fw-medium" type="submit">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
@endsection
