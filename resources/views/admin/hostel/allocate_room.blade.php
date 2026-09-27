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

            <div class="card p-3">
                <h4>Room Bed Allocation</h4>
                <form method="GET" class="row mb-4">
                    <div class="col-md-4">
                        <select name="student_id" class="form-control" required>
                            <option value="">-- Select Student --</option>
                            @foreach ($students as $stu)
                                <option value="{{ $stu->id }}" {{ $filterStudent == $stu->id ? 'selected' : '' }}>
                                    {{ $stu->user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-outline-info w-50">Filter</button>
                    </div>
                </form>

                @if ($filterStudent)
                    @foreach ($rooms as $room)
                        <div class="card mb-4 border border-primary">
                            <div
                                class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 rounded-top shadow-sm">
                                <h5 class="mb-0 fw-bold">Room {{ $room->room_number }}</h5>

                                @if ($room->beds->where('status', '!=', 'empty')->count() == 0)
                                    <form action="{{ route('room.delete') }}" method="POST" class="position-absolute mt-4"
                                        onsubmit="return confirm('Are you sure you want to delete this room?');">
                                        @csrf
                                        <input type="hidden" name="room_id" value="{{ $room->id }}">
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            style="padding: 2px 6px;" title="Delete Room">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif


                                <div class="d-flex align-items-center gap-3">


                                    <span class="text-black py-2 mb-0 fw-bold">Total Beds:
                                        <strong>{{ $room->beds->count() }}</strong>
                                    </span>

                                    <form action="{{ route('bed.add.form', $room->id) }}" method="POST"
                                        class="d-flex align-items-center gap-1 m-0">
                                        @csrf
                                        <input type="text" name="bed_number" id="bed_number" required
                                            class="form-control form-control-sm" placeholder="Bed number"
                                            style="max-width: 110px; padding: 2px 6px; font-size: 13px;">

                                        <button type="submit" class="btn btn-sm btn-outline-secondary"
                                            style="padding: 5px 15px;" title="Add Bed">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </form>


                                </div>
                            </div>



                            <div class="card-body d-flex flex-wrap gap-3">
                                @foreach ($room->beds as $bed)
                                    @php
                                        $allocated = $bed->allocation ?? null;
                                        $isOccupied = $bed->status === 'occupy';
                                        $isAssignedToSelectedStudent =
                                            $allocated && $allocated->admission_id == $filterStudent;
                                    @endphp

                                    <div class="card p-2" style="width: 200px; ">

                                        @if ($bed->status == 'empty')
                                            <form action="{{ route('bed.delete') }}" method="POST" style="display:inline;"
                                                onsubmit="return confirm('Are you sure you want to delete this empty bed?');">
                                                @csrf
                                                <input type="hidden" name="bed_id" value="{{ $bed->id }}">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0">Sheet: {{ $bed->bed_number }}</h6>
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        style="padding: 2px 6px;" title="Delete Sheet">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        @else
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0">Sheet: {{ $bed->bed_number }}</h6>
                                                <button class="btn btn-sm btn-outline-secondary" style="padding: 2px 6px;" title="lock">
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            </div>
                                        @endif


                                        <p>Status:
                                            <span class="badge {{ $isOccupied ? 'text-danger' : 'text-success' }}">
                                                {{ $isOccupied ? 'Occupied' : 'Empty' }}
                                            </span>

                                        </p>

                                        @if ($isOccupied)
                                            <p><strong>{{ $allocated->admission->user->name ?? 'N/A' }}</strong></p>

                                            @if ($isAssignedToSelectedStudent)
                                                {{-- Remove allocation --}}
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('student.full.details', $allocated->admission->id) }}"
                                                        class="btn btn-sm btn-outline-info p-1"
                                                        style="width: 80px; height: 32px;" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <form action="{{ route('room.remove.allocate') }}" method="POST"
                                                        onsubmit="return confirm('Are you sure you want to remove this student from the bed?');">
                                                        @csrf
                                                        <input type="hidden" name="bed_id" value="{{ $bed->id }}">
                                                        <button type="submit" class="btn btn-sm btn-outline-danger p-1"
                                                            style="width: 80px; height: 32px; margin-left:5px;"
                                                            title="Admission Cancel">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="text-muted small">Allocated to another student</span>
                                            @endif
                                        @else
                                            {{-- Allocate only if student selected --}}

                                            <form action="{{ route('room.allocate') }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to allocate this bed to the selected student?');">
                                                @csrf
                                                <input type="hidden" name="bed_id" value="{{ $bed->id }}">
                                                <input type="hidden" name="admission_id" value="{{ $filterStudent }}">

                                                <button
                                                    class="btn btn-sm btn-outline-success w-100 d-flex align-items-center justify-content-center gap-1"
                                                    style="padding: 6px 10px; font-size: 14px;" title="Allocate Bed">
                                                    <i class="fas fa-check-circle"></i> <span>Allocate</span>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-warning">Please select a student to begin allocation.</div>
                @endif

            </div>
        </div>
    </div>
@endsection
