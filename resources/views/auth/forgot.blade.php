@extends('auth.index')

@section('authContent')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


    <div class="card border-0 shadow-lg">
        <div class="card-body p-5">
            <div class="text-center">
                <div class="mx-auto mb-4 text-center auth-logo">
                    <a href="index.html" class="logo-dark">
                        <img src="{{asset('assets/images/logo-dark.png')}}" height="32" alt="logo dark">
                    </a>

                    <a href="index.html" class="logo-light">
                        <img src="{{asset('assets/images/logo-light.png')}}" height="28" alt="logo light">
                    </a>
                </div>
                <h4 class="fw-bold text-dark mb-2">Reset Password</h4>
                <p class="text-muted">Enter your email address and we'll send you an email
                    with instructions to reset your password.</p>
            </div>
            <form class="mt-4" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter your email">
                </div>
                <div class="d-grid">
                    <button class="btn btn-dark btn-lg fw-medium" type="submit">Reset
                        Password</button>
                </div>
            </form>
        </div>
    </div>
    <p class="text-center mt-4 text-white text-opacity-50">Back to
        <a href="{{ route('signin') }}" class="text-decoration-none text-white fw-bold">Sign In</a>
    </p>
@endsection
