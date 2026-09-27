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
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Staff List</h5>
                    <a href="{{ route('admin.admission.form') }}" class="btn btn-outline-success btn-sm">Add Staff</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Parent No</th>
                                    <th>DOB</th>
                                    <th>Gender</th>
                                    <th>Address</th>
                                    <th>Pincode</th>
                                    <th>Aadhaar</th>
                                    <th>PAN</th>
                                    <th>Photo</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($staffs as $key => $staff)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $staff->name }}</td>
                                        <td>{{ $staff->email }}</td>
                                        <td>{{ $staff->mobile }}</td>
                                        <td>{{ $staff->parent_number ?? 'N/A' }}</td>
                                        <td>{{ $staff->dob ?? 'N/A' }}</td>
                                        <td>{{ ucfirst($staff->gender ?? 'N/A') }}</td>
                                        <td>{{ $staff->address ?? 'N/A' }}</td>
                                        <td>{{ $staff->pincode ?? 'N/A' }}</td>
                                        <td>{{ $staff->adhar_number ?? 'N/A' }}</td>
                                        <td>{{ $staff->pan_number ?? 'N/A' }}</td>
                                        <td>
                                            @if ($staff->photo)
                                                <img src="{{ asset($staff->photo) }}" width="60" height="60"
                                                    alt="Photo">
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if ($staff->status == 'inactive')
                                                <form method="POST"
                                                    action="{{ route('admin.staff.admission.approve', $staff->id) }}">
                                                    @csrf
                                                    <button class="btn btn-outline-success btn-sm mb-1"
                                                        title="Approve">Approve Admission</button>
                                                </form>
                                            @else
                                                <span class="badge text-success mb-2">Active</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('staff.edit', $staff->user_id) }}"
                                                class="btn btn-outline-primary btn-sm" title="Edit Student">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('staff.destroy', $staff->user_id) }}" method="POST"
                                                style="display:inline-block;"
                                                onsubmit="return confirm('Are you sure you want to delete this staff member?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger btn-sm" title="Delete Student">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="14" class="text-center">No staff found.</td>
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
