<div id="sign-in-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

    <!--Tabs -->
    <div class="sign-in-form">

        <ul class="popup-tabs-nav">
            <li><a href="#login">Log In</a></li>
            <li><a href="#register">Register</a></li>
        </ul>

        <div class="popup-tabs-container">

            <!-- Login -->
            <div class="popup-tab-content" id="login">

                <!-- Welcome Text -->
                <div class="welcome-text">
                    <h3>We're glad to see you again!</h3>
                    <span>Don't have an account? <a href="#" class="register-tab">Sign Up!</a></span>
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
                <button class="button full-width button-sliding-icon ripple-effect" type="submit" form="login-form">Log In <i class="icon-material-outline-arrow-right-alt"></i></button>

            </div>

            <!-- Register -->
            <div class="popup-tab-content" id="register">

                <!-- Welcome Text -->
                <div class="welcome-text">
                    <h3>Let's create your account!</h3>
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
                <button class="button full-width button-sliding-icon ripple-effect" type="submit" form="register-account-form">Register <i class="icon-material-outline-arrow-right-alt"></i></button>

            </div>

        </div>
    </div>
</div>

<script>
    var login = (data = null) => {
		var showingfield = $('#email1').val();
		var encryptedemail = encodeURI(encodeURIComponent(btoa(showingfield)));
		$('#email').val(encryptedemail);
		// console.log(showingfield);
		// console.log(encryptedemail);
        $.easyAjaxLogin({
            type: 'post',
            url: '{{ route('listings.login') }}',
            data: $("#login-form").serialize(),
            container: "#login-form",
            messagePosition: 'inline',
            success: function (response) {
                if(response.status == 'success') {
                    $.magnificPopup.close();
                    userLoggedIn = true;
                    executeFunction(data);
                }
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
                    $('#alerts').html(html);
                }
            }
        });
    };
    var register = (data = null) => {
        $.easyAjaxLogin({
            url: "{!! route('listings.register') !!}",
            type: "POST",
            data: $("#register-account-form").serialize(),
            container: "#register-account-form",
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
                    $.magnificPopup.close();
                    userLoggedIn = true;
                    executeFunction(data)

                }
                else {
                    console.log('hii from error');
                }
            }
        });
    }
</script>
