@extends('admin.layouts.admin-app')

@section('style')
@endsection

@section('content')
    <!-- Dashboard Headline -->
    <div class="dashboard-headline">
        <h3>Manage Settings</h3>

        <!-- Breadcrumbs -->
        <nav id="breadcrumbs" class="dark">
            <ul>
                <li><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
                <li>Settings</li>
            </ul>
        </nav>
    </div>
    <div class="margin-bottom-30">
        <!-- Row -->
        <div class="row">

            <form id="listing-post-form" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="put">
            {{ csrf_field() }}
            <!-- Dashboard Box -->
            <div class="col-xl-12">
                <div class="dashboard-box margin-top-0">

                    <!-- Headline -->
                    <div class="headline">
                        <h3><i class="icon-material-outline-account-circle"></i> My Account</h3>
                    </div>

                    <div class="content with-padding padding-bottom-0">

                        <div class="row">

                            <div class="col-auto">
                                <div class="avatar-wrapper" data-tippy-placement="bottom" title="Change Avatar">
                                    <img class="profile-pic" src="{{ $user->image() }}" alt="" />
                                    <div class="upload-button"></div>
                                    <input class="file-upload" name="image" type="file" accept="image/*"/>
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
                                            <input type="text" name="email" class="with-border" value="{{ $user->email }}">
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="submit-field">
                                            <h5>PayPal Email <i class="icon-feather-info" title="Email can never be changed. Random information placed within each *" data-tippy-placement="top"></i></h5>
                                            @php
                                                $email = explode('@', $global->paypal_email);
                                                $str = substr($email[0], 0, 1).str_repeat('*', strlen($email[0])).substr($email[0], strlen($email[0]), 1)
                                            @endphp
                                            <div>{{ $str }}@ {{ substr($email[1], 0, 0).str_repeat('*', strlen($email[1])).substr($email[1], strlen($email[1]), 1) }}</div>
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
                <div class="dashboard-box margin-top-30">

                    <!-- Headline -->
                    <div class="headline">
                        <h3><i class="icon-material-outline-account-circle"></i> Platform Settings</h3>
                    </div>

                    <div class="content with-padding padding-bottom-0">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="submit-field">
                                    <h5>Commission</h5>
                                    <select class="selectpicker" title="Select commission rate" data-size="4" name="commission_rate">
                                        <option value="1" @if($global->commission_rate == 1) selected @endif>1%</option>
                                        <option value="2" @if($global->commission_rate == 2) selected @endif>2%</option>
                                        <option value="3" @if($global->commission_rate == 3) selected @endif>3%</option>
                                        <option value="4" @if($global->commission_rate == 4) selected @endif>4%</option>
                                        <option value="5" @if($global->commission_rate == 5) selected @endif>5%</option>
                                        <option value="6" @if($global->commission_rate == 6) selected @endif>6%</option>
                                        <option value="7" @if($global->commission_rate == 7) selected @endif>7%</option>
                                        <option value="8" @if($global->commission_rate == 8) selected @endif>8%</option>
                                        <option value="9" @if($global->commission_rate == 9) selected @endif>9%</option>
                                        <option value="10" @if($global->commission_rate == 10) selected @endif>10%</option>
                                        <option value="11" @if($global->commission_rate == 11) selected @endif>11%</option>
                                        <option value="12" @if($global->commission_rate == 12) selected @endif>12%</option>
                                        <option value="13" @if($global->commission_rate == 13) selected @endif>13%</option>
                                        <option value="14" @if($global->commission_rate == 14) selected @endif>14%</option>
                                        <option value="15" @if($global->commission_rate == 15) selected @endif>15%</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="submit-field">
                                    <h5>Cashback</h5>
                                    <select class="selectpicker" title="Select cashback amount" data-size="4" name="cashback_rate">
                                        <option value="1" @if($global->cashback_rate == 1) selected @endif>1%</option>
                                        <option value="2" @if($global->cashback_rate == 2) selected @endif>2%</option>
                                        <option value="3" @if($global->cashback_rate == 3) selected @endif>3%</option>
                                        <option value="4" @if($global->cashback_rate == 4) selected @endif>4%</option>
                                        <option value="5" @if($global->cashback_rate == 5) selected @endif>5%</option>
                                    </select>
                                </div>
                            </div>
                        </div>
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
                                            <input type="text" name="address" value="{{ $user->address }}" class="with-border" placeholder="Start typing address...">
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="submit-field">
                                            <h5>@lang('core.city')</h5>
                                            <input type="text" name="city"  value="{{ $user->city }}"  class="with-border" placeholder="Cleveland">
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="submit-field">
                                            <h5>@lang('core.state')</h5>
                                            <input type="text" name="state"  value="{{ $user->state }}"  class="with-border" placeholder="OH">
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="submit-field">
                                            <h5>@lang('core.zipCode')</h5>
                                            <input type="text" name="zip_code"  value="{{ $user->zip_code }}"  class="with-border" placeholder="44137">
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
                        <h3><i class="icon-material-outline-lock"></i> Phone Verification <i class="icon-feather-info" title="Phone can be verified here or from your badges. Once updated you will receive a badge." data-tippy-placement="top"></i></h3>
                    </div>

                    <div class="content with-padding">
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="submit-field">
                                    <h5>Enter Mobile Number</h5>
                                    <input type="text" class="with-border" placeholder="(216) 518-4236" name="mobile_number" value="{{ $user->mobile_number ?? '' }}">
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
                        <h3><i class="icon-material-outline-lock"></i> Password & Security</h3>
                    </div>

                    <div class="content with-padding">
                        <div class="row">

                            <div class="col-xl-6">
                                <div class="submit-field">
                                    <h5>New Password</h5>
                                    <input type="password" class="with-border" name="password">
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="submit-field">
                                    <h5>Confirm Password</h5>
                                    <input type="password" class="with-border" name="password_confirmation">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            </form>
            <!-- Button -->
            <div class="col-xl-12">
                <a href="javascript:;" onclick="profileUpdate();return false;" class="button ripple-effect big margin-top-30">Save Changes</a>
            </div>
        </div>
    </div>

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


        function profileUpdate () {
            $.easyAjax({
                url: "{!! route('admin.dashboard-setting.update', $user->id) !!}",
                type: "POST",
                container: "#listing-post-form",
                file: true,
                success: function (response) {
                    if(response.status == 'success') {
                        $(window).scrollTop( $("#listing-post-form").offset().top );
                        $('.profile-pic').attr('src', response.image)
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
