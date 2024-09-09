<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.sections.meta-data')
    @include('admin.sections.style')
</head>
<body class="gray">
<div id="wrapper">
    <!-- Header Container
================================================== -->
    <header id="header-container" class="fullwidth dashboard-header not-sticky">
        <!-- Header -->
        <div id="header">
            <div class="container">
                @include('common.admin-header-logged-in')
            </div>
        </div>
    </header>
    <div class="clearfix"></div>

    <!-- Dashboard Container -->
        <div class="dashboard-container">
    <!-- Dashboard Content
        ================================================== -->
            @include('admin.sections.sidebar')
            <div class="dashboard-content-container" data-simplebar>
                <div class="dashboard-content-inner" >
                    @yield('content')

                    @include('admin.sections.footer')
                </div>
            </div>
        </div>
</div>
    @yield('models')
    @include('admin.sections.footer-scripts')
    @stack('script')
</body>
</html>
