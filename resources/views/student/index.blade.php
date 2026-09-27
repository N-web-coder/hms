@extends('index')
@section('studentContent')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Student Admission Form</h5>
                </div>

                <div class="card-body">
                    {{-- Flash Messages --}}
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
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('student.admission.submit') }}" enctype="multipart/form-data">
                        @csrf

                        <h5 class="mt-3">Personal Details</h5>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <input name="parent_number" class="form-control" placeholder="Parent Mobile" required>
                            </div>
                            <div class="col-md-6">
                                <input type="date" name="dob" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <input type="date" name="admission_date" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <input name="address" class="form-control" placeholder="Address" required>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <input name="pincode" class="form-control" placeholder="Pincode" required>
                            </div>
                            <div class="col-md-6">
                                <input name="adhar_number" class="form-control" placeholder="Aadhaar Number" required>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <input name="pan_number" class="form-control" placeholder="PAN Number">
                            </div>
                            <div class="col-md-6">
                                <select name="gender" class="form-control" required>
                                    <option value="">-- Gender --</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>

                        <hr>
                        <h5>Upload Documents</h5>
                        <div class="mb-2">
                            <label>Photo</label>
                            <input type="file" name="photo" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label>Aadhaar Document</label>
                            <input type="file" name="doc_adhar" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label>PAN Document</label>
                            <input type="file" name="doc_pan" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label>Qualification Document</label>
                            <input type="file" name="doc_qualification" class="form-control" required>
                        </div>

                        <hr>
                        <h5>Mesh Subscription</h5>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <select name="subscription" class="form-control" required>
                                    <option value="with_mesh">With Mesh</option>
                                    <option value="without_mesh">Without Mesh</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="date" name="mesh_start" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-2">
                            <select name="meal_type" class="form-control" required>
                                <option value="">-- Select Meal Type --</option>
                                <option value="break_fast">Breakfast</option>
                                <option value="lunch">Lunch</option>
                                <option value="dinner">Dinner</option>
                                <option value="all">All</option>
                            </select>
                        </div>

                        <hr>
                        <h5>Room & Bed Selection</h5>
                        <div class="mb-3">
                            <select name="bed_id" class="form-control" required>
                                <option value="">-- Select Bed --</option>
                                @foreach($rooms as $room)
                                    @foreach($room->beds->where('status', 'empty') as $bed)
                                        <option value="{{ $bed->id }}">Room {{ $room->room_number }} - Bed {{ $bed->bed_number }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>

                        <hr>
                        <h5>Admission Payment</h5>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <input type="number" name="amount" class="form-control" placeholder="Amount" required>
                            </div>
                            <div class="col-md-6">
                                <select name="payment_mode" class="form-control" required>
                                    <option value="cash">Cash</option>
                                    <option value="upi">UPI</option>
                                    <option value="card">Card</option>
                                </select>
                            </div>
                        </div>

                        <input type="text" name="ref_no" class="form-control mb-3" placeholder="Reference No (optional)">

                        <button class="btn btn-success w-100">Submit Admission</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
