@extends('index')
@section('adminContent')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                       New Invoice
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


                        <div class="container">
                            <h4 class="mb-3">Generate Student Invoice</h4>

                            <form method="POST" action="{{ route('invoice.store') }}">
                                @csrf
                                @method("POST")

                                <div class="mb-3">
                                    <label>Select Student</label>
                                    <select name="admission_id" class="form-control" required>
                                        <option value="">-- Select Student --</option>
                                        @foreach ($students as $student)
                                            <option value="{{ $student->admission->id }}">
                                                {{ $student->name }} ({{ $student->email }})
                                            </option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label>Fee Type</label>
                                    <select name="fee_type_id" class="form-control" required>
                                        <option value="">-- Product --</option>
                                        @foreach ($feeTypes as $type)
                                            <option value="{{ $type->id }}">{{ ucfirst($type->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label>Gross Amount</label>
                                    <input type="number" name="gross_amount" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label>Tax Amount</label>
                                    <input type="number" name="tax_amount" class="form-control" value="0">
                                </div>

                                <div class="mb-3">
                                    <label>Discount Amount</label>
                                    <input type="number" name="discount_amount" class="form-control" value="0">
                                </div>

                                <div class="mb-3">
                                    <label>Payment Mode</label>
                                    <select name="payment_mode" class="form-control" required>
                                        <option value="cash">Cash</option>
                                        <option value="upi">UPI</option>
                                        <option value="card">Card</option>
                                        <option value="bank">Bank Transfer</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Invoice Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="paid">paid</option>
                                        <option value="unpaid">unpaid</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label>Remarks</label>
                                    <textarea name="remarks" class="form-control" rows="2"></textarea>
                                </div>

                                <button type="submit" class="btn btn-outline-primary">Generate Invoice</button>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
