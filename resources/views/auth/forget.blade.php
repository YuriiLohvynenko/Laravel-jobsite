@extends('auth.layouts.app')

@section('style')
@endsection

@section('content')
    <div class="col-xl-7 offset-xl-2">
        <!-- Tabs Container -->
        <div class="tabs">
            <div class="tabs-header">
                <ul>
                    <li class="active"><a href="#tab-1" data-tab-id="1">@lang('core.forgetPassword')</a></li>
                </ul>
                <div class="tab-hover"></div>
            </div>
            <!-- Tab Content -->
            <div class="tabs-content">
                <div class="tab active" data-tab-id="1">
                    <div class="login-register-page">
                        <!-- Welcome Text -->
                        <div class="welcome-text">
                            <span>@lang('core.forgetPasswordQuote').</span>
                        </div>
                        <!-- Form -->
                        <p id="alert"></p>
                        <div class="login-form">
                            <form method="post" id="login-form">
                                {{ csrf_field() }}
                                <div class="input-with-icon-left margin-bottom-30">
                                    <i class="icon-material-baseline-mail-outline"></i>
                                    <input type="text" class="input-text with-border" name="email" id="email" placeholder="Email Address" required/>
                                </div>
                            </form>
                            <!-- Button -->
                            <button class="button full-width button-sliding-icon ripple-effect margin-top-10" type="button" form="login-form" onclick="forgetPassword();return false;">Log In <i class="icon-material-outline-arrow-right-alt"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footerjs')
    <script>
        var forgetPassword = () => {
            $.easyAjax({
                url: "{!! route('user.post-reset') !!}",
                type: "POST",
                data: $("#login-form").serialize(),
                container: ".login-register-page",
                messagePosition: 'inline',
                success: function (response) {
                    if(response.status == 'success') {
                        $(window).scrollTop( $(".login-register-page").offset().top );
                        $('.login-form').remove();
                    }
                }
            });
        }
    </script>
@endsection
