@extends('index')
@section('studentContent')
    <div class="page-content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Monthly Hostel & Mess Payments</h5>
                </div>

                <div class="card-body">
                    {{-- Success Message --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Payment Form --}}
                    <form method="POST" action="{{ route('student.monthly.pay') }}" class="row g-3 mb-4">
                        @csrf
                        <div class="text-wrap">
                        <div class="col-md-6">
                            <label>Month</label>
                            <input type="month" name="month" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label>Hostel Amount</label>
                            <input type="number" name="hostel_amount" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label>Mess Amount</label>
                            <input type="number" name="mess_amount" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label>Payment Mode</label>
                            <select name="payment_mode" class="form-control" required>
                                <option value="cash">Cash</option>
                                <option value="upi">UPI</option>
                                <option value="card">Card</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Reference No (optional)</label>
                            <input type="text" name="ref_no" class="form-control">
                        </div>

                        <div class="col-md-12 mt-3">
                            <button class="btn btn-success">Submit Monthly Payment</button>
                        </div>
                        </div>
                    </form>

                    {{-- Payment History --}}
                    <hr>
                    <h5>Payment History</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Hostel</th>
                                <th>Mess</th>
                                <th>Total</th>
                                <th>Mode</th>
                                <th>Ref No</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($payments as $pay)
                                <tr>
                                    <td>{{ $pay->month }}</td>
                                    <td>₹{{ $pay->hostel_amount }}</td>
                                    <td>₹{{ $pay->mess_amount }}</td>
                                    <td><strong>₹{{ $pay->hostel_amount + $pay->mess_amount }}</strong></td>
                                    <td>{{ ucfirst($pay->payment_mode) }}</td>
                                    <td>{{ $pay->ref_no ?? '-' }}</td>
                                    <td>{{ $pay->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No payments yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
@endsection
