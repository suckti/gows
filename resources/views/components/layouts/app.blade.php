<!doctype html>
<html class="has-tab-navigation header-dark">

<head>

    <!-- Basic -->
    <meta charset="UTF-8">

    <title>Tab Navigation Layout | Porto Admin - Responsive HTML5 Template</title>

    <meta name="keywords" content="HTML5 Admin Template" />
    <meta name="description" content="Porto Admin - Responsive HTML5 Template">
    <meta name="author" content="okler.net">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- Web Fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.css')}}" />
    <link rel="stylesheet" href="{{asset('vendor/animate/animate.compat.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/font-awesome/css/all.min.css')}}" />
    <link rel="stylesheet" href="{{asset('vendor/boxicons/css/boxicons.min.css')}}" />
    <link rel="stylesheet" href="{{asset('vendor/magnific-popup/magnific-popup.css')}}" />
    <link rel="stylesheet" href="{{asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css')}}" />
    <link rel="stylesheet" href="{{asset('vendor/jquery-ui/jquery-ui.css')}}" />
    <link rel="stylesheet" href="{{asset('vendor/jquery-ui/jquery-ui.theme.css')}}" />
    <link rel="stylesheet" href="{{asset('vendor/bootstrap-multiselect/css/bootstrap-multiselect.css')}}" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{asset('css/theme.css')}}" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="{{asset('css/skins/default.css')}}" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">

    <!-- Head Libs -->
    <script src="{{asset('vendor/modernizr/modernizr.js')}}"></script>

    @yield('content_css')

</head>

<body>
    <section class="body">

        <!-- start: header -->
        @include('components.layouts.header')
        <!-- end: header -->

        <div class="inner-wrapper">
            <!-- start: navigation -->
            @include('components.layouts.navigation')
            <!-- end: navigation  -->

            <section role="main" class="content-body">
                <header class="page-header page-header-left-breadcrumb">
                    <div class="right-wrapper">
                        @yield('breadcrumb')
                    </div>

                    <h2 class="font-weight-semibold">
                        @yield('page_title')
                    </h2>
                </header>

                <!-- start: page -->
                @yield('content')
                <!-- end: page -->
            </section>
        </div>
    </section>

    <!-- Vendor -->
    <script src="{{asset('vendor/jquery/jquery.js')}}"></script>
    <script src="{{asset('vendor/jquery-browser-mobile/jquery.browser.mobile.js')}}"></script>
    <script src="{{asset('vendor/popper/umd/popper.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('vendor/common/common.js')}}"></script>
    <script src="{{asset('vendor/nanoscroller/nanoscroller.js')}}"></script>
    <script src="{{asset('vendor/magnific-popup/jquery.magnific-popup.js')}}"></script>
    <script src="{{asset('vendor/jquery-placeholder/jquery.placeholder.js')}}"></script>

    <!-- Specific Page Vendor -->
    <script src="{{asset('vendor/jquery-ui/jquery-ui.js')}}"></script>
    <script src="{{asset('vendor/jqueryui-touch-punch/jquery.ui.touch-punch.js')}}"></script>
    <script src="{{asset('vendor/jquery-appear/jquery.appear.js')}}"></script>
    <script src="{{asset('vendor/bootstrap-multiselect/js/bootstrap-multiselect.js')}}"></script>

    <!-- Theme Base, Components and Settings -->
    <script src="{{asset('js/theme.js')}}"></script>

    <!-- Theme Custom -->
    <script src="{{asset('js/custom.js')}}"></script>

    <!-- Theme Initialization Files -->
    <script src="{{asset('js/theme.init.js')}}"></script>

</body>

</html>