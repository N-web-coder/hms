<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title Meta -->
    <meta charset="utf-8">
    <title>Hostel Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Darkone: An advanced, fully responsive admin dashboard template packed with features to streamline your analytics and management needs.">
    <meta name="author" content="StackBros">
    <meta name="keywords" content="Darkone, admin dashboard, responsive template, analytics, modern UI, management tools">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="#ffffff">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">


    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Google Font Family link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="../css2?family=Play:wght@400;700&display=swap" rel="stylesheet">

    <!-- Vendor css -->
    <link href="{{ asset('assets/css/vendor.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Icons css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">

    <!-- App css -->
    <link href="{{ asset('assets/css/style.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Theme Config js -->
    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>

    <!-- START Wrapper -->
    <div class="app-wrapper">

        <!-- Topbar Start -->
        <header class="app-topbar">
            <div class="container-fluid">
                <div class="navbar-header">
                    <div class="d-flex align-items-center gap-2">
                        <!-- Menu Toggle Button -->
                        <div class="topbar-item">
                            <button type="button" class="button-toggle-menu topbar-button">
                                <iconify-icon icon="solar:hamburger-menu-outline"
                                    class="fs-24 align-middle"></iconify-icon>
                            </button>
                        </div>

                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <!-- Theme Color (Light/Dark) -->
                        <div class="topbar-item">
                            <button type="button" class="topbar-button" id="light-dark-mode">
                                <iconify-icon icon="solar:moon-outline"
                                    class="fs-22 align-middle light-mode"></iconify-icon>
                                <iconify-icon icon="solar:sun-2-outline"
                                    class="fs-22 align-middle dark-mode"></iconify-icon>
                            </button>
                        </div>

                        <!-- Notification -->


                        <!-- User -->
                        <div class="dropdown topbar-item">
                            <a type="button" class="topbar-button" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    <img class="rounded-circle" width="32"
                                        src="{{ Auth::user()->profile_photo ?? asset('assets/images/users/avatar-1.jpg') }}"
                                        alt="avatar-3">
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->

                                <div class="text-center">
                                    <h6 class="dropdown-header mb-1">Welcome!</h6>
                                    <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                                    <small>{{ Auth::user()->email }}</small>
                                </div>

                                <div class="dropdown-divider my-1"></div>

                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <iconify-icon icon="solar:logout-3-outline"
                                        class="align-middle me-2 fs-18"></iconify-icon>
                                    <span class="align-middle">Logout</span>
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Topbar End -->

        {{-- -------------------------- admin login sidebar ------------------ --}}
        @if (Auth::check() && Auth::user()->type == 'admin')
            <div class="app-sidebar">

                <div class="logo-box">
                    <a href="index.html" class="logo-dark">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" class="logo-sm" alt="logo sm">
                        <img src="{{ asset('assets/images/logo-dark.png') }}" class="logo-lg" alt="logo dark">
                    </a>

                    <a href="index.html" class="logo-light">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" class="logo-sm" alt="logo sm">
                        <img src="{{ asset('assets/images/logo-light.png') }}" class="logo-lg" alt="logo light">
                    </a>
                </div>

                <div class="scrollbar" data-simplebar="">

                    <ul class="navbar-nav" id="navbar-nav">

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.show') }}">
                                <span class="nav-icon">
                                    <iconify-icon icon="mingcute:home-3-line"></iconify-icon>
                                </span>
                                <span class="nav-text"> Dashboard </span>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.admission.form') }}">
                                <span class="nav-icon">
                                    <iconify-icon icon="mingcute:leaf-line"></iconify-icon>
                                </span>
                                <span class="nav-text"> New Admission </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-arrow" href="#sidebarError" data-bs-toggle="collapse"
                                role="button" aria-expanded="false" aria-controls="sidebarError">
                                <span class="nav-icon">
                                    <iconify-icon icon="mingcute:bug-line"></iconify-icon>
                                </span>
                                <span class="nav-text">Student</span>
                            </a>
                            <div class="collapse" id="sidebarError">
                                <ul class="nav sub-navbar-nav">

                                    <li class="sub-nav-item">
                                        <a class="sub-nav-link" href="{{ route('admin.student.show') }}">View</a>
                                    </li>
                                    <li class="sub-nav-item">
                                        <a class="sub-nav-link" href="{{ route('admin.student.payments') }}">Payments
                                            History</a>
                                    </li>

                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-arrow" href="#sidebarForms" data-bs-toggle="collapse"
                                role="button" aria-expanded="false" aria-controls="sidebarForms">
                                <span class="nav-icon">
                                    <iconify-icon icon="mingcute:box-line"></iconify-icon>
                                </span>
                                <span class="nav-text"> Staff </span>
                            </a>
                            <div class="collapse" id="sidebarForms">
                                <ul class="nav sub-navbar-nav">

                                    <li class="sub-nav-item">
                                        <a class="sub-nav-link" href="{{ route('admin.staff.show') }}">view</a>
                                    </li>
                                    <li class="sub-nav-item">
                                        <a class="sub-nav-link" href="{{ route('admin.staff.salary.history') }}">payment
                                            History</a>
                                    </li>
                                    <li class="sub-nav-item">
                                        <a href="{{ route('admin.staff.attendance.history') }}"
                                            class="sub-nav-link">View Attendance History</a>

                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-arrow" href="#sidebarLayouts" data-bs-toggle="collapse"
                                role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                                <span class="nav-icon">
                                    <iconify-icon icon="mingcute:layout-line"></iconify-icon>
                                </span>
                                <span class="nav-text"> Hostel </span>
                            </a>
                            <div class="collapse" id="sidebarLayouts">
                                <ul class="nav sub-navbar-nav">
                                    <li class="sub-nav-item">
                                        <a class="sub-nav-link" href="{{ route('admin.hostel.newroom') }}">Add
                                            Room</a>
                                    </li>
                                    <li class="sub-nav-item">
                                        <a class="sub-nav-link"
                                            href="{{ route('admin.hostel.deleted.items') }}">Deleted
                                            Items</a>

                                    </li>

                                    <li class="sub-nav-item">
                                        <a class="sub-nav-link" href="{{ route('room.allocation') }}">Room
                                            Info</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-arrow" href="#sidebarAuthentication" data-bs-toggle="collapse"
                                role="button" aria-expanded="false" aria-controls="sidebarAuthentication">
                                <span class="nav-icon">
                                    <iconify-icon icon="mingcute:user-3-line"></iconify-icon>
                                </span>
                                <span class="nav-text">Enquiry</span>
                            </a>
                            <div class="collapse" id="sidebarAuthentication">
                                <ul class="nav sub-navbar-nav">

                                    <li class="sub-nav-item">
                                        <a class="sub-nav-link" href="{{ route('admin.enquiries') }}">View</a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                        <li class="nav-item" style="margin:10px 17px; font-size:1.0rem;">
                            <span class="nav-icon">
                                <iconify-icon icon="mingcute:box-line"></iconify-icon>
                            </span>
                            <a class="sub-nav-link" href="{{ route('invoice.create') }}" style="margin-left:8px;">
                                Invoice</a>
                        </li>
                        <li class="nav-item" style="margin:10px 17px; font-size:1.0rem;">

                            <span class="nav-icon">
                                <iconify-icon icon="mingcute:dribbble-line"></iconify-icon>
                            </span>

                            <a class="sub-nav-link" href="{{ route('admin.companyInfo') }}"
                                style="margin-left:8px;">Company Info</a>
                        </li>

                    </ul>
                </div>
            </div>
            @yield('adminContent')



            {{-- ----------------------------------- staff login sidebar --------------------------- --}}
        @elseif (Auth::check() && Auth::user()->type == 'staff')
            <div class="app-sidebar">

                <div class="logo-box">
                    <a href="index.html" class="logo-dark">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" class="logo-sm" alt="logo sm">
                        <img src="{{ asset('assets/images/logo-dark.png') }}" class="logo-lg" alt="logo dark">
                    </a>

                    <a href="index.html" class="logo-light">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" class="logo-sm" alt="logo sm">
                        <img src="{{ asset('assets/images/logo-light.png') }}" class="logo-lg" alt="logo light">
                    </a>
                </div>

                <div class="scrollbar" data-simplebar="">

                    <ul class="navbar-nav" id="navbar-nav">

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('staff.show') }}">
                                <span class="nav-icon">
                                    <iconify-icon icon="mingcute:home-3-line"></iconify-icon>
                                </span>
                                <span class="nav-text"> Dashboard </span>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('staff.admission.form') }}">
                               <span class="nav-icon">
                                    <iconify-icon icon="mingcute:leaf-line"></iconify-icon>
                                </span>
                                <span class="nav-text"> New Admission </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('staff.admissions') }}">
                               <span class="nav-icon">
                                    <iconify-icon icon="mingcute:leaf-line"></iconify-icon>
                                </span>
                                <span class="nav-text"> Students Lists </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-arrow" href="#sidebarForms" data-bs-toggle="collapse"
                                role="button" aria-expanded="false" aria-controls="sidebarForms">
                                <span class="nav-icon">
                                    <iconify-icon icon="mingcute:box-line"></iconify-icon>
                                </span>
                                <span class="nav-text"> Staff </span>
                            </a>
                            <div class="collapse" id="sidebarForms">
                                <ul class="nav sub-navbar-nav">

                                    <li class="sub-nav-item">
                                        <a class="sub-nav-link" href="{{ route('staff.attendance') }}">Attendance</a>
                                    </li>

                                    <li class="sub-nav-item">
                                        <a href="{{ route('staff.attendance.history') }}" class="nav-link">My
                                            Attendance History</a>
                                    </li>
                                    <li class="sub-nav-item">
                                        <a class="nav-link" href="{{ route('staff.payroll') }}">Payroll</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-arrow" href="#sidebarAuthentication" data-bs-toggle="collapse"
                                role="button" aria-expanded="false" aria-controls="sidebarAuthentication">
                                <span class="nav-icon">
                                    <iconify-icon icon="mingcute:user-3-line"></iconify-icon>
                                </span>
                                <span class="nav-text">Enquiry</span>
                            </a>
                            <div class="collapse" id="sidebarAuthentication">
                                <ul class="nav sub-navbar-nav">
                                    <li class="sub-nav-item">
                                        <a class="sub-nav-link" href="{{ route('staff.enquiry.form') }}">Add</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            @yield('staffContent')
        @elseif (Auth::check() && Auth::user()->type == 'student')
            <div class="app-sidebar">

                <div class="logo-box">
                    <a href="index.html" class="logo-dark">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" class="logo-sm" alt="logo sm">
                        <img src="{{ asset('assets/images/logo-dark.png') }}" class="logo-lg" alt="logo dark">
                    </a>

                    <a href="index.html" class="logo-light">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" class="logo-sm" alt="logo sm">
                        <img src="{{ asset('assets/images/logo-light.png') }}" class="logo-lg" alt="logo light">
                    </a>
                </div>

                <div class="scrollbar" data-simplebar="">

                    <ul class="navbar-nav" id="navbar-nav">

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('student.dashboard') }}">
                                <span class="nav-icon">
                                    <iconify-icon icon="mingcute:home-3-line"></iconify-icon>
                                </span>
                                <span class="nav-text"> Dashboard </span>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('student.admission') }}">
                                <span class="nav-icon">
                                    <iconify-icon icon="mingcute:bug-line"></iconify-icon>
                                </span>
                                <span class="nav-text"> Admission </span>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('student.payments') }}">
                                <span class="nav-icon">
                                    <iconify-icon icon="mingcute:dribbble-line"></iconify-icon>
                                </span>
                                <span class="nav-text"> Payment </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('student.mesh') }}">
                                <span class="nav-icon">
                                    <iconify-icon icon="mingcute:user-3-line"></iconify-icon>
                                </span>
                                <span class="nav-text"> Mesh </span>

                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('student.monthly') }}">
                                <span class="nav-icon">
                                    <iconify-icon icon="mingcute:user-3-line"></iconify-icon>
                                </span>
                                <span class="nav-text"> monthly </span>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('student.enquiries') }}">
                                <span class="nav-icon">
                                    <iconify-icon icon="mingcute:user-3-line"></iconify-icon>
                                </span>
                                <span class="nav-text"> Enquiry </span>

                            </a>
                        </li>

                    </ul>
                </div>
            </div>
            @yield('studentContent')
        @endif



        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center">
                        {{ date('Y') }} &copy; Darkone by StackBros.
                    </div>
                </div>
            </div>
            <div class="text-center">
                logged in as:
            </div>
            <strong>
                {{ Auth::user()->type }} | {{ Auth::user()->name }}
            </strong>
        </footer>

    </div>>

    </div>

    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script src="{{ asset('assets/vendor/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jsvectormap/maps/world-merc.js') }}"></script>
    <script src="{{ asset('assets/vendor/jsvectormap/maps/world.js') }}"></script>

    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>

</body>

</html>
