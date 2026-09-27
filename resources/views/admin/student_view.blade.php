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
                <div class="card-header">
                    <h5 class="card-title">Student List</h5>

                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-centered">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Mobile</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Photo</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($students as $key => $student)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->mobile }}</td>
                                        <td>{{ ucfirst($student->gender) }}</td>
                                        <td>{{ $student->address }}</td>
                                        <td>
                                            <img src="{{ asset('storage/' . $student->photo) }}" width="60"
                                                height="60" alt="Photo">
                                        </td>
                                        <td>
                                            @if ($student->status == 'inactive')
                                                <form method="POST"
                                                    action="{{ route('admin.admission.approve', $student->id) }}">
                                                    @csrf
                                                    <button class="btn btn-outline-success btn-sm mb-1"
                                                        title="Approve">Approve Admission</button>
                                                </form>
                                            @else
                                                <span class="badge text-success mb-2">Active</span>
                                            @endif
                                        </td>

                                        <td class="d-flex gap-1">
                                            <!-- View Button -->
                                            <a href="{{ route('student.full.details', $student->user_id) }}"
                                                class="btn btn-outline-info btn-sm" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- Edit Button -->
                                            <a href="{{ route('student.edit', $student->user_id) }}"
                                                class="btn btn-outline-primary btn-sm" title="Edit Student">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('student.delete', $student->user_id) }}" method="POST"
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
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No students found.</td>
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
