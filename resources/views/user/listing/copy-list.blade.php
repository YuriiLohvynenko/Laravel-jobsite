<!doctype html>
<html lang="en">
<head>

    <!-- Basic Page Needs
    ================================================== -->
    <title>taskapron</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/outline.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/colors/blue.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dropzone.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/photoswipe.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/default-skin/default-skin.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/helper/helper.css') }}">

    <script src="{{ asset('js/photoswipe.min.js') }}"></script>
    <script src="{{ asset('js/photoswipe-ui-default.min.js') }}"></script>

<style>
    /*.file-bg {*/
        /*height: 150px;*/
        /*overflow: hidden;*/
        /*position: relative;*/
    /*}*/
    /*.file-bg .overlay-file-box {*/
        /*opacity: .9;*/
        /*position: absolute;*/
        /*top: 0;*/
        /*left: 0;*/
        /*right: 0;*/
        /*height: 100%;*/
        /*text-align: center;*/
    /*}*/

    .button.button-sliding-icon {
        width: auto !important;
    }
</style>

</head>
<body class="gray">

<!-- Tabs Container -->
<div class="tabs margin-bottom-30">
    <div class="tabs-header tabs-white-bg tabs-single-border pure-menu pure-menu-horizontal pure-menu-scrollable">
        <a href="{{ route('user.dashboard.index') }}" class="pure-menu-heading">taskapron</a>
        <ul class="tabs-jobs-group tabs-jobs-icons pure-menu-list">
            <li class="active ripple-effect-dark pure-menu-item">
                <a href="#tab-1" class="pure-menu-link pure-tabs" data-tab-id="1">
                    <div><i class="icon-feather-map-pin"></i>@lang('core.listingOverview')</div>
                    <div class="tab-description">@lang('core.jobDetails')</div>
                </a>
            </li>
            <li class="ripple-effect-dark pure-menu-item">
                <a href="#tab-2" class="pure-menu-link pure-tabs" data-tab-id="2">
                    <div><i class="icon-feather-map-pin"></i> @lang('core.scheduleDate')</div>
                    <div class="tab-description"> @lang('core.dateTime')</div>
                </a>
            </li>
            <li class="ripple-effect-dark pure-menu-item">
                <a href="#tab-3" class="pure-menu-link pure-tabs" data-tab-id="3">
                    <div><i class="icon-feather-map-pin"></i>@lang('core.selectLocation')</div>
                    <div class="tab-description">@lang('core.listingLocation')</div>
                </a>
            </li>
            <li class="ripple-effect-dark pure-menu-item">
                <a href="#tab-4" class="pure-menu-link pure-tabs" data-tab-id="4">
                    <div><i class="icon-feather-map-pin"></i>@lang('core.listingSummary')</div>
                    <div class="tab-description">@lang('core.reviewInformation')</div>
                </a>
            </li>
        </ul>
        <div class="tab-hover desktop-hidden"></div>
        <nav class="tabs-nav blue-nav-tabs">
            <span class="tab-prev"><i class="icon-material-outline-keyboard-arrow-left"></i></span>
            <span class="tab-next"><i class="icon-material-outline-keyboard-arrow-right"></i></span>
        </nav>
    </div>
    <!-- Tab Content -->
    <form method="post" id="listing-post-form" class="listing-post-form">
        {{ csrf_field() }}
        <input type="hidden" name="listing_id" value="{{ $listing->id }}">
        <input type="hidden" name="lat" id="lat" value="">
        <input type="hidden" name="long" id="long" value="">
        <div class="tabs-content tabs-no-space">

                <div class="tab active" data-tab-id="1">
                    <!-- Client Jobs Active (client-active) -->
                    <div class="row">
                        <div class="col-12 ow-container" style="background-color: #f9f9f9 !important;background: #f9f9f9;">
                            <div class="ow-inner-container">

                                <div class="row">
                                    <div class="col-md-4 col-sm-6">
                                        <div class="submit-field">
                                            <h5>@lang('core.jobCategory') <i class="icon-feather-info" title="Clients can search and hire by specialty so choose what best suits you" data-tippy-placement="top"></i></h5>
                                            <select class="selectpicker margin-bottom-0" name="category" data-size="7" title="Select Category" data-live-search="true">
                                                @forelse($categories as $category)
                                                    <option @if($listing->category_id == $category->id) selected @endif value="{{ $category->id }}"> {{ $category->name }}</option>
                                                @empty
                                                    <option value=""> @lang('messages.noCategoryFound')</option>
                                                @endforelse

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-6 center-vertical">
                                        <div class="center">@lang('messages.categoryNote')</div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <section class="section-container">
                        <div class="row">
                                <div class="col-12">
                                    <div class="custom-input material">
                                        <div class="custom-input-head">@lang('core.jobTitle')</div>
                                        <input id="title" name="title" value="{{ ucfirst($listing->job_title) }}" class="custom-focus custom-input-reset custom-input-border filled"></input>
                                        <label for="title" class="custom-input-text custom-input-placeholder ">@lang('messages.titleExp')</label>
                                    </div>
                                </div>
                                <div class="col-12 margin-top-20">
                                    <div class="custom-input material">
                                        <div class="custom-input-head">@lang('core.jobDescription')</div>
                                        <textarea id="description" name="description" class="custom-focus custom-input-reset custom-textarea custom-input-border filled">{{ ucwords($listing->description) }}</textarea>
                                        <label for="description" class="custom-textarea-text custom-input-placeholder">@lang('messages.jobDescriptionNote') <i class="icon-feather-info" title="@lang('messages.jobDescriptionTitleNote')" data-tippy-placement="top"></i></label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="custom-radio">
                                        <div class="custom-input-head">@lang('core.materialsTravel')</div>
                                        <div class="radio custom-radio-">
                                            <input id="radio-1" value="included_in_budget" name="materials" type="radio" @if($listing->materials == 'included_in_budget') checked @endif >
                                            <label for="radio-1"><span class="radio-label"></span>@lang('core.includedBudget') </label>
                                        </div>
                                        <br>
                                        <div class="radio custom-radio-">
                                            <input id="radio-2" value="not_required" name="materials" type="radio" @if($listing->materials == 'not_required') checked @endif>
                                            <label for="radio-2"><span class="radio-label"></span>@lang('core.noneRequired')</label>
                                        </div>
                                        <br>
                                        <div class="radio custom-radio-">
                                            <input id="radio-3" value="not_included"  name="materials" type="radio" @if($listing->materials == 'not_included') checked @endif>
                                            <label for="radio-3"><span class="radio-label"></span>@lang('core.notIncluded') <i class="icon-feather-info" title="@lang('messages.notIncludedNote')" data-tippy-placement="top"></i></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 margin-top-20">
                                    <form action="{{ route('listing.file-upload') }}" id="dropzone-form" class="dropzone">
                                        <input type="hidden" name="dropZoneListing" id="dropZoneListing">
                                        <div class="dropzone"></div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                        </div>

                    </section>
                </div>
                <div class="tab" data-tab-id="2">
                    <!-- Client Jobs Active (client-active) -->
                    <div class="row">
                        <div class="col-12 ow-container" style="background-color: #f9f9f9;background: #f9f9f9;">
                            <div class="ow-inner-container">

                                <div class="row">
                                    <div class="col-md-4 col-sm-6">
                                        <div class="custom-input-head margin-bottom-5">@lang('core.select') @lang('core.dateTime')</div>
                                        <input class="posting-date" id="date_time" name="date_time" data-timepicker="true" value="" data-time-format='hh:ii aa' placeholder="@lang('messages.dateTimeTitle')"></input>
                                    </div>
                                    <div class="col-md-8 col-sm-6 center-vertical">
                                        <div class="center">@lang('messages.dateTimeNote')</div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <section class="section-container">

                            <div class="row margin-bottom-30">
                                <div class="col-md-6">
                                    <div class="custom-input input-with-icon custom-input-with-icon material">
                                        <div class="custom-input-head">@lang('core.budget')</div>
                                        <input id="budget1" name="budget" onkeyup="budgeChange(this.value)" class="custom-focus custom-input-reset custom-input-border"></input>
                                        <i class="currency">USD</i>
                                        <label for="budget1" id="budgeLabel" class="custom-input-text custom-input-placeholder">$0</label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 center-vertical">
                                    <a href="javascript:;" style="width:auto;" onclick="budgetDate(); return false;" class="button button-sliding-icon ripple-effect center">@lang('core.addSelectedDate') <i class="icon-material-outline-arrow-right-alt"></i></a>
                                </div>
                                <div class="col-md-2 col-sm-6 pull-right">
                                    <div class="custom-input-head">@lang('core.total') @lang('core.budget')</div>
                                    <div class="" id="totalBudget">$0</div>
                                </div>
                            </div>
                            <div class="row margin-top-20">
                                <div class="col-md-6 col-sm-12">
                                    <div class="custom-input-head margin-bottom-10">@lang('messages.selectedDateNote')</div>
                                    <span class="posting-badge posting-badge-gray">@lang('core.ChangeDates')</span>
                                    <div class="row margin-top-30" id="detailBudget">
                                        {{--@forelse($listing->budgetDetails as $index => $budgetDetail)--}}
                                            {{--<div class="col-12 margin-bottom-10" id="budgetDetail{{ $index }}">--}}
                                                {{--<span class="posting-badge"><i onclick="removeDetail({{ $index }})" class="icon-feather-x"></i> Fixed - ${{ $budgetDetail->budget }} | {{ $budgetDetail->date_time->format('D, F dS, Y - h:ia') }}</span>--}}
                                                {{--<input type="hidden" name="budgetValue[]" value="{{ $budgetDetail->budget }}">--}}
                                                {{--<input type="hidden" name="budgetDate[]" value="{{ $budgetDetail->date_time->format('m/d/Y h:i a') }}">--}}
                                            {{--</div>--}}
                                        {{--@empty--}}
                                        {{--@endforelse--}}
                                    </div>
                                </div>
                            </div>

                    </section>

                </div>

                <div class="tab" data-tab-id="3">
                    <!-- Client Jobs Active (client-active) -->
                    <div class="row">
                        <div class="col-12 ow-container" style="background-color: #f9f9f9;background: #f9f9f9;">
                            <div class="ow-inner-container">

                                <div class="row">
                                    <div class="col-md-4 col-sm-6">
                                        <div class="submit-field">
                                            <h5>@lang('core.jobLocation')<i class="icon-feather-info" title="@lang('messages.jobLocationTitle')" data-tippy-placement="top"></i></h5>
                                            <select class="selectpicker" name="job_location" title="@lang('messages.ChooseLocation')">
                                                <option data-subtext="on_location" @if($listing->job_location == 'on_location') selected @endif value="on_location">@lang('core.onSite')</option>
                                                <option data-subtext="online" @if($listing->job_location == 'online') selected @endif value="online">@lang('core.remote')</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-6 center-vertical">
                                        <div class="center">@lang('messages.locationNote')</div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <section class="section-container">
                            <div class="row">
                                <div class="col-12 margin-bottom-30">
                                    <div class="assistance-head margin-bottom-5">@lang('messages.findingHelp')</div>
                                    <div class="assistance-sub">@lang('messages.assistanceNote')</div>
                                </div>
                                <div class="col-md-8 col-sm-12">
                                    <!-- Account Type -->
                                    <div class="submit-field">
                                        <h5>@lang('core.immediateAssistance')</h5>
                                        <div class="account-type">
                                            <div>
                                                <input type="radio" value="not_required" name="immediate_assistance" id="freelancer-radio" class="account-type-radio" @if($listing->immediate_assistance == 'not_required') checked @endif/>
                                                <label for="freelancer-radio" class="ripple-effect-dark"><i class="icon-material-outline-account-circle"></i> @lang('core.notRequired')</label>
                                            </div>

                                            <div>
                                                <input type="radio" value="required" name="immediate_assistance" id="employer-radio" class="account-type-radio" @if($listing->immediate_assistance == 'required') checked @endif/>
                                                <label for="employer-radio" class="ripple-effect-dark"><i class="icon-material-outline-business-center"></i> @lang('core.ImmediateRequired')</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="margin-bottom-30">*@lang('messages.addressNote')</div>
                        <div class="form">
                            <div class="row margin-bottom-50">
                                <div class="col-12">
                                    <div class="custom-input material">
                                        <div class="custom-input-head">@lang('core.address')</div>
                                        <input id="gmap_geocoding_address" name="address" value="{{ $listing->address }}" class="custom-focus custom-input-reset custom-input-border filled" placeholder="" onFocus="geolocate()">
                                        <label for="gmap_geocoding_address" class="custom-input-text custom-input-placeholder">@lang('messages.startTypingAdd')</label>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="custom-input material">
                                        <div class="custom-input-head">@lang('core.streetAddress')</div>
                                        <input id="street_address" name="street_address"  value="{{ $listing->street_address }}"  class="custom-focus custom-input-reset custom-input-border filled">
                                        <label for="street_address" class="custom-input-text custom-input-placeholder">@lang('core.streetAddressEnter')</label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="custom-input material">
                                        <div class="custom-input-head">@lang('core.city')</div>
                                        <input id="city1" name="city"  value="{{ $listing->city }}"  class="custom-focus custom-input-reset custom-input-border filled">
                                        <label for="city1" class="custom-input-text custom-input-placeholder">@lang('core.enterCity')</label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="custom-input material">
                                        <div class="custom-input-head">@lang('core.state')</div>
                                        <input id="state1" name="state"  value="{{ $listing->state }}" class="custom-focus custom-input-reset custom-input-border filled">
                                        <label for="state1" class="custom-input-text custom-input-placeholder">@lang('core.enterState')</label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="custom-input material">
                                        <div class="custom-input-head">@lang('core.zip')</div>
                                        <input id="postal_code" name="zip"  value="{{ $listing->zip_code }}"  class="custom-focus custom-input-reset custom-input-border filled">
                                        <label for="postal_code" class="custom-input-text custom-input-placeholder">@lang('core.enterZipCode')</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </section>
                </div>

                <div class="tab" data-tab-id="4">
                    <!-- Client Jobs Active (client-active) -->
                    <div class="row">
                        <div class="col-12 ow-container" style="background-color: #f9f9f9;background: #f9f9f9;">
                            <div class="ow-inner-container">

                                <div class="row">
                                    <div class="col-md-4 col-sm-6">
                                        <div class="submit-field">
                                            <h5><a href="#">@lang('core.termsService')</a> (TOS) <i class="icon-feather-info" title="@lang('messages.termServicesNote')" data-tippy-placement="top"></i></h5>
                                            <select class="selectpicker" name="term_condition" onchange="checkButton(this.value)" title="@lang('messages.selectTerm')">
                                                <option  @if($listing->job_location == 'agree') selected @endif  value="agree" selected>@lang('messages.iAgree')</option>
                                                <option @if($listing->job_location == 'disagree') selected @endif value="disagree">@lang('messages.iDisAgree')</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-6 center-vertical">
                                        <div class="center">@lang('messages.policyNote')</div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <section class="section-container">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 margin-bottom-30">
                                <div class="posting-summary-title margin-bottom-5">@lang('core.listingPolicy')</div>
                                <div class="posting-summary-description margin-bottom-15">@lang('messages.policyDescription')</div>
                                <ul class="list-2 posting-summary-checklist">
                                    <li>@lang('messages.policyDescriptionOne')</li>
                                    <li>@lang('messages.policyDescriptionTwo') <i class="icon-feather-info" title="@lang('messages.policyDescriptionTwoTitle')" data-tippy-placement="top"></i></li>
                                    <li>@lang('messages.policyDescriptionThree') <i class="icon-feather-info" title="@lang('messages.policyDescriptionThreeTitle')" data-tippy-placement="top"></i></li>
                                    <li>@lang('messages.policyDescriptionFour')</li>
                                    <li>@lang('messages.policyDescriptionFive') <i class="icon-feather-info" title="@lang('messages.policyDescriptionFiveTitle')" data-tippy-placement="top"></i></li>
                                </ul>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="summary-box">
                                    <div class="summary-box-head">1%</div>
                                    <div class="summary-box-title">@lang('core.cashback')</div>
                                    <div class="summary-box-description margin-top-15">@lang('messages.cashbackNote')</div>
                                </div>
                                <div class="summary-box">
                                    <div class="summary-box-head">11%</div>
                                    <div class="summary-box-title">@lang('core.listingFees')</div>
                                    <div class="summary-box-description margin-top-15">@lang('messages.listingFeeNote')</div>
                                </div>
                            </div>
                        </div>
                        <div class="row margin-top-50">
                            <div class="col-12">
                                <a href="javascript:;" onclick="submitForm(); return false;" class="button button-sliding-icon ripple-effect pull-right">@lang('core.postListing') <i class="icon-material-outline-arrow-right-alt"></i></a>
                            </div>
                        </div>
                    </section>
                </div>

        </div>
    </form>
    <div id="small-dialog-17" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
        <!--Tabs -->
        <div class="sign-in-form">
            <div class="popup-tabs-container">
                <!-- Tab -->
                <div class="popup-tab-content" id="tab">
                    <!-- Welcome Text -->
                    <div class="padding-bottom-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="modal-main">Confirm Budget Detail Removal</div>
                            </div>
                            <div class="col-12">
                                <div class="modal-head-">Are you sure you want to remove this detail?</div>
                            </div>
                        </div>
                        <div class="row margin-top-40">
                            <div class="col-6">
                                <input type="hidden" id="detailIndex">
                                <a href="" id="message-sent" class="popup-with-zoom-anim button gray ripple-effect">Yes</a>
                            </div>
                            <div class="col-6">
                                <a href="" id="message-sent" class="popup-with-zoom-anim button button-sliding-icon ripple-effect">No <i class="icon-material-outline-arrow-right-alt"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts
================================================== -->

<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/jquery-migrate-3.0.0.min.js') }}"></script>
<script src="{{ asset('js/mmenu.min.js') }}"></script>
<script src="{{ asset('js/tippy.all.min.js') }}"></script>
<script src="{{ asset('js/simplebar.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-slider.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/snackbar.js') }}"></script>
<script src="{{ asset('js/clipboard.min.js') }}"></script>
<script src="{{ asset('js/counterup.min.js') }}"></script>
<script src="{{ asset('js/magnific-popup.min.js') }}"></script>
<script src="{{ asset('js/slick.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{ asset('js/datepicker.min.js') }}"></script>
<script src="{{ asset('js/datepicker.en.js') }}"></script>
<script src="{{ asset('js/dropzone.js') }}"></script>
<script src="{{ asset('plugins/helper/helper-listing.js') }}"></script>
<script>
    //Disabling autoDiscover
    Dropzone.autoDiscover = false;

    $(function() {
        //Dropzone class
         myDropzone = new Dropzone(".dropzone", {
            url: "{{ route('listing.file-upload') }}",
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            paramName: "file",
            maxFilesize: 2,
            maxFiles: 10,
            acceptedFiles: "image/*,application/pdf",
            autoProcessQueue: false,
            uploadMultiple: true,
             addRemoveLinks:true,
             parallelUploads:10
        });
        myDropzone.on('sending', function(file, xhr, formData) {
            // Append all form inputs to the formData Dropzone will POST
            var data = $('#dropzone-form').serializeArray();
            var ids = $('#dropZoneListing').val();
            formData.append('listingID', ids);
        });
        myDropzone.on("addedfiles", function(files) {
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
        });
        myDropzone.on('complete', function () {
            window.location.href = '{{ route('user.listing.index') }}'
        });

        @php
            function getRemoteFilesize($file_url, $formatSize = true)
            {
                $head = array_change_key_case(get_headers($file_url, 1));
                // content-length of download (in bytes), read from Content-Length: field

                $clen = isset($head['content-length']) ? $head['content-length'] : 0;

                // cannot retrieve file size, return "-1"
                if (!$clen) {
                    return -1;
                }

                if (!$formatSize) {
                    return $clen;
                    // return size in bytes
                }

                $size = $clen;
                switch ($clen) {
                    case $clen < 1024:
                        $size = $clen .' B'; break;
                    case $clen < 1048576:
                        $size = round($clen / 1024, 2) .' KB'; break;
                    case $clen < 1073741824:
                        $size = round($clen / 1048576, 2) . ' MB'; break;
                    case $clen < 1099511627776:
                        $size = round($clen / 1073741824, 2) . ' GB'; break;
                }

                return $size;
                // return formatted size
            }
        @endphp



            @foreach($listing->files as $file)

            var file = {
                name: '{{ $file->file_name .'.'.$file->file_format }}',
                size: '{{ getRemoteFilesize(asset('listing-files/'.$file->file_name .'.'.$file->file_format)) }}'
            };
            myDropzone.options.addedfile.call(myDropzone, file);
            @if($file->file_format != 'pdf')
                myDropzone.options.thumbnail.call(myDropzone, file, '{{ asset('listing-files/'.$file->file_name .'.'.$file->file_format) }}');
            @endif
            @endforeach
    });
</script>
<script>
    // Snackbar for user status switcher
        $('#snackbar-user-status label').click(function() {
            Snackbar.show({
                text: 'Your status has been changed!',
                pos: 'bottom-center',
                showAction: false,
                actionText: "Dismiss",
                duration: 3000,
                textColor: '#fff',
                backgroundColor: '#383838'
            });
        });

        $('.posting-date').datepicker({
            language: 'en',
            inline: false,
        })

        var inputBox = document.getElementById('chatinput');

        inputBox.onkeyup = function(){
            document.getElementById('printchatbox').innerHTML = inputBox.value;
    }

    // Set budget amount and date detail
    function budgetDate(){
        var indexCount = $('input[name="budgetValue[]"]').length;
        var dateTime   = $('#date_time').val();
        var budget     = $('#budget1').val();

        if(dateTime === '' || dateTime === undefined || dateTime === null){
            Snackbar.show({
                text: 'Date field can not be blank!',
                pos: 'bottom-center',
                showAction: false,
                actionText: "Dismiss",
                duration: 3000,
                textColor: '#fff',
                backgroundColor: '#ed6359'
            });
            return false;
        }
        else{
            var dateFormat = formatDate( new Date(dateTime));
        }
        // Check amount field blank or not
        if(budget === '' || budget === undefined || budget === null){
            Snackbar.show({
                text: 'Budget amount can not be blank!',
                pos: 'bottom-center',
                showAction: false,
                actionText: "Dismiss",
                duration: 3000,
                textColor: '#fff',
                backgroundColor: '#ed6359'
            });
            return false;
        }
        var statementContinue = true;
        $('input[name^="budgetDate"]').each(function() {

            var dateData = $(this).val();
            var dateTime = $('#date_time').val();
            if (dateData !== 0 && dateTime !== undefined){
                    dateData = new Date(dateData);
                    dateTime = new Date(dateTime);
                    var d1 = dateData.getTime();
                    var d2 = dateTime.getTime();
                if (d1 === d2) {
                    Snackbar.show({
                        text: 'The date and time already exists!',
                        pos: 'bottom-center',
                        showAction: false,
                        actionText: "Dismiss",
                        duration: 3000,
                        textColor: '#fff',
                        backgroundColor: '#ed6359'
                    });
                    statementContinue = false;
                    return false;
                }
            }
        });

      if(statementContinue === true){
          var htmlDate ='<div class="col-12 margin-bottom-10" id="budgetDetail'+indexCount+'">' +
              '<span class="posting-badge"><i onclick="removeDetail('+indexCount+')" class="icon-feather-x"></i> Fixed - $'+budget+' | '+dateFormat+'</span>' +
              '<input type="hidden" name="budgetValue[]" value="'+budget+'">' +
              ' <input type="hidden" name="budgetDate[]" value="'+dateTime+'">' +
              '</div>';

          $('#detailBudget').append(htmlDate);
          var total = 0;
          $('input[name^="budgetValue"]').each(function() {
              total += parseInt($(this).val());
          });
          $('#totalBudget').html('$'+total);
      }
    }

    // change amount in budget label
    function budgeChange(val){
        $('#budgeLabel').html('$'+val);
    }
    function removeDetail(index){
        $('#budgetDetail'+index).remove();
        var total = 0;
        $('input[name^="budgetValue"]').each(function() {
            total += parseInt($(this).val());
        });
        $('#totalBudget').html('$'+total);
    }

//    function removeConfirm(){
//       var index = $("#detailIndex").val();
//        $('#budgetDetail'+index).remove();
//        $("#detailIndex").val('');
//        $("#small-dialog-17").dialog("close");
//    }

    function formatDate(date) {
        var monthNames = [
            "January", "February", "March",
            "April", "May", "June", "July",
            "August", "September", "October",
            "November", "December"
        ];
        var dayNames = [
            "Sunday", "Monday", "Tuesday",
            "Wednesday", "Thursday", "Friday", "Saturday"
        ];

        var day = date.getDate();
        var dayName = date.getDay();
        var monthIndex = date.getMonth();
        var year = date.getFullYear();
        var hrs = getHours(date);

        return dayNames[dayName] + ',  ' +monthNames[monthIndex] + ' ' + day + ',  ' + year + ' - ' + hrs;
    }

    function getHours (d){
        var h = (d.getHours() % 12) || 12; // show midnight & noon as 12
        return (
            ( h < 10 ? '0' : '') + h+
            ( d.getMinutes() < 10 ? ':0' : ':') + d.getMinutes()+
            // optional seconds display
            // ( d.getSeconds() < 10 ? ':0' : ':') + d.getSeconds() +
            ( d.getHours() < 12 ? ' am' : ' pm' )
        );
    }

    // Update selector to match your button
    function submitForm() {
        $.easyAjax({
            url: "{!! route('listing.copy-submit', $listing->id) !!}",
            type: "POST",
            container: ".listing-post-form",
            data: $(".listing-post-form").serialize(),
            success: function (response) {
                if(response.status == 'success') {
                    $('#dropZoneListing').val(response.listingID);
                    myDropzone.processQueue();
                    $(window).scrollTop( $("#listing-post-form").offset().top );
                }
            }
        });
        return false;
    }

</script>

<script src="{{ asset('js/chart.min.js') }}"></script>
<script>
    Chart.defaults.global.defaultFontFamily = "Nunito";
    Chart.defaults.global.defaultFontColor = '#888';
    Chart.defaults.global.defaultFontSize = '14';
</script>

<script>
    function checkButton (val) {
        //console.log(val);
    }

</script>

<script>
    // This sample uses the Autocomplete widget to help the user select a
    // place, then it retrieves the address components associated with that
    // place, and then it populates the form fields with those details.
    // This sample requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script
    // src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

    var placeSearch, autocomplete;

    var componentForm = {
        street_address: 'long_name',
        city1: 'long_name',
        state1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };

    function initAutocomplete() {
        // Create the autocomplete object, restricting the search predictions to
        // geographical location types.
        autocomplete = new google.maps.places.Autocomplete(
            document.getElementById('gmap_geocoding_address'), {types: ['geocode']});

        // Avoid paying for data that you don't need by restricting the set of
        // place fields that are returned to just the address components.
        // autocomplete.setFields(['address_component']);

        // When the user selects an address from the drop-down, populate the
        // address fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
    }

    function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        $('#lat').val(place.geometry.location.lat());
        $('#long').val(place.geometry.location.lng());

        // Get each component of the address from the place details,
        // and then fill-in the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            for (var j = 0; j < place.address_components[i].types.length; j++) {
                if (place.address_components[i].types[j] == "postal_code") {
                    $('#postal_code').addClass('filled');
                    $('#postal_code').val(place.address_components[i].long_name);
                }
                if (place.address_components[i].types[j] == "administrative_area_level_1") {
                    $('#state1').addClass('filled');
                    $('#state1').val(place.address_components[i].long_name);
                }
                if (place.address_components[i].types[j] == "locality") {
                    $('#city1').addClass('filled');
                    $('#city1').val(place.address_components[i].long_name);
                }
                if (place.address_components[i].types[j] == "street_number") {
                    street_number = place.address_components[i].long_name;
                }
                if (place.address_components[i].types[j] == "route") {
                    $('#street_address').addClass('filled');
                    $('#street_address').val(street_number + " " + place.address_components[i].long_name);
                }
            }
        }
    }

    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle(
                    {center: geolocation, radius: position.coords.accuracy});
                autocomplete.setBounds(circle.getBounds());
            });
        }
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBEySfWxTzjYb1NKEsCbk0y7Nu76mK_yYk&libraries=places&callback=initAutocomplete"
        async defer></script>

</body>
</html>
