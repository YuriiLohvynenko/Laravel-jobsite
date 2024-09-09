<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('user.sections.meta-data')
    @include('user.sections.style')
</head>
<body class="gray">
<div id="wrapper">
    <!-- Header Container
================================================== -->
    <header id="header-container" class="fullwidth dashboard-header not-sticky">
        <!-- Header -->
        <div id="header">
            <div class="container">
                @include('common.header-logged-in')
            </div>
        </div>
    </header>
    <div class="clearfix"></div>

    <!-- Dashboard Container -->
        <div class="dashboard-container">
    <!-- Dashboard Content
        ================================================== -->
            @include('user.sections.sidebar')
            <div class="dashboard-content-container" data-simplebar>
                <div class="dashboard-content-inner" >
                    @yield('content')

                    @include('user.sections.footer')
                </div>
            </div>
        </div>
</div>
    @yield('models')
    @include('user.sections.footer-scripts')
    @stack('script')
</body>
</html>
