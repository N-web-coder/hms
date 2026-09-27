@extends('index')

@section('adminContent')
    <div class="page-content">
        <div class="container-fluid">

            {{-- Success Alert --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Error Alert --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Company Information</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('companyinfo.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label><strong>Owner Name</strong></label>
                                <input type="text" name="owner" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label><strong>Company Name</strong></label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label><strong>Company Email</strong></label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>Mobile</strong></label>
                                <input type="text" name="mobile" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>Full Address</strong></label>
                                <input type="text" name="address" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label><strong>Pincode</strong></label>
                                <input type="text" name="pincode" class="form-control" >
                            </div>
                            <div class="col-md-6 mb-3">
                                <label><strong>City</strong></label>
                                <input type="text" name="city" class="form-control" >
                            </div>
                            <div class="col-md-6 mb-3">
                                <label><strong>State</strong></label>
                                <input type="text" name="state" class="form-control" >
                            </div>
                            <div class="col-md-6 mb-3">
                                <label><strong>Company Registration Number</strong></label>
                                <input type="text" name="rc" class="form-control" >
                            </div>
                            <div class="col-md-6 mb-3">
                                <label><strong>Company Whatsapp Number</strong></label>
                                <input type="text" name="whatsapp" class="form-control" >
                            </div>
                            <div class="col-md-6 mb-3">
                                <label><strong>Company GST Number</strong></label>
                                <input type="text" name="gst" class="form-control" >
                            </div>
                            <div class="col-md-6 mb-3">
                                <label><strong>Bank Name</strong></label>
                                <input type="text" name="bank" class="form-control" >
                            </div>
                            <div class="col-md-6 mb-3">
                                <label><strong>Company Account Number</strong></label>
                                <input type="text" name="account" class="form-control" >
                            </div>
                            <div class="col-md-6 mb-3">
                                <label><strong>Company IFSC</strong></label>
                                <input type="text" name="ifsc" class="form-control" >
                            </div>

                        </div>

                        <button type="submit" class="btn btn-success mt-3">Update</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
