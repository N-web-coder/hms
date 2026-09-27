@extends('index')

@section('staffContent')
    <div class="page-content">

        <div class="container-fluid">
            <div class="row">

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="">
                                    <p class="text-muted mb-0 ">
                                        Total
                                    </p>

                                    <h5 class="text-dark mt-2 mb-0">
                                        Present : <span class="text-success"></span>
                                        {{ $attendances->where('status', 'present')->count() }}
                                        Absent : <span class="text-danger"></span>
                                        {{ $attendances->where('status', 'absent')->count() }}
                                        Leave : <span class="text-warning"></span>
                                        {{ $attendances->where('status', 'leave')->count() }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div>
                                    <p class="text-muted mb-0 ">
                                        Today Attendance
                                    </p>

                                    @if ($todayStatus === 'absent')
                                        <h5 class="text-dark mt-2 mb-0">
                                            Absent
                                        </h5>
                                    @elseif($todayStatus === 'leave')
                                        <h5 class="text-dark mt-2 mb-0">
                                            Leave
                                        </h5>
                                    @elseif($todayStatus === 'present')
                                        @if ($attendanceIn && $attendanceOut)
                                            <h5 class="text-dark mt-2 mb-0">
                                                {{ date('h:i A', strtotime($attendanceIn)) }}
                                                -
                                                {{ date('h:i A', strtotime($attendanceOut)) }}
                                            </h5>
                                        @elseif($attendanceIn && !$attendanceOut)
                                            <h5 class="text-dark mt-2 mb-0">
                                                {{ date('h:i A', strtotime($attendanceIn)) }} - Not Out Yet
                                            </h5>
                                        @else
                                            <h5 class="text-dark mt-2 mb-0">
                                                Present
                                            </h5>
                                        @endif
                                    @else
                                        <h5 class="text-dark mt-2 mb-0">
                                            Not Marked
                                        </h5>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
