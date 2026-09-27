@extends('index')

@section('staffContent')

    <div class="page-content">
        <div class="container-fluid">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">My Admissions</h4>
                    <p class="text-muted mb-0">
                        Students admitted by you
                    </p>
                </div>

                <a href="{{ route('staff.admission.form') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i>
                    New Admission
                </a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    @if ($admissions->count())
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Student</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Parent Mobile</th>
                                        <th>DOB</th>
                                        <th>Gender</th>
                                        <th>Admission Date</th>
                                        <th>Address</th>
                                        <th>Pincode</th>
                                        <th>Aadhar</th>
                                        <th>PAN</th>
                                        <th>Room</th>
                                        <th>Bed</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($admissions as $admission)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>
                                                <strong>
                                                    {{ $admission->user->name ?? '-' }}
                                                </strong>
                                            </td>
                                            <td>
                                                {{ $admission->user->email ?? '-' }}
                                            </td>
                                            <td>
                                                {{ $admission->user->mobile ?? '-' }}
                                            </td>
                                            <td>
                                                {{ $admission->parent_number ?? '-' }}
                                            </td>
                                            <td>
                                                {{ $admission->dob ? \Carbon\Carbon::parse($admission->dob)->format('d M Y') : '-' }}
                                            </td>

                                            <td>
                                                {{ ucfirst($admission->gender ?? '-') }}
                                            </td>
                                            <td>
                                                {{ $admission->admission_date ? \Carbon\Carbon::parse($admission->admission_date)->format('d M Y') : '-' }}
                                            </td>
                                            <td>
                                                {{ $admission->address ?? '-' }}
                                            </td>
                                            <td>
                                                {{ $admission->pincode ?? '-' }}
                                            </td>
                                            <td>
                                                {{ $admission->adhar_number ?? '-' }}
                                            </td>
                                            <td>
                                                {{ $admission->pan_number ?? '-' }}
                                            </td>
                                            <td>
                                                {{ $admission->room_id ?? '-' }}
                                            </td>
                                            <td>
                                                {{ $admission->bed_id ?? '-' }}
                                            </td>

                                            <td>
                                                @if ($admission->status === 'approved')
                                                    <span class="badge bg-success">
                                                        Approved
                                                    </span>
                                                @elseif($admission->status === 'pending')
                                                    <span class="badge bg-warning text-dark">
                                                        Pending
                                                    </span>
                                                @elseif($admission->status === 'rejected')
                                                    <span class="badge bg-danger">
                                                        Rejected
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        {{ ucfirst($admission->status ?? 'N/A') }}
                                                    </span>
                                                @endif
                                            </td>

                                            <td>
                                                {{ $admission->created_at ? $admission->created_at->format('d M Y h:i A') : '-' }}
                                            </td>

                                            <td class="d-flex gap-1">
                                            <a href="{{ route('student.full.details', $admission->user_id) }}"
                                                class="btn btn-outline-info btn-sm" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a href="{{ route('student.edit', $admission->user_id) }}"
                                                class="btn btn-outline-primary btn-sm" title="Edit Student">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('student.delete', $admission->user_id) }}" method="POST"
                                                style="display:inline-block;"
                                                onsubmit="return confirm('Are you sure you want to delete this student?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger btn-sm" title="Delete Student">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-person-x fs-1 text-muted"></i>

                            <h5 class="mt-3">
                                No Admissions Found
                            </h5>

                            <p class="text-muted">
                                You have not submitted any student admissions yet.
                            </p>

                            <a href="{{ route('staff.admission.form') }}" class="btn btn-primary">
                                Add Admission
                            </a>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>

@endsection
