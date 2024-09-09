@extends('auth.layouts.app')

@section('style')
@endsection

@section('content')
    <div class="col-xl-7 offset-xl-2">
        <!-- Tabs Container -->
        <div class="tabs">
            <div class="tabs-header">
                <ul>
                    <li class="active"><a href="#tab-1" data-tab-id="1">@lang('core.resetPassword')</a></li>
                </ul>
                <div class="tab-hover"></div>
            </div>
            <!-- Tab Content -->
            <div class="tabs-content">
                <div class="tab active" data-tab-id="1">
                    <div class="login-register-page">
                        <!-- Welcome Text -->
                        <div class="welcome-text">
{{--                            <span>@lang('core.resetPassword').</span>--}}
                        </div>

                        @if(isset($error))
                            <div id="alert">
                                <div  class="alert alert-danger">
                                    {!! $error !!}
                                </div>
                            </div>
                        @else
                            <!-- Form -->
                            <p id="alert"></p>
                            <div class="login-form">
                                <form method="post" id="login-form">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="passwordResetCode" value="{{ $passwordResetCode }}">
                                    <div class="input-with-icon-left">
                                        <i class="icon-material-outline-lock"></i>
                                        <input type="password" class="input-text with-border" name="password" id="password" placeholder="Password" required/>
                                    </div>
                                    <div class="input-with-icon-left">
                                        <i class="icon-material-outline-lock"></i>
                                        <input type="password" class="input-text with-border" name="password_confirmation" id="password_confirmation" placeholder="Repeat Password" required/>
                                    </div>
                                </form>
                                <!-- Button -->
                                <button class="button full-width button-sliding-icon ripple-effect margin-top-10" type="button" form="login-form" onclick="resetPassword();return false;">Log In <i class="icon-material-outline-arrow-right-alt"></i></button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footerjs')
    <script>
        var resetPassword = () => {
            $.easyAjax({
                url: "{!! route('user.post-password-reset') !!}",
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
