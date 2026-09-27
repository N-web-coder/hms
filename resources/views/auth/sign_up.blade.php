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
                <h4 class="fw-bold text-dark mb-2">Sign Up</h4>
                <p class="text-muted">New to our platform? Sign up now! It only takes a
                    minute.
                </p>
            </div>

            <form class="mt-4" action="{{ route('signup.submit') }}" method="POST">

                @csrf
                @method('POST')
                <div class="mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control rounded-end" placeholder="Password" required>
                    <a role="button" class="password-show"><i class="fa-duotone fa-eye"></i></a>
                </div>
                <div class="mb-3">
                    <input type="text" name="mobile" class="form-control" placeholder="Mobile" required>
                </div>
                <div class="mb-3">
                    <select name="type" id="type" class="form-control" name="type" required>
                        <option value="">-- Select Type --</option>
                        <option value="staff">Staff</option>
                        <option value="student">Student</option>
                    </select>
                </div>
                <div class="d-grid">
                    <button class="btn btn-dark btn-lg fw-medium">Sign Up</button>
                </div>

            </form>
            <div class="text-center mt-4 text-white text-opacity-50">
                <p class="mb-0">Already have an account?
                    <a href="{{ route('signin') }}" class="text-decoration-none text-white fw-bold">Sign In</a>
                </p>
            </div>
        </div>
    </div>
@endsection
