@extends('auth.layouts.admin-app')

@section('style')
    <style>
        .alert-danger{
            background: #ed6359;
            padding: 9px;
            margin-bottom: 15px;
            color: #fff;
        }
        .alert .alert-success{
            background: #157d10ba;
            padding: 9px;
            margin-bottom: 15px;
        }
        .alert .alert {
            color: #fff;
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="col-xl-7 offset-xl-2">

        <!-- Tabs Container -->
        <div class="tabs">
            <div class="tabs-header">
                <ul>
                    <li class="active"><a href="#tab-1" data-tab-id="1">Login</a></li>
                </ul>
                <div class="tab-hover"></div>
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

                        <!-- Form -->
                        <form method="post" id="login-form">
                            <p id="alert"></p>
                            {{ csrf_field() }}
                            <div class="input-with-icon-left">
                                <i class="icon-material-baseline-mail-outline"></i>
                                <input type="text" class="input-text with-border" name="email" id="email" placeholder="Email Address" required/>
                            </div>

                            <div class="input-with-icon-left">
                                <i class="icon-material-outline-lock"></i>
                                <input type="password" class="input-text with-border" name="password" id="password" placeholder="Password" required/>
                            </div>
{{--                            <a href="{{ route('user.get-reset') }}" class="forgot-password">@lang('core.forgetPassword')?</a>--}}
                        </form>

                        <!-- Button -->
                        <button class="button full-width button-sliding-icon ripple-effect margin-top-10" type="submit" form="login-form" onclick="login();return false;">Log In <i class="icon-material-outline-arrow-right-alt"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footerjs')
    <script>
    var login = () => {
        $.easyAjax({
            type: 'post',
            url: '{{ route('admin.login_check') }}',
            data: $("#login-form").serialize(),
            container: "#login-form",
            messagePosition: 'inline',
        });
    };
    </script>
@endsection
