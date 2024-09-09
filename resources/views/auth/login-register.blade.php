@extends('auth.layouts.app')

@section('style')
@endsection

@section('content')
    <div class="col-xl-7 offset-xl-2">

        <!-- Tabs Container -->
        <div class="tabs">
            <div class="tabs-header">
                <ul>
                    <li class="active"><a href="#tab-1" data-tab-id="1">Login</a></li>
                    <li><a href="#tab-2" data-tab-id="2">Create Account</a></li>
                </ul>
                <div class="tab-hover"></div>
                <nav class="tabs-nav">
                    <span class="tab-prev"><i class="icon-material-outline-keyboard-arrow-left"></i></span>
                    <span class="tab-next"><i class="icon-material-outline-keyboard-arrow-right"></i></span>
                </nav>
            </div>
            <!-- Tab Content -->
            <div class="tabs-content">
                <div class="tab active" data-tab-id="1">

                    <div class="login-register-page">
                        <!-- Welcome Text -->
                        <div class="welcome-text">
                            <h3 class="margin-bottom-10">We're glad to see you again!</h3>
                            <span>Sign in below.</span>
                        </div>
                        <p id="alerts"></p>
                        <!-- Form -->
                        <form method="post" id="login-form">
                            {{ csrf_field() }}
                            <div class="input-with-icon-left">
                                <i class="icon-material-baseline-mail-outline"></i>
                                <input type="text" class="input-text with-border" name="email1" id="email1" placeholder="Email Address" required/>
                                <input type="hidden" class="input-text with-border" name="email" id="email" placeholder="Email Address" required/>
                            </div>

                            <div class="input-with-icon-left">
                                <i class="icon-material-outline-lock"></i>
                                <input type="password" class="input-text with-border" name="password" id="password" placeholder="Password" required/>
                            </div>
                            <a href="{{ route('user.get-reset') }}" class="forgot-password">@lang('core.forgetPassword')?</a>
                        </form>

                        <!-- Button -->
                        <button class="button full-width button-sliding-icon ripple-effect margin-top-10" type="submit" form="login-form" onclick="login();return false;">Log In <i class="icon-material-outline-arrow-right-alt"></i></button>

                        <!-- Social Login -->
                        <div class="social-login-separator"><span>or</span></div>
                        <div class="social-login-buttons">
                            <script>
                                var facebook = "{{ route('social.login', 'facebook') }}";
                                var google = "{{ route('social.login', 'google') }}";
                            </script>
                            <button class="facebook-login ripple-effect" onclick="window.location.href = facebook;"><i class="icon-brand-facebook-f"></i> Log In via Facebook</button>
                            <button class="google-login ripple-effect" onclick="window.location.href = google;"><i class="icon-brand-google-plus-g"></i> Log In via Google+</button>
                        </div>
                    </div>
                </div>

                <div class="tab active" data-tab-id="2">
                    <div class="login-register-page">
                        <p id="alert"></p>
                        <!-- Welcome Text -->
                        <div class="register-form">
                            <div class="welcome-text">
                                <h3 class="margin-bottom-10" style="font-size: 26px;">Let's create your account!</h3>
                                <span>Start owning your future today!</span>
                            </div>

                            <!-- Form -->
                            <form method="post" id="register-account-form">
                                {{ csrf_field() }}
                                <div class="input-with-icon-left">
                                    <i class="icon-material-baseline-mail-outline"></i>
                                    <input type="text" class="input-text with-border" name="username" id="username" placeholder="Username" required/>
                                </div>

                                <div class="input-with-icon-left">
                                    <i class="icon-material-baseline-mail-outline"></i>
                                    <input type="text" class="input-text with-border" name="first_name" id="first_name" placeholder="First Name" required/>
                                </div>

                                <div class="input-with-icon-left">
                                    <i class="icon-material-baseline-mail-outline"></i>
                                    <input type="text" class="input-text with-border" name="last_name" id="last_name" placeholder="Last Name" required/>
                                </div>

                                <div class="input-with-icon-left">
                                    <i class="icon-material-baseline-mail-outline"></i>
                                    <input type="text" class="input-text with-border" name="email" id="email" placeholder="Email Address" required/>
                                </div>

                                <div class="input-with-icon-left" title="Should be at least 8 characters long" data-tippy-placement="bottom">
                                    <i class="icon-material-outline-lock"></i>
                                    <input type="password" class="input-text with-border" name="password" id="password" placeholder="Password" required/>
                                </div>

                                <div class="input-with-icon-left">
                                    <i class="icon-material-outline-lock"></i>
                                    <input type="password" class="input-text with-border" name="password_confirmation" id="password_confirmation" placeholder="Repeat Password" required/>
                                </div>
                            </form>

                            <!-- Button -->
                            <button class="button full-width button-sliding-icon ripple-effect margin-top-10" type="submit" form="login-form" onclick="register();return false;">Register <i class="icon-material-outline-arrow-right-alt"></i></button>

                            <!-- Social Login -->
                            <div class="social-login-separator"><span>or</span></div>
                            <script>
                                var facebook = "{{ route('social.login', 'facebook') }}";
                                var google = "{{ route('social.login', 'google') }}";
                            </script>
                            <div class="social-login-buttons">
                                <button class="facebook-login ripple-effect"><i class="icon-brand-facebook-f" onclick="window.location.href = facebook;"></i> Register via Facebook</button>
                                <button class="google-login ripple-effect"><i class="icon-brand-google-plus-g" onclick="window.location.href = google;"></i> Register via Google+</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footerjs')
    <script>
    var login = () => {
		var showingfield = $('#email1').val();
		var encryptedemail = encodeURI(encodeURIComponent(btoa(showingfield)));
		$('#email').val(encryptedemail);
		// console.log(showingfield);
		// console.log(encryptedemail);
        $.easyAjax({
            type: 'post',
            url: '{{ route('user.login_check') }}',
            data: $("#login-form").serialize(),
            container: "#login-form",
            messagePosition: 'inline',
            success: function (response) {
                if(response.status == 'fail') {

                    $('.tabs').each(function() {

                        var thisTab = $(this);

                        // Intial Border Position
                        var activePos = thisTab.find('.tabs-header .active').position();

                        function changePos() {

                            // Update Position
                            activePos = thisTab.find('.tabs-header .active').position();

                            // Change Position & Width
                            thisTab.find('.tab-hover').stop().css({
                                left: activePos.left,
                                width: thisTab.find('.tabs-header .active').width()
                            });
                        }

                        changePos();

                        // Intial Tab Height
                        var tabHeight = thisTab.find('.tab.active').outerHeight();

                        // Animate Tab Height
                        function animateTabHeight() {

                            // Update Tab Height
                            tabHeight = thisTab.find('.tab.active').outerHeight();

                            // Animate Height
                            thisTab.find('.tabs-content').stop().css({
                                height: tabHeight + 'px'
                            });
                        }

                        animateTabHeight();

                        // Change Tab
                        function changeTab() {
                            var getTabId = thisTab.find('.tabs-header .active a').attr('data-tab-id');

                            // Remove Active State
                            thisTab.find('.tab').stop().fadeOut(300, function () {
                                // Remove Class
                                $(this).removeClass('active');
                            }).hide();

                            thisTab.find('.tab[data-tab-id=' + getTabId + ']').stop().fadeIn(300, function () {
                                // Add Class
                                $(this).addClass('active');

                                // Animate Height
                                animateTabHeight();
                            });
                        }

                        // Tabs
                        thisTab.find('.tabs-header a').on('click', function (e) {
                            e.preventDefault();

                            // Tab Id
                            var tabId = $(this).attr('data-tab-id');

                            // Remove Active State
                            thisTab.find('.tabs-header a').stop().parent().removeClass('active');

                            // Add Active State
                            $(this).stop().parent().addClass('active');

                            changePos();

                            // Update Current Itm
                            tabCurrentItem = tabItems.filter('.active');

                            // Remove Active State
                            thisTab.find('.tab').stop().fadeOut(300, function () {
                                // Remove Class
                                $(this).removeClass('active');
                            }).hide();

                            // Add Active State
                            thisTab.find('.tab[data-tab-id="' + tabId + '"]').stop().fadeIn(300, function () {
                                // Add Class
                                $(this).addClass('active');

                                // Animate Height
                                animateTabHeight();
                            });
                        });

                        // Tab Items
                        var tabItems = thisTab.find('.tabs-header ul li');

                        // Tab Current Item
                        var tabCurrentItem = tabItems.filter('.active');

                        // Next Button
                        thisTab.find('.tab-next').on('click', function (e) {
                            e.preventDefault();

                            var nextItem = tabCurrentItem.next();

                            tabCurrentItem.removeClass('active');

                            if (nextItem.length) {
                                tabCurrentItem = nextItem.addClass('active');
                            } else {
                                tabCurrentItem = tabItems.first().addClass('active');
                            }

                            changePos();
                            changeTab();
                        });

                        // Prev Button
                        thisTab.find('.tab-prev').on('click', function (e) {
                            e.preventDefault();

                            var prevItem = tabCurrentItem.prev();

                            tabCurrentItem.removeClass('active');

                            if (prevItem.length) {
                                tabCurrentItem = prevItem.addClass('active');
                            } else {
                                tabCurrentItem = tabItems.last().addClass('active');
                            }

                            changePos();
                            changeTab();
                        });
                    });
                    // var ele = $('#login-form').find("#alert");
                    var html = '<div class="alert alert-danger">' + response.message +'</div>';
                    console.log(html);
                    $('#alerts').html(html);
                }
            }
        });
    };
    var register = () => {
        $.easyAjax({
            url: "{!! route('post-register') !!}",
            type: "POST",
            data: $("#register-account-form").serialize(),
            container: ".login-register-page",
            messagePosition: 'inline',
            success: function (response) {
                if(response.status == 'success') {
                    $(window).scrollTop( $(".login-register-page").offset().top );
                    $('.register-form').remove();

                    $('.tabs').each(function() {

                        var thisTab = $(this);

                        // Intial Border Position
                        var activePos = thisTab.find('.tabs-header .active').position();

                        function changePos() {

                            // Update Position
                            activePos = thisTab.find('.tabs-header .active').position();

                            // Change Position & Width
                            thisTab.find('.tab-hover').stop().css({
                                left: activePos.left,
                                width: thisTab.find('.tabs-header .active').width()
                            });
                        }

                        changePos();

                        // Intial Tab Height
                        var tabHeight = thisTab.find('.tab.active').outerHeight();

                        // Animate Tab Height
                        function animateTabHeight() {

                            // Update Tab Height
                            tabHeight = thisTab.find('.tab.active').outerHeight();

                            // Animate Height
                            thisTab.find('.tabs-content').stop().css({
                                height: tabHeight + 'px'
                            });
                        }

                        animateTabHeight();

                        // Change Tab
                        function changeTab() {
                            var getTabId = thisTab.find('.tabs-header .active a').attr('data-tab-id');

                            // Remove Active State
                            thisTab.find('.tab').stop().fadeOut(300, function () {
                                // Remove Class
                                $(this).removeClass('active');
                            }).hide();

                            thisTab.find('.tab[data-tab-id=' + getTabId + ']').stop().fadeIn(300, function () {
                                // Add Class
                                $(this).addClass('active');

                                // Animate Height
                                animateTabHeight();
                            });
                        }

                        // Tabs
                        thisTab.find('.tabs-header a').on('click', function (e) {
                            e.preventDefault();

                            // Tab Id
                            var tabId = $(this).attr('data-tab-id');

                            // Remove Active State
                            thisTab.find('.tabs-header a').stop().parent().removeClass('active');

                            // Add Active State
                            $(this).stop().parent().addClass('active');

                            changePos();

                            // Update Current Itm
                            tabCurrentItem = tabItems.filter('.active');

                            // Remove Active State
                            thisTab.find('.tab').stop().fadeOut(300, function () {
                                // Remove Class
                                $(this).removeClass('active');
                            }).hide();

                            // Add Active State
                            thisTab.find('.tab[data-tab-id="' + tabId + '"]').stop().fadeIn(300, function () {
                                // Add Class
                                $(this).addClass('active');

                                // Animate Height
                                animateTabHeight();
                            });
                        });

                        // Tab Items
                        var tabItems = thisTab.find('.tabs-header ul li');

                        // Tab Current Item
                        var tabCurrentItem = tabItems.filter('.active');

                        // Next Button
                        thisTab.find('.tab-next').on('click', function (e) {
                            e.preventDefault();

                            var nextItem = tabCurrentItem.next();

                            tabCurrentItem.removeClass('active');

                            if (nextItem.length) {
                                tabCurrentItem = nextItem.addClass('active');
                            } else {
                                tabCurrentItem = tabItems.first().addClass('active');
                            }

                            changePos();
                            changeTab();
                        });

                        // Prev Button
                        thisTab.find('.tab-prev').on('click', function (e) {
                            e.preventDefault();

                            var prevItem = tabCurrentItem.prev();

                            tabCurrentItem.removeClass('active');

                            if (prevItem.length) {
                                tabCurrentItem = prevItem.addClass('active');
                            } else {
                                tabCurrentItem = tabItems.last().addClass('active');
                            }

                            changePos();
                            changeTab();
                        });
                    });
                }
                else {
                    console.log('hii from error');
                }
            }
        });
    }
    </script>
@endsection
