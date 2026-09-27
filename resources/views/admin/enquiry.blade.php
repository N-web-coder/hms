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


            <div class="card mb-3">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.enquiries') }}" class="row g-2">

                        <div class="col-md-3">
                            <input type="text" name="name" value="{{ request('name') }}" class="form-control"
                                placeholder="Search by Name">
                        </div>

                        <div class="col-md-3">
                            <select name="role" class="form-select">
                                <option value="">Select Role</option>
                                <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>Student
                                </option>
                                <option value="guest" {{ request('role') == 'guest' ? 'selected' : '' }}>Guest</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <input type="text" name="subject" value="{{ request('subject') }}" class="form-control"
                                placeholder="Search by Subject">
                        </div>

                        <div class="col-md-3">
                            <button type="submit" class="btn btn-outline-primary w-100">Filter</button>
                        </div>

                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Student & Staff Enquiries</h5>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Enquiry Date</th>
                                <th>Resolved On</th>
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($enquiries as $index => $enquiry)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $enquiry->user->name ?? 'Guest' }}</td>
                                    <td>{{ ucfirst($enquiry->role) }}</td>
                                    <td>{{ $enquiry->subject }}</td>
                                    <td>{{ $enquiry->message }}</td>
                                    <td>{{ \Carbon\Carbon::parse($enquiry->enquiry_raise)->format('d M Y') }}</td>
                                    <td>{{ $enquiry->enquiry_resolve ? \Carbon\Carbon::parse($enquiry->enquiry_resolve)->format('d M Y') : '-' }}
                                    </td>
                                    <td>
                                        {{ optional($enquiry->replies->last())->reply ?? 'No reply yet' }}
                                    </td>

                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#replyModal{{ $enquiry->id }}" title="Reply">
                                            <i class="fas fa-reply"></i>
                                        </button>

                                        <form action="{{ route('admin.enquiries.delete', $enquiry->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this enquiry?');"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-danger btn-sm mt-1" title="Delete Student">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                        <button type="button" class="btn btn-sm btn-outline-info mt-1" data-bs-toggle="modal"
                                            data-bs-target="#viewRepliesModal{{ $enquiry->id }}" title="View">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="replyModal{{ $enquiry->id }}" tabindex="-1"
                                            aria-labelledby="replyModalLabel{{ $enquiry->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="{{ route('admin.enquiries.reply', $enquiry->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="replyModalLabel{{ $enquiry->id }}">Reply to Enquiry
                                                                #{{ $enquiry->id }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="remarks{{ $enquiry->id }}"
                                                                    class="form-label">Remarks / Reply</label>
                                                                <textarea name="remarks" id="remarks{{ $enquiry->id }}" class="form-control" rows="4" required>{{ old('remarks') }}</textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="enquiry_resolve{{ $enquiry->id }}"
                                                                    class="form-label">Resolved On</label>
                                                                <input type="date" name="enquiry_resolve"
                                                                    id="enquiry_resolve{{ $enquiry->id }}"
                                                                    class="form-control"
                                                                    value="{{ old('enquiry_resolve', $enquiry->enquiry_resolve ? \Carbon\Carbon::parse($enquiry->enquiry_resolve)->format('Y-m-d') : '') }}">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn--outline-success">Save
                                                                Reply</button>

                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- View Replies Modal -->
                                        <div class="modal fade" id="viewRepliesModal{{ $enquiry->id }}" tabindex="-1"
                                            aria-labelledby="viewRepliesModalLabel{{ $enquiry->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">All Replies - Enquiry #{{ $enquiry->id }}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @if ($enquiry->replies->count() > 0)
                                                            <strong>{{ $enquiry->user->name ?? 'N/A' }}</strong>
                                                            @foreach ($enquiry->replies as $reply)
                                                                <div class="border rounded p-2 mb-2">
                                                                    <small
                                                                        class="text-muted float-end">{{ \Carbon\Carbon::parse($reply->replied_at)->format('d-m-Y h:i A') }}</small>

                                                                    {{ $reply->reply }}
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <p class="text-muted">No replies found.</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No enquiries found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
