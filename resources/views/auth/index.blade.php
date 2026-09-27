<!DOCTYPE html>
<html lang="en">

<head>
     <!-- Title Meta -->
     <meta charset="utf-8">
     <title>Sign Up | Darkone - Dark Admin & UI Kit Template</title>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta name="description" content="Darkone: An advanced, fully responsive admin dashboard template packed with features to streamline your analytics and management needs.">
     <meta name="author" content="StackBros">
     <meta name="keywords" content="Darkone, admin dashboard, responsive template, analytics, modern UI, management tools">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="robots" content="index, follow">
     <meta name="theme-color" content="#ffffff">

     <!-- App favicon -->
     <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">

     <!-- Google Font Family link -->
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
     {{-- <link href="../css2?family=Play:wght@400;700&display=swap" rel="stylesheet"> --}}
     <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">


    <!-- Vendor css -->
    <link href="{{asset('assets/css/vendor.min.css')}}" rel="stylesheet" type="text/css">

    <!-- Icons css -->
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css">

    <!-- App css -->
    <link href="{{asset('assets/css/style.min.css')}}" rel="stylesheet" type="text/css">

    <!-- Theme Config js -->
    <script src="{{asset('assets/js/config.js')}}"></script>
</head>

<body class="authentication-bg">
    <div class="account-pages py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">

                    @yield('authContent')

                </div>
            </div>
        </div>
    </div>

    <!-- Vendor Javascript -->
    <script src="{{asset('assets/js/vendor.min.js')}}"></script>

    <!-- App Javascript -->
    <script src="{{asset('assets/js/app.js')}}"></script>

    <svg id="SvgjsSvg1001" width="2" height="0" xmlns="http://www.w3.org/2000/svg" version="1.1"
        xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev"
        style="overflow: hidden; top: -100%; left: -100%; position: absolute; opacity: 0;">
        <defs id="SvgjsDefs1002"></defs>
        <polyline id="SvgjsPolyline1003" points="0,0"></polyline>
        <path id="SvgjsPath1004" d="M0 0 "></path>
    </svg>
</body>

</html>
