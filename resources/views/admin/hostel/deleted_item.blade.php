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

            {{-- Deleted Beds --}}
            <div class="card mb-4">
                <div class="card-header bg-warning">
                    <strong>🛏️ Deleted Beds</strong>
                </div>
                <div class="card-body">
                    @if ($deletedBeds->count())
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Room ID</th>
                                    <th>Bed Number</th>
                                    <th>Deleted At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deletedBeds as $bed)
                                    <tr>
                                        <td>{{ $bed->room_id }}</td>
                                        <td>{{ $bed->bed_number }}</td>
                                        <td>{{ \Carbon\Carbon::parse($bed->deleted_at)->format('d-m-Y h:i A') }}</td>
                                        <td>
                                            <a href="{{ route('bed.restore', $bed->id) }}" onclick="return confirm('Want To Restore?')"
                                                class="btn btn-sm btn-outline-success" title="Restore"><i class="fas fa-trash-restore"></i></a>
                                            <a href="{{ route('bed.permanent.delete', $bed->id) }}"
                                                class="btn btn-sm btn-outline-danger" title="Delete"
                                                onclick="return confirm('Delete permanently?')"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No deleted beds found.</p>
                    @endif
                </div>
            </div>

            {{-- Deleted Rooms --}}
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <strong>🚪 Deleted Rooms</strong>
                </div>
                <div class="card-body">
                    @if ($deletedRooms->count())
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Room Number</th>
                                    <th>Total Beds</th>
                                    <th>Deleted At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deletedRooms as $room)
                                    <tr>
                                        <td>{{ $room->room_number }}</td>
                                        <td>{{ $room->total_bed }}</td>
                                        <td>{{ $room->deleted_at }}</td>
                                        <td>
                                            <a href="{{ route('room.restore', $room->id) }}"
                                                class="btn btn-sm btn-outline-success" title="Restore"><i class="fas fa-trash-restore"></i></a>
                                            <a href="{{ route('room.permanent.delete', $room->id) }}"
                                                class="btn btn-sm btn-outline-danger" title="Delete"
                                                onclick="return confirm('Delete permanently?')"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No deleted rooms found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
