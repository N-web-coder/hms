@extends('index')

@section('adminContent')
    <div class="page-content container-fluid mr-5">
        <div class="row g-4"> {{-- g-4 gives space between rows --}}

            {{-- Personal Info --}}
            <div  style="width: 1110px">
                <div class="card border-primary shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <strong>Personal Information</strong>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $admission->user->name }}</p>
                        <p><strong>Email:</strong> {{ $admission->user->email }}</p>
                        <p><strong>Mobile:</strong> {{ $admission->user->mobile }}</p>
                        <p><strong>Parent Mobile:</strong> {{ $admission->parent_number }}</p>
                        <p><strong>DOB:</strong> {{ $admission->dob }}</p>
                        <p><strong>Address:</strong> {{ $admission->address }}</p>
                        <p><strong>Pincode:</strong> {{ $admission->pincode }}</p>
                        <p><strong>Gender:</strong> {{ ucfirst($admission->gender) }}</p>
                    </div>
                </div>
            </div>

            {{-- Documents --}}
            <div style="width: 1110px">
                <div class="card border-info shadow-sm">
                    <div class="card-header bg-info text-white">
                        <strong>Documents</strong>
                    </div>
                    <div class="card-body">
                        <p><strong>Aadhaar:</strong> {{ $admission->adhar_number }}</p>
                        <p><strong>PAN:</strong> {{ $admission->pan_number }}</p>
                        <p><strong>Photo:</strong><br>
                            <img src="{{ asset($admission->photo) }}" width="100" class="rounded border">
                        </p>
                    </div>
                </div>
            </div>

            {{-- Room Allocation --}}
            <div style="width: 1110px">
                <div class="card border-success shadow-sm">
                    <div class="card-header bg-success text-white">
                        <strong>Room Allocation</strong>
                    </div>
                    <div class="card-body">
                        @if ($admission->roomAllocation)
                            <p><strong>Room No:</strong> {{ $admission->roomAllocation->bed->room->room_number ?? 'N/A' }}</p>
                            <p><strong>Bed No:</strong> {{ $admission->roomAllocation->bed->bed_number ?? 'N/A' }}</p>
                            <p><strong>Allocation Date:</strong> {{ $admission->roomAllocation->allocation_date }}</p>
                        @else
                            <p class="text-muted">Not allocated yet.</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Mesh Subscription --}}
            <div style="width: 1110px">
                <div class="card border-warning shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <strong>Mesh Subscription</strong>
                    </div>
                    <div class="card-body">
                        @if ($admission->mesh)
                            <p><strong>Subscription:</strong> {{ ucfirst(str_replace('_', ' ', $admission->mesh->subscription)) }}</p>
                            <p><strong>Meal Type:</strong> {{ ucfirst(str_replace('_', ' ', $admission->mesh->meal_type)) }}</p>
                            <p><strong>Start:</strong> {{ $admission->mesh->mesh_start }}</p>
                            <p><strong>End:</strong> {{ $admission->mesh->mesh_end }}</p>
                        @else
                            <p class="text-muted">No mesh subscription found.</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Payments --}}
            <div style="width: 1110px">
                <div class="card border-dark shadow-sm">
                    <div class="card-header bg-dark text-dark">
                        <strong >Admission Payments</strong>
                    </div>
                    <div class="card-body">
                        @forelse($admission->payments as $pay)
                            <div class="mb-2 border-bottom pb-2">
                                <p>
                                    ₹{{ number_format($pay->amount) }} on {{ $pay->date }} via {{ $pay->payment_mode }}
                                    <br>
                                    <small>Ref: {{ $pay->ref_no ?? 'N/A' }} | Accepted by: {{ $pay->accepted_by }}</small>
                                </p>
                            </div>
                        @empty
                            <p class="text-muted">No payments found.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
