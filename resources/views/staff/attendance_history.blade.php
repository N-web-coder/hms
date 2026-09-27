@extends('index')

@section('staffContent')
<div class="page-content">
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">My Attendance History</h5>
            </div>

            <div class="card-body">
                @if ($attendances->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Time In</th>
                                    <th>Time Out</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendances as $attendance)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d-m-Y') }}</td>
                                        <td>
                                            @if ($attendance->status == 'present')
                                                <span class="badge bg-success">Present</span>
                                            @elseif ($attendance->status == 'absent')
                                                <span class="badge bg-danger">Absent</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Leave</span>
                                            @endif
                                        </td>
                                        <td>{{ $attendance->time_in ?? '--' }}</td>
                                        <td>{{ $attendance->time_out ?? '--' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $attendances->links() }} {{-- pagination --}}
                    </div>
                @else
                    <p>No attendance records found.</p>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
