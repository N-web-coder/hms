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
                <h4 class="fw-bold text-dark mb-2">Welcome Back!</h4>
                <p class="text-muted">Sign in to your account to continue</p>
            </div>

            <form class="mt-4" action={{ route('signin.submit') }} method="POST">
                @csrf
                @method('POST')
                <div class="mb-3">
                    <input type="email" class="form-control" name="email" placeholder="Enter your email">
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Enter your password">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ url('forgot') }}" class="text-decoration-none small text-muted">Forgot password?</a>
                    </div>
                </div>

                <div class="d-grid">
                    <button class="btn btn-dark btn-lg fw-medium" type="submit">Sign In</button>
                </div>
            </form>
        </div>
    </div>
    <p class="text-center mt-4 text-white text-opacity-50">Don't have an account?
        <a href="{{ url('signup') }}" class="text-decoration-none text-white fw-bold">Sign Up</a>
    </p>
@endsection
