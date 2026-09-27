@extends('index')

@section('staffContent')

    <div class="page-content">
        <div class="container-fluid">

            <div class="card mb-3">
                <div class="card-header">
                    <h5>My Salary Payment History</h5>
                </div>

                <div class="card-body">

                    <form method="GET" action="{{ route('staff.payroll') }}" class="row g-3 mb-4">
                        <div class="col-md-2">
                            <label>From</label>
                            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                        </div>
                        <div class="col-md-2">
                            <label>To</label>
                            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                        </div>
                        <div class="col-md-2 align-self-end">
                            <button class="btn btn-primary">Filter</button>
                            <a href="{{ route('staff.payroll') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </form>

                    @if ($payments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Gross</th>
                                        <th>Deductions</th>
                                        <th>Net</th>
                                        <th>Bank</th>
                                        <th>Account No.</th>
                                        <th>IFSC</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $payment)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($payment->date)->format('d-m-Y') }}</td>
                                            <td>₹{{ number_format($payment->gross_amount, 2) }}</td>
                                            <td>₹{{ number_format($payment->deduct_amount, 2) }}</td>
                                            <td>₹{{ number_format($payment->net_amount, 2) }}</td>
                                            <td>{{ $payment->account->bank_name ?? '-' }}</td>
                                            <td>{{ $payment->account->account ?? '-' }}</td>
                                            <td>{{ $payment->account->ifsc_code ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- {{ $payments->withQueryString()->links() }} --}}
                            {{ $payments->appends(request()->query())->links() }}
                        </div>
                    @else
                        <p>No salary records found.</p>
                    @endif

                </div>
            </div>

        </div>
    </div>

@endsection
