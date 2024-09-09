@extends('user.layouts.app')

@section('style')
@endsection

@section('content')
    <!-- Dashboard Headline -->
    <div class="dashboard-headline">
        <div class="row">
            <div class="col">
                <h3>@lang('core.hello'), {{ ucfirst($user->first_name) }}</h3>
            </div>
            <div class="col">
                <!-- Breadcrumbs -->
                <nav id="breadcrumbs" class="dark">
                    <ul>
                        <li><a href="{{ route('user.dashboard.index') }}">Home</a></li>
                        <li>Settings</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!-- Form -->
    <p id="alert"></p>
    <form id="user-profile-form" class="user-profile-form">
        {{ csrf_field() }}
        <input name="_method" value="PUT" type="hidden">
        <!-- Dashboard Box -->
        <div class="col-xl-12">
            <div class="dashboard-box margin-top-0">

                <!-- Headline -->
                <div class="headline">
                    <h3><i class="icon-material-outline-account-circle"></i> @lang('core.myAccount')</h3>
                </div>

                <div class="content with-padding padding-bottom-0">

                    <div class="row">

                        <div class="col-auto">
                            <div class="avatar-wrapper" data-tippy-placement="bottom" title="Change Avatar">
                                <img class="profile-pic" src="{{ $user->image() }}" alt="" />
                                <div class="upload-button"></div>
                                <input class="file-upload" type="file" name="image" accept="image/*"/>
                            </div>
                        </div>

                        <div class="col">
                            <div class="row">

                                <div class="col-xl-6">
                                    <div class="submit-field">
                                        <h5>@lang('core.firstname')</h5>
                                        <input type="text" name="first_name" class="with-border" value="{{ $user->first_name }}">
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="submit-field">
                                        <h5>@lang('core.lastname')</h5>
                                        <input type="text" name="last_name" class="with-border" value="{{ $user->last_name }}">
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="submit-field">
                                        <h5>@lang('core.profile') @lang('core.email') <i class="icon-feather-info" title="@lang('messages.profileEmailNote')" data-tippy-placement="top"></i></h5>
                                        <input type="text" name="email" id="em" class="with-border" value="{{ base64_decode(urldecode(rawurldecode($user->email))) }}">
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="submit-field">
                                        <h5>@lang('core.paypal') @lang('core.email') <i class="icon-feather-info" title="@lang('messages.paypalEmailNote')" data-tippy-placement="top"></i></h5>
                                        <input type="text" name="paypal_email" id="paypal_email" value="{{ $userDetail->paypal_email }}" class="with-border" placeholder="tom@example.com">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Dashboard Box -->
        <div class="col-xl-12">
            <div class="dashboard-box">

                <!-- Headline -->
                <div class="headline">
                    <h3><i class="icon-material-outline-face"></i> @lang('core.myProfile')</h3>
                </div>

                <div class="content">
                    <ul class="fields-ul">
                        <li>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="submit-field">
                                        <div class="bidding-widget">
                                            <!-- Headline -->
                                            <span class="bidding-detail">@lang('messages.minimumRate')</span>

                                            <!-- Slider -->
                                            <div class="bidding-value margin-bottom-10">$<span id="biddingVal"></span></div>
                                            <input class="bidding-slider" name="hourly_rate" type="text" value="{{ $userDetail->hourly_rate }}" data-slider-handle="custom" data-slider-currency="$" data-slider-min="10" data-slider-max="200" data-slider-value="{{ $userDetail->hourly_rate }}" data-slider-step="1" data-slider-tooltip="hide" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6">

                                </div>

                            </div>
                        </li>
                        <li>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="submit-field">
                                        <h5>@lang('core.mainSpecialty') <i class="icon-feather-info" title="@lang('messages.mainSpecialtyNote')" data-tippy-placement="top"></i></h5>
                                        <select class="selectpicker with-border" name="speciality[]"  multiple data-max-options="2" data-size="7" title="Select Specialty" data-live-search="true">
                                            @forelse($specialities as $speciality)
                                                <option value="{{ $speciality->id }}"> {{ $speciality->name }}</option>
                                            @empty
                                                <option value=" "> @lang('messages.noSpecialityFound')</option>
                                            @endforelse

                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="submit-field">
                                        <h5>@lang('core.previousJobTitles') <i class="icon-feather-info" title="Add up to 3 relevant job titles" data-tippy-placement="top"></i></h5>

                                        <!-- Skills List -->
                                        <div class="keywords-container">
                                            <div class="keyword-input-container">
                                                <input type="text" value="" id="previous_job_titles" name="previous_job_titles" class="keyword-input with-border" placeholder="@lang('messages.previousJobTitlesNote')"/>
                                                <button type="button" class="keyword-input-button ripple-effect"><i class="icon-material-outline-add"></i></button>
                                            </div>
                                            <div class="keywords-list">
                                                @forelse($previousTitles as $previousTitle)
                                                    <span class="keyword"><span class="keyword-remove"></span><span class="keyword-text">{{ $previousTitle }}</span><input type="hidden" value="{{ $previousTitle }}" name="previous_job_title[]"></span>
                                                @empty
                                                @endforelse
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="submit-field">
                                        <h5>@lang('core.profileIntroduction') <i class="icon-feather-info" title="@lang('messages.profileIntroductionNote')" data-tippy-placement="top"></i></h5>
                                        <textarea cols="30" name="profileIntroduction" rows="5" class="with-border">{{ $userDetail->introduction }}</textarea>
                                    </div>
                                </div>

                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Dashboard Box -->
        <div class="col-xl-12">
            <div class="dashboard-box margin-top-30">

                <!-- Headline -->
                <div class="headline">
                    <h3><i class="icon-material-outline-account-circle"></i> @lang('core.address')</h3>
                </div>

                <div class="content with-padding padding-bottom-0">

                    <div class="row">
                        <div class="col">
                            <div class="row">

                                <div class="col-xl-6">
                                    <div class="submit-field">
                                        <h5>@lang('core.address')</h5>
                                        <input type="text" name="address" value="{{ $userDetail->address }}" class="with-border" placeholder="Start typing address...">
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="submit-field">
                                        <h5>@lang('core.city')</h5>
                                        <input type="text" name="city"  value="{{ $userDetail->city }}"  class="with-border" placeholder="Cleveland">
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="submit-field">
                                        <h5>@lang('core.state')</h5>
                                        <input type="text" name="state"  value="{{ $userDetail->state }}"  class="with-border" placeholder="OH">
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="submit-field">
                                        <h5>@lang('core.zipCode')</h5>
                                        <input type="text" name="zip_code"  value="{{ $userDetail->zip_code }}"  class="with-border" placeholder="44137">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Dashboard Box -->
        <div class="col-xl-12">
            <div id="test1" class="dashboard-box">

                <!-- Headline -->
                <div class="headline">
                    <h3><i class="icon-material-outline-lock"></i> @lang('core.phoneVerification') <i class="icon-feather-info" title="@lang('messages.phoneVerificationNote')" data-tippy-placement="top"></i></h3>
                </div>

                <div class="content with-padding">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="submit-field">
                                <h5>@lang('core.mobileNumber')</h5>
                                <input type="text" name="mobile_no" value="{{ base64_decode(urldecode(rawurldecode($userDetail->mobile_no))) }}" class="with-border" placeholder="(216) 518-4236">
                            </div>
                        </div>

                        <div class="col-auto center-vertical">
                            <button class="button gray ripple-effect">@lang('core.sendCode')</button>
                        </div>

                        <div class="col-xl-4">
                            <div class="submit-field">
                                <h5>@lang('core.verificationCode')</h5>
                                <input type="text" name="verification_code" class="with-border" placeholder="e.g. 348TFI">
                            </div>
                        </div>

                        <div class="col-auto center-vertical">
                            <button class="button ripple-effect button-sliding-icon">@lang('core.verify') <i class="icon-feather-check"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard Box -->
        <div class="col-xl-12">
            <div id="test1" class="dashboard-box">

                <!-- Headline -->
                <div class="headline">
                    <h3><i class="icon-material-outline-lock"></i> @lang('core.passwordSecurity')</h3>
                </div>

                <div class="content with-padding">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="submit-field">
                                <h5>@lang('core.currentPassword')</h5>
                                <input type="password" name="current_password" autocomplete="false" class="with-border">
                            </div>
                        </div>

                        <div class="col-auto center-vertical">
                            <button class="button gray ripple-effect">@lang('core.sendCode')</button>
                        </div>

                        <div class="col-xl-4">
                            <div class="submit-field">
                                <h5>@lang('core.verificationCode')</h5>
                                <input type="password" name="verificationCode" class="with-border">
                            </div>
                        </div>

                        <div class="col-auto center-vertical">
                            <button class="button ripple-effect button-sliding-icon">@lang('core.verify') <i class="icon-feather-check"></i></button>
                        </div>

                        <div class="col-xl-6">
                            <div class="submit-field">
                                <h5>@lang('core.newPassword')</h5>
                                <input type="password" name="new_password" class="with-border">
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="submit-field">
                                <h5>@lang('core.verify') @lang('core.password')</h5>
                                <input type="password" name="password_confirmation" class="with-border">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Button -->
        <div class="col-xl-12">
            <a href="javascript:;" onclick="profileUpdate(); return false;" class="button ripple-effect big margin-top-30">@lang('core.saveChanges')</a>
        </div>
    </form>

@endsection

@section('footerjs')
    <!-- Snackbar // documentation: https://www.polonel.com/snackbar/ -->

    <script>
        $(document).ready(function() {

            $(window).keydown(function(event){

                if((event.keyCode == 13)) {

                    event.preventDefault();

                    return false;

                }

            });

        });

        @if($userSpecialities)
            $('.selectpicker').val({!! $userSpecialities !!});
            $('.selectpicker').selectpicker('refresh');
        @endif

        function profileUpdate () {
			var showingfield=$('#em').val();
			var encryptedemail = encodeURI(encodeURIComponent(btoa(showingfield)));
			
            $.easyAjax({
                url: "{!! route('setting.dashboard-setting.update', $user->id) !!}",
                type: "POST",
                container: ".user-profile-form",
				data:{"encryptemail":encryptedemail},
                file: true,
                success: function (response) {
                    if(response.status == 'success') {
                        $(window).scrollTop( $("#user-profile-form").offset().top );
                        $('.profile-image-change').attr('src', response.image)
                    }
                }
            });
        }

        /*--------------------------------------------------*/
        /*  Keywords
         /*--------------------------------------------------*/
        $(".keywords-container").each(function() {

            var keywordInput = $(this).find(".keyword-input");
            var keywordsList = $(this).find(".keywords-list");

            // adding keyword
            function addKeyword() {
                var $newKeyword = $("<span class='keyword'><span class='keyword-remove'></span><span class='keyword-text'>"+ keywordInput.val() +"</span><input type='hidden' value='"+ keywordInput.val() +"' name='previous_job_title[]'></span>");
                keywordsList.append($newKeyword).trigger('resizeContainer');
                keywordInput.val("");
            }

            // add via enter key
            keywordInput.on('keyup', function(e){
                if((e.keyCode == 13) && (keywordInput.val()!=="")){
                    addKeyword();
                }
            });

            // add via button
            $('.keyword-input-button').on('click', function(){
                if((keywordInput.val()!=="")){
                    addKeyword();
                }
            });

            // removing keyword
            $(document).on("click",".keyword-remove", function(){
                $(this).parent().addClass('keyword-removed');

                function removeFromMarkup(){
                    $(".keyword-removed").remove();
                }
                setTimeout(removeFromMarkup, 500);
                keywordsList.css({'height':'auto'}).height();
            });


            // animating container height
            keywordsList.on('resizeContainer', function(){
                var heightnow = $(this).height();
                var heightfull = $(this).css({'max-height':'auto', 'height':'auto'}).height();

                $(this).css({ 'height' : heightnow }).animate({ 'height': heightfull }, 200);
            });

            $(window).on('resize', function() {
                keywordsList.css({'height':'auto'}).height();
            });

            // Auto Height for keywords that are pre-added
            $(window).on('load', function() {
                var keywordCount = $('.keywords-list').children("span").length;

                // Enables scrollbar if more than 3 items
                if (keywordCount > 0) {
                    keywordsList.css({'height':'auto'}).height();

                }
            });

        });
    </script>
@endsection
