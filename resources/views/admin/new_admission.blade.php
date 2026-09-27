@extends('index')

@if (auth()->user()->type === 'admin')

    @section('adminContent')
        <div class="page-content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            New Admission
                        </h5>
                    </div>
                    <div class="card-body">

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.admission.submit') }}" enctype="multipart/form-data">
                            @csrf

                           @include('admin.partials.admission')


                            <button type="submit" class="btn btn-outline-success">Submit Admission</button>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    @endsection
    
@elseif(auth()->user()->type === 'staff')
    @section('staffContent')
        <div class="page-content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            New Admission
                        </h5>
                    </div>
                    <div class="card-body">

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('staff.admission.submit') }}" enctype="multipart/form-data">
                            @csrf

                            @include('admin.partials.admission')

                            <button type="submit" class="btn btn-outline-success">Submit Admission</button>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    @endsection

@endif
