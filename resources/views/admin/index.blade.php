@extends('index')

@section('adminContent')

    <div class="page-content">

        <!-- Start Container Fluid -->
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

            <!-- ========== Page Title Start ========== -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="mb-0">Dashboard</h4>

                    </div>
                </div>
            </div>
            <!-- ========== Page Title End ========== -->



            <div class="row">
                <!-- Card 1 -->
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <p class="text-muted mb-0 text-truncate">Total Students</p>
                                    <h3 class="text-dark mt-2 mb-0">{{ $totalStudents }}</h3>

                                </div>

                                <div class="col-6">
                                    <div class="ms-auto avatar-md bg-soft-primary rounded">
                                        <iconify-icon icon="solar:globus-outline"
                                            class="fs-32 avatar-title text-primary"></iconify-icon>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <p class="text-muted mb-0 text-truncate">Total Staff</p>
                                    <h3 class="text-dark mt-2 mb-0">{{ $totalStaffs }}</h3>
                                </div>

                                <div class="col-6">
                                    <div class="ms-auto avatar-md bg-soft-primary rounded">
                                        <iconify-icon icon="solar:users-group-two-rounded-broken"
                                            class="fs-32 avatar-title text-primary"></iconify-icon>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <p class="text-muted mb-0 text-truncate">Total Room</p>
                                    <h3 class="text-dark mt-2 mb-0">{{ $totalRoom }}</h3>
                                </div>

                                <div class="col-6">
                                    <div class="ms-auto avatar-md bg-soft-primary rounded">
                                        <iconify-icon icon="solar:cart-5-broken"
                                            class="fs-32 avatar-title text-primary"></iconify-icon>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <p class="text-muted mb-0 text-truncate">Total Bed </p>
                                    <h3 class="text-dark mt-2 mb-0">{{ $totalBeds }}</h3>
                                </div>

                                <div class="col-6">
                                    <div class="ms-auto avatar-md bg-soft-primary rounded">
                                        <iconify-icon icon="solar:pie-chart-2-broken"
                                            class="fs-32 avatar-title text-primary"></iconify-icon>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <p class="text-muted mb-0 text-truncate">Occupy Bed</p>
                                    <h3 class="text-dark mt-2 mb-0">{{ $totalBedOccupy }}</h3>
                                </div>

                                <div class="col-6">
                                    <div class="ms-auto avatar-md bg-soft-primary rounded">
                                        <iconify-icon icon="solar:pie-chart-2-broken"
                                            class="fs-32 avatar-title text-primary"></iconify-icon>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <p class="text-muted mb-0 text-truncate">Empty Bed</p>
                                    <h3 class="text-dark mt-2 mb-0">{{ $totalBedEmpty }}</h3>
                                </div>

                                <div class="col-6">
                                    <div class="ms-auto avatar-md bg-soft-primary rounded">
                                        <iconify-icon icon="solar:pie-chart-2-broken"
                                            class="fs-32 avatar-title text-primary"></iconify-icon>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>





    @endsection
