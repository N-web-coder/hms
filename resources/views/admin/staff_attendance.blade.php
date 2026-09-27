@extends('index')

@section('adminContent')
    <div class="page-content">
        <div class="container-fluid">

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

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="card-title mb-0">Staff Attendance History</h5>
                    <form method="GET" action="{{ route('admin.staff.attendance.history') }}"
                        class="row g-2 align-items-center">
                        <div class="col">
                            <select name="staff_id" class="form-select" required>
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
                                    <option value="{{ $m }}" {{ $selectedMonth == $m ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col">
                            <select name="year" class="form-select">
                                <option value="">-- Year --</option>
                                @for ($y = now()->year; $y >= 2020; $y--)
                                    <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-auto">
                            <button type="submit" class="btn btn-outline-primary">Filter</button>
                        </div>
                    </form>

                </div>

                <div class="card-body">
                    @if ($attendances->isNotEmpty())
                        <h6>Showing attendance for: <strong>{{ $attendances->first()->name }}</strong></h6>
                        <div class="table-responsive mt-2">
                            <table class="table table-bordered table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Time In</th>
                                        <th>Time Out</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attendances as $index => $a)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($a->date)->format('d M Y') }}</td>
                                            <td>
                                                @if ($a->status == 'present')
                                                    <span class="badge text-success">Present</span>
                                                @elseif ($a->status == 'absent')
                                                    <span class="badge text-danger">Absent</span>
                                                @else
                                                    <span class="badge text-warning text-dark">Leave</span>
                                                @endif
                                            </td>
                                            <td>{{ $a->time_in ?? '—' }}</td>
                                            <td>{{ $a->time_out ?? '—' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @elseif($selectedStaffId)
                        <div class="alert alert-info">No attendance data found for this staff.</div>
                    @else
                        <div class="alert alert-secondary">Select a staff to view their attendance history.</div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
