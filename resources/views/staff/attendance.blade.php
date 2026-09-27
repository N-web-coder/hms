@extends('index')

@section('staffContent')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Mark Staff Attendance ({{ date('d-m-Y') }})</h5>
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

                    <form method="POST" action="{{ route('staff.attendance.store') }}">
                        @csrf

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Time In</th>
                                        <th>Time Out</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $staff->name }}</td>
                                        <td>
                                            <select name="attendance[{{ $staff->id }}][status]" class="form-select">
                                                <option value="present">Present</option>
                                                <option value="absent">Absent</option>
                                                <option value="leave">Leave</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="time" name="attendance[{{ $staff->id }}][time_in]"
                                                class="form-control" />
                                        </td>
                                        <td>
                                            <input type="time" name="attendance[{{ $staff->id }}][time_out]"
                                                class="form-control" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        {{-- <button type="submit" class="btn btn-primary">Submit Attendance</button> --}}
                        <button type="submit" class="btn btn-primary" {{ $alreadyMarked ? 'disabled' : '' }}>
                            {{ $alreadyMarked ? 'Already Marked' : 'Submit Attendance' }}
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
