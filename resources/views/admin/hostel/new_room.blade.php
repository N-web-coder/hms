@extends('index')
@section('adminContent')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Add New Room
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">

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

                        <form method="POST" action="{{ route('admin.hostel.newroom.submit') }}">
                            @csrf

                            <div>

                                <div class=" mb-3">
                                    <label for="room">Room Number</label>
                                    <input type="text" name="room" class="form-control" required>
                                </div>
                                <div class=" mb-3">
                                    <label for="bed">Total Beds In This Room</label>
                                    <input type="text" name="bed" class="form-control" required>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-outline-success ">Submit</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
