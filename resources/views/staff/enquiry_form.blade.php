@extends('index')

@section('staffContent')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Staff Enquiry Form</h5>
                </div>
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('staff.enquiry.submit') }}">
                        @csrf

                        <div class="mb-3">
                            <label>Subject</label>
                            <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" required
                                maxlength="255">
                            @error('subject')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Message</label>
                            <textarea name="message" class="form-control" rows="5" required>{{ old('message') }}</textarea>
                            @error('message')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button class="btn btn-primary" type="submit">Submit Enquiry</button>
                    </form>

                </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Your Past Enquiries</h5>
                </div>
                <div class="card-body">

                    @forelse($enquiries as $enquiry)
                        <div class="border rounded p-2 mb-2">
                            <p><strong>Subject:</strong> {{ $enquiry->subject }}</p>
                            <p><strong>Message:</strong> {{ $enquiry->message }}</p>
                            {{-- <p><strong>Status:</strong>
                                @if ($enquiry->remarks)
                                    <span class="text-success">Resolved</span> - {{ $enquiry->remarks }}
                                @else
                                    <span class="text-warning">Pending</span>
                                @endif
                            </p> --}}
                            <small class="text-muted">Submitted on {{ $enquiry->created_at->format('d M Y') }}</small>
                        </div>
                    @empty
                        <p class="text-muted">No enquiries submitted yet.</p>
                    @endforelse
                </div>
            </div>


        </div>
    </div>
@endsection
