@extends('index')
@section('studentContent')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Admission Payments
                    </h5>
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



                    @forelse($payments as $pay)
                        <div class="border p-2 mb-2">
                            ₹{{ $pay->amount }} on {{ $pay->date }} via {{ $pay->payment_mode }}<br>
                            Ref: {{ $pay->ref_no ?? 'N/A' }} | Accepted By: {{ $pay->accepted_by }}
                        </div>
                    @empty
                        <p>No payment records found.</p>
                    @endforelse







                </div>
            </div>

        </div>
    </div>


@endsection
