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
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('css/vendor.css') }}">
    <!-- Head Libs -->
    <script src="{{ mix('js/app.js') }}" defer></script>

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

                    <!-- <h2 class="font-weight-semibold">
                        @yield('page_title')
                    </h2> -->
                </header>

                <!-- start: page -->
                @yield('content')
                <!-- end: page -->
            </section>
        </div>
    </section>

    <!-- Vendor -->
    <script src="{{ mix('js/vendor.js') }}"></script>
</body>

</html>