@extends('index')
@section('studentContent')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Admission Details
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
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($admission)
                        <p><strong>DOB:</strong> {{ $admission->dob }}</p>
                        <p><strong>Address:</strong> {{ $admission->address }}</p>
                        <p><strong>Pincode:</strong> {{ $admission->pincode }}</p>
                        <p><strong>Aadhaar:</strong> {{ $admission->adhar_number }}</p>
                        <p><strong>PAN:</strong> {{ $admission->pan_number }}</p>
                        <h4>Admission Status</h4>

                        @if ($admission)
                            <p><strong>Status:</strong>
                                @if ($admission->status == 'active')
                                    <span class="badge text-success">Active</span>
                                @else
                                    <span class="badge text-warning text-dark">Pending Approval</span>
                                @endif
                            </p>
                        @else
                            <p class="text-danger">You have not submitted the admission form.</p>
                        @endif

                        <p><strong>Gender:</strong> {{ ucfirst($admission->gender) }}</p>
                        <p><strong>Admission Date:</strong> {{ $admission->admission_date }}</p>
                    @else
                        <p class="text-danger">Admission not available.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>


@endsection
