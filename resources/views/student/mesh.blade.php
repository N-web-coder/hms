@extends('index')
@section('studentContent')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Mesh Subscription
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

                    @if ($mesh)
                        <p><strong>Type:</strong> {{ ucfirst(str_replace('_', ' ', $mesh->subscription)) }}</p>
                        <p><strong>Meal:</strong> {{ ucfirst($mesh->meal_type) }}</p>
                        <p><strong>Start:</strong> {{ $mesh->mesh_start }}</p>
                        <p><strong>End:</strong> {{ $mesh->mesh_end ?? 'Running' }}</p>
                        <p><strong>Remarks:</strong> {{ $mesh->remarks ?? 'N/A' }}</p>
                    @else
                        <p>No mesh subscription found.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>


@endsection
