@extends('index')

@section('adminContent')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Student Payment History</h5>
                </div>

                <div class="card-body">
                    <form method="GET" class="row g-3 mb-4">
                        <div class="col-md-1">
                            <label>Month</label>
                            <select name="month" class="form-control">
                                <option value="">All</option>
                                @foreach (range(1, 12) as $m)
                                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-1">
                            <label>Year</label>
                            <select name="year" class="form-control">
                                <option value="">All</option>
                                @foreach (range(date('Y') - 5, date('Y') + 1) as $y)
                                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                        {{ $y }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-1">
                            <label>Student</label>
                            <select name="student_id" class="form-control">
                                <option value="">All</option>
                                @foreach ($students as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ request('student_id') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-1 d-flex align-items-end">
                            <button class="btn btn-outline-primary w-100" type="submit">Filter</button>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Student</th>
                                    <th>Amount</th>
                                    <th>Payment Mode</th>
                                    <th>Ref No</th>
                                    <th>Date</th>
                                    <th>Accepted By</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $index => $payment)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $payment->user->name ?? 'N/A' }}</td>
                                        <td>₹{{ number_format($payment->amount) }}</td>
                                        <td>{{ $payment->payment_mode }}</td>
                                        <td>{{ $payment->ref_no ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($payment->date)->format('d M Y') }}</td>
                                        <td>{{ $payment->accepted_by }}</td>
                                        <td>
                                            <a href="{{ route('admin.student.payment.pdf', $payment->id) }}"
                                                class="btn btn-sm btn-outline-primary" title="Download" target="_blank">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
