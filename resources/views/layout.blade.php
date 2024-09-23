<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- theme meta -->
    <meta name="theme-name" content="quixlab" />

    <title>Dashboard</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}">

    <!-- Pignose Calender -->
    <link href="{{ asset('/plugins/pg-calendar/css/pignose.calendar.min.css') }}" rel="stylesheet">
    
    <!-- Chartist -->
    <link rel="stylesheet" href="{{ asset('/plugins/chartist/css/chartist.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css') }}">
    
    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"/>

    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />

    <!-- Tippy.js CSS -->
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/animations/scale.css" />
    
    <!-- Custom CSS -->
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

    <!-- Optional: Include moment.js if needed -->
    <script src='https://momentjs.com/downloads/moment.js'></script>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Tippy.js JS -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>

    <!-- Bootstrap JS for optional styling -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* Optional: Custom styling */
        .fc-event {
            cursor: pointer;
        }
    </style>

</head>


<body>

    <!-- Preloader start -->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!-- Preloader end -->

    <!-- Main wrapper start -->
    <div id="main-wrapper">

        <!-- Nav header start -->
        <div class="nav-header">
            <div class="brand-logo">
                <a href="index.html">
                    <b class="logo-abbr"><img src="{{ asset('images/logo.png') }}" alt=""> </b>
                    <span class="logo-compact"><img src="{{ asset('images/logo-compact.png') }}" alt=""></span>
                    <span class="brand-title">
                        
                    </span>
                </a>
            </div>
        </div>
        <!-- Nav header end -->

        <!-- Header start -->
        <div class="header">
            <div class="header-content clearfix">
                <div class="d-flex justify-content-end">
                    <div class="align-self-end mt-3">
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div></div>
            </div>
        </div>
        <!-- Header end -->

        <!-- Sidebar start -->
        @include('menu')
        <!-- Sidebar end -->

        <!-- Content body start -->
        <div class="content-body">
            @yield('content')
        </div>
        <!-- Content body end -->

        <!-- Footer start -->
        <div class="footer">
            <div class="copyright">
                <p>Copyright &copy; Designed & Developed by <a href="https://hvtechnology.it">HVTechnology</a> 2024</p>
            </div>
        </div>
        <!-- Footer end -->
    </div>
    <!-- Main wrapper end -->

    <!-- Scripts -->
    <script src="{{ asset('/plugins/common/common.min.js') }}"></script>
    <script src="{{ asset('/js/custom.min.js') }}"></script>
    <script src="{{ asset('/js/settings.js') }}"></script>
    <script src="{{ asset('/js/gleek.js') }}"></script>
    <script src="{{ asset('/js/styleSwitcher.js') }}"></script>

    <!-- Chartjs -->
    <script src="{{ asset('/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <!-- Circle progress -->
    <script src="{{ asset('/plugins/circle-progress/circle-progress.min.js') }}"></script>
    <!-- Datamap -->
    <script src="{{ asset('/plugins/d3v3/index.js') }}"></script>
    <script src="{{ asset('/plugins/topojson/topojson.min.js') }}"></script>
    <script src="{{ asset('/plugins/datamaps/datamaps.world.min.js') }}"></script>
    <!-- Morrisjs -->
    <script src="{{ asset('/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('/plugins/morris/morris.min.js') }}"></script>
    <!-- Pignose Calender -->
    <script src="{{ asset('/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('/plugins/pg-calendar/js/pignose.calendar.min.js') }}"></script>
    <!-- ChartistJS -->
    <script src="{{ asset('/plugins/chartist/js/chartist.min.js') }}"></script>
    <script src="{{ asset('/plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('/js/dashboard/dashboard-1.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</body>

</html>
