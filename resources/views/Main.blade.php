<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Adhikarya Brawijaya Research.</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('asset/img/favicon.ico') }}">
    <link href="{{ url('https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('asset/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/owl.theme.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/owl.transitions.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/meanmenu.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/educate-custon-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/morrisjs/morris.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/scrollbar/jquery.mCustomScrollbar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/metisMenu/metisMenu.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/metisMenu/metisMenu-vertical.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/calendar/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/calendar/fullcalendar.print.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/responsive.css') }}">
    <script src="{{ asset('asset/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    <link rel="stylesheet" href="{{ url('https://unpkg.com/leaflet@1.9.4/dist/leaflet.css') }}"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <script src="{{ url('https://code.jquery.com/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ url('https://unpkg.com/leaflet@1.9.4/dist/leaflet.js') }}"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <style>
        .active {
            background-color: rgb(227, 226, 235) !important;
            color: white !important;
        }

        .metismenu li {
            margin: 0 !important;
            padding: 0 !important;
        }

        .courses-area {
            margin-left: 25px !important;
            z-index: 1 !important;
            position: relative !important;
        }

        .content {
            margin-top: 30px;
        }

        .full-width-banner {
            background-color: black;
            width: 100%;
            padding: 10px 0;
            text-align: center;
        }

        .banner-text {
            color: white;
            font-size: 20px;
            font-weight: bold;
        }

        @media (min-width: 768px) {
            .content {
                margin-top: 80px;
            }
        }

        @media (max-width: 768px) {
            .courses-area {
                margin-left: 0px !important;
            }
        }
    </style>
</head>

<body>
    @include('Sidebar')

    <div class="all-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    {{-- <div class="logo-pro">
                        <a href="index.html"><img class="main-logo" src="img/logo/logo.png" alt="" /></a>
                    </div> --}}
                </div>
            </div>
        </div>

        @include('Navbar')

        @yield('content')

        @include('Footer')
    </div>


    <script src="{{ asset('asset/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('asset/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('asset/js/wow.min.js') }} "></script>
    <script src="{{ asset('asset/js/jquery-price-slider.js') }}"></script>
    <script src="{{ asset('asset/js/jquery.meanmenu.js') }}"></script>
    <script src="{{ asset('asset/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('asset/js/jquery.sticky.js') }}"></script>
    <script src="{{ asset('asset/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('asset/js/counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('asset/js/counterup/waypoints.min.js') }}"></script>
    <script src="{{ asset('asset/js/counterup/counterup-active.js') }}"></script>
    <script src="{{ asset('asset/js/scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('asset/js/scrollbar/mCustomScrollbar-active.js') }}"></script>
    <script src="{{ asset('asset/js/metisMenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('asset/js/metisMenu/metisMenu-active.js') }}"></script>
    <script src="{{ asset('asset/js/morrisjs/raphael-min.js') }}"></script>
    <script src="{{ asset('asset/js/morrisjs/morris.js') }}"></script>
    <script src="{{ asset('asset/js/morrisjs/morris-active.js') }}"></script>
    <script src="{{ asset('asset/js/sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('asset/js/sparkline/jquery.charts-sparkline.js') }}"></script>
    <script src="{{ asset('asset/js/sparkline/sparkline-active.js') }}"></script>
    <script src="{{ asset('asset/js/calendar/moment.min.js') }}"></script>
    <script src="{{ asset('asset/js/calendar/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('asset/js/calendar/fullcalendar-active.js') }}"></script>
    <script src="{{ asset('asset/js/plugins.js') }}"></script>
    <script src="{{ asset('asset/js/main.js') }}"></script>
    {{-- <script src="{{ asset('asset/js/tawk-chat.js') }}"></script> --}}
</body>

</html>
