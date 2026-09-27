@extends('index')

@section('adminContent')
    <div class="page-content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="card-title mb-0">Staff Salary Payment History</h5>
                    <form method="GET" action="{{ route('admin.staff.salary.history') }}" class="row g-2 align-items-center">
                        <div class="col">
                            <select name="staff_id" class="form-select">
                                <option value="">-- Select Staff --</option>
                                @foreach ($staffList as $staff)
                                    <option value="{{ $staff->id }}"
                                        {{ request('staff_id') == $staff->id ? 'selected' : '' }}>
                                        {{ $staff->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <select name="month" class="form-select">
                                <option value="">-- Month --</option>
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col">
                            <select name="year" class="form-select">
                                <option value="">-- Year --</option>
                                @for ($y = now()->year; $y >= 2020; $y--)
                                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-outline-primary">Filter</button>
                        </div>
                    </form>
                </div>

                <div class="card-body table-responsive">
                    @if ($salaries->count())
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Id</th>
                                    <th>Staff</th>
                                    <th>Date</th>
                                    <th>Gross</th>
                                    <th>Deduction</th>
                                    <th>Net</th>
                                    <th>Action</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($salaries as $key => $salary)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $salary->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($salary->date)->format('d M Y') }}</td>
                                        <td>₹{{ $salary->gross_amount }}</td>
                                        <td>₹{{ $salary->deduct_amount }}</td>
                                        <td><strong>₹{{ $salary->net_amount }}</strong></td>
                                        <td>
                                            <form method="POST" action="{{ route('staff.salary.pay') }}">
                                                @csrf
                                                @method('POST')
                                                <input type="hidden" name="user_id" value="{{ $salary->user_id }}">
                                                <input type="hidden" name="present_days"
                                                    value="{{ $salary->present_days ?? 0 }}">
                                                <input type="hidden" name="date" value="{{ $salary->date }}">
                                                <button class="btn btn-sm btn-outline-primary"
                                                    onclick="return confirm('Are you sure to mark salary as paid?')">Pay
                                                    Now</button>
                                            </form>

                                        </td>
                                        <td>
                                            <a href="{{ route('admin.staff.payment.pdf', $salary->id) }}"
                                                class="btn btn-sm btn-outline-primary" title="Download" target="_blank">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info">No salary records found.</div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
