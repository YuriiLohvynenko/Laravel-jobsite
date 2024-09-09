<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('auth.sections.meta-data')
    @include('auth.sections.style')
</head>
<body>
<div id="wrapper">
    @include('auth.sections.admin-navbar')
    <!-- Page Content
================================================== -->
        <div class="container">
            <div class="row margin-top-70 margin-bottom-70">
                @yield('content')
            </div>
        </div>
        @include('auth.sections.footer')
</div>
    @include('auth.sections.footer-scripts')
    @yield('script')
</body>
</html>
