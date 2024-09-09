<!doctype html>
<html lang="en">
<head>

    <!-- Basic Page Needs
    ================================================== -->
    <title>{{ $title ?? '' }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    @include('front.sections.head')
    @stack('style')
</head>
<body>

<!-- Wrapper -->
<div id="wrapper" class="@if($title == 'Home')wrapper-with-transparent-header @else fullwidth @endif">

    <!-- Header Container
    ================================================== -->
    <header id="header-container" class="fullwidth @if($title == 'Home')transparent-header @endif">

        <!-- Header -->
        <div id="header">
            <div class="container">
                @if(isset($user))
                    @include('common.header-logged-in')
                @else
                    @include('common.header-without-login')
                @endif
            </div>
        </div>
        <!-- Header / End -->

    </header>
    <div class="clearfix"></div>
    <!-- Header Container / End -->

    @yield('content')

    <!-- Footer
    ================================================== -->
@include('front.sections.footer')
    <!-- Footer / End -->




</div>
<!-- Wrapper / End -->
@include('front.sections.footer-script')

@stack('script')
</body>
</html>


