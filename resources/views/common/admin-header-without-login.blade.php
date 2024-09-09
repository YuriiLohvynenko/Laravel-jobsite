<!-- Left Side Content -->
<div class="left-side">

    <!-- Logo -->
    <div id="logo">
        <a href="{{ route('front.home')  }}"><img src="{{ asset('images/logo2.png') }}" data-sticky-logo="{{ asset('images/logo.png') }}" data-transparent-logo="{{ asset('images/logo2.png') }}" alt=""></a>
    </div>

    <!-- Main Navigation -->
{{--    <nav id="navigation">--}}
{{--        <ul id="responsive">--}}

{{--            <li><a href="{{ route('front.home') }}"><i class="icon-feather-home blue-icon"></i> Home</a>--}}
{{--            </li>--}}

{{--            <li><a href="{{ route('front.search') }}"><i class="icon-feather-search blue-icon"></i> Find Jobs</a>--}}
{{--            </li>--}}

{{--            <li><a href="{{ route('front.listing.create') }}"><i class="icon-feather-upload-cloud blue-icon"></i> Post a Job</a>--}}
{{--            </li>--}}

{{--        </ul>--}}
{{--    </nav>--}}
    <div class="clearfix"></div>
    <!-- Main Navigation / End -->

</div>
<!-- Left Side Content / End -->


<!-- Right Side Content / End -->
<div class="right-side">

    <div class="header-widget">
        <a href="{{ route('admin.login') }}" class="popup-with-zoom-anim log-in-button"><i class="icon-feather-log-in" ></i> <span>Log In</span></a>
    </div>

    <!-- Mobile Navigation Button -->
    <span class="mmenu-trigger">
					<button class="hamburger hamburger--collapse" type="button">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</button>
				</span>

</div>
<!-- Right Side Content / End -->
