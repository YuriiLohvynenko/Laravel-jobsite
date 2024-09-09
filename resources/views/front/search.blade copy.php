<!doctype html>
<html lang="en">
<head>

    <!-- Basic Page Needs
    ================================================== -->
    <title>{{ $title ?? '' }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    @include('front.sections.head')
    
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.toast-top-full-width{top:0;right:0;width:30%}
</style>
</head>
<body>

<!-- Wrapper -->
<div id="wrapper">

    <!-- Header Container
    ================================================== -->
    <header id="header-container" class="fullwidth not-sticky">

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

    <!-- Page Content
    ================================================== -->
    <div class="full-page-container with-map">

        <div class="full-page-sidebar hidden-sidebar enabled-sidebar">
            <div class="full-page-sidebar-inner" data-simplebar>

                <div class="sidebar-container">
                    <!-- Location -->
                    <div class="sidebar-widget">
                        <div class="row find_title">
                            <div class="col-6">
                                <h3>Find</h3>
                            </div>
                            <div class="col-6 float-right">
                                <img src="{{ asset('images/customize/round-icon.png') }}" class="round-rect-icon" />
                            </div>
                        </div>    

                        <span>Location</span>

                        <div class="row location-select-row">
                            <div class="col-10 padding-left-0">
                                <input id="location" name="location" type="text" placeholder="Maple Heights, Ohio" />
                            </div>
                            <div class="col-2 location-input-wrapper padding-right-0">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="s-ion-icon"><path d="M256 176c-44.004 0-80.001 36-80.001 80 0 44.004 35.997 80 80.001 80 44.005 0 79.999-35.996 79.999-80 0-44-35.994-80-79.999-80zm190.938 58.667c-9.605-88.531-81.074-160-169.605-169.599V32h-42.666v33.067c-88.531 9.599-160 81.068-169.604 169.599H32v42.667h33.062c9.604 88.531 81.072 160 169.604 169.604V480h42.666v-33.062c88.531-9.604 160-81.073 169.605-169.604H480v-42.667h-33.062zM256 405.333c-82.137 0-149.334-67.198-149.334-149.333 0-82.136 67.197-149.333 149.334-149.333 82.135 0 149.332 67.198 149.332 149.333S338.135 405.333 256 405.333z"></path></svg>
                            </div>
                        </div>
                        <div class="row margin-top-55">
                            <div class="col-12">
                                <!-- Range Slider -->
                                <input id="radius" name="radius" class="range-slider-single" type="text" data-slider-min="1" data-slider-max="1000" data-slider-step="1" data-slider-value="10" />
                            </div>
                        </div>
                    </div>

                    <!-- Keywords -->
                    <div class="sidebar-widget search-result-wrapper">
                        <div class="row">
                            <div class="col-12">
                                <div class="col-8 padding-left-0 search-input-section">
                                    <div class="form-group has-search">
                                        <span class="fa fa-search form-control-feedback"></span>
                                        <input type="text" class="form-control" placeholder="Search">
                                    </div>
                                </div>
                                <div class="col-4 padding-right-0 search-result-section">
                                    <span class="search_results_num">0</span>
                                    <span class="search_results_text">Results</span>
                                    <img src="{{ asset('/images/customize/horizontal_slider_icon.png') }}" class="horizontal_slider_icon" alt="Horizontal Slider Icon" /> 
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Sidebar Container / End -->

            </div>
        </div>
        <!-- Full Page Sidebar / End -->

        <!-- Full Page Content -->
        <div class="full-page-content-container" data-simplebar>
            <div class="full-page-content-inner padding-top-0">
                <div class="row margin-top-10 margin-bottom-0">
                    <div class="col-6">
                        <div></div>
                    </div>
                    <div class="col-6">
                        <div class="expand-filters"><i class="icon-feather-sliders"></i> Expand Filters</div>
                    </div>
                </div>

                <h3 class="page-title">Browse Jobs</h3>

                <div class="notify-box margin-top-15">
                    <div class="switch-container">
                        <label class="switch"><input type="checkbox" onchange="checkboxcheckfilter(this)" id="checkbox"><span class="switch-button"></span><span class="switch-text">Get text alerts for this search</span></label>
                    </div>

                    <div class="sort-by">
                        <span>Sort by:</span>
                        <select id="sortBy" onchange="searchData()" class="selectpicker hide-tick">
                            <option value="relevance">Relevance</option>
                            <option value="newest">Newest</option>
                            <option value="oldest">Oldest</option>
                            <option value="urgency">Urgency</option>
                        </select>
                    </div>
                </div>

                <div id="listingDataList" class="listings-container compact-list-layout margin-top-15 margin-bottom-25">

                    @include('front.search-list', ['searchListings' => $searchListings])

                </div>

                <!-- Pagination -->
                <div class="clearfix"></div>
                <div class="pagination-container margin-top-20 margin-bottom-20">
                    <nav class="pagination">
					<?php //$currentPage; ?>
                        <ul id="pageButtonList">
                            <li class="pagination-arrow" id="previousPage"><a href="javascript:;" class="ripple-effect"><i class="icon-material-outline-keyboard-arrow-left"></i></a></li>
							
                            @for ($i = 1; $i <= $totalPage; $i++)
                                <li><a href="javascript:;" id="pageButtonNo{{ $i }}" data-page-no="{{ $i }}" class="ripple-effect page-no-button">{{ $i }}</a></li>
                            @endfor
                            <li class="pagination-arrow" ><a href="javascript:;" id="nextPage" class="ripple-effect"><i class="icon-material-outline-keyboard-arrow-right"></i></a></li>
                        </ul>
                    </nav>
                </div>
                <div class="clearfix"></div>
                <!-- Pagination / End -->

                <!-- Footer -->
                <div class="small-footer margin-top-15">
                    <div class="small-footer-copyrights">
                        © 2019 <strong>Hireo</strong>. All Rights Reserved.
                    </div>
                    <ul class="footer-social-links">
                        <li>
                            <a href="#" title="Facebook" data-tippy-placement="top">
                                <i class="icon-brand-facebook-f"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="Twitter" data-tippy-placement="top">
                                <i class="icon-brand-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="Google Plus" data-tippy-placement="top">
                                <i class="icon-brand-google-plus-g"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="LinkedIn" data-tippy-placement="top">
                                <i class="icon-brand-linkedin-in"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <!-- Footer / End -->

            </div>
        </div>
        <!-- Full Page Content / End -->


        <!-- Full Page Map -->
        <div class="full-page-map-container">

            <!-- Enable Filters Button -->
            <div class="filter-button-container">
                <button class="enable-filters-button active">
                    <i class="enable-filters-button-icon"></i>
                    <span class="show-text">Show Filters</span>
                    <span class="hide-text">Hide Filters</span>
                </button>
                <div class="filter-button-tooltip">Click to expand sidebar with filters!</div>
            </div>

            <!-- Map -->
            <div id="map" data-map-zoom="5"  data-map-scroll="true"></div>
        </div>
        <!-- Full Page Map / End -->

    </div>


</div>
<div id="sign-in">
    @include('common.sign-in');
</div>

<!-- Wrapper / End -->
<script src="{{ asset('js/jquery-3.3.1.min.js')}}"></script>

<script src="{{ asset('js/jquery-migrate-3.0.0.min.js')}}"></script>
<script src="{{ asset('js/mmenu.min.js')}}"></script>
<script src="{{ asset('js/tippy.all.min.js')}}"></script>
<script src="{{ asset('js/simplebar.min.js')}}"></script>
<script src="{{ asset('js/bootstrap-slider.min.js')}}"></script>
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/snackbar.js')}}"></script>
<script src="{{ asset('js/clipboard.min.js')}}"></script>
<script src="{{ asset('js/counterup.min.js')}}"></script>
<script src="{{ asset('js/magnific-popup.min.js')}}"></script>
<script src="{{ asset('js/slick.min.js')}}"></script>
<script src="{{ asset('js/toastr.js')}}"></script>
<script src="{{ asset('js/toastrscript.js')}}"></script>
<script src="{{ asset('js/custom.js')}}"></script>
<script src="{{ asset('plugins/helper/helper.js') }}"></script>
<script src="{{ asset('plugins/helper/helper-listing-login.js') }}"></script>
<!-- Scripts
================================================== -->

<!-- Snackbar // documentation: https://www.polonel.com/snackbar/ -->
<script>
    //pagination details
    var totalRecord  = {{ $totalRecord }};
    var currentPage  = {{ $currentPage }};
    var totalPage    = {{ $totalPage }};
    var startRec     = {{ $startRec }};
    var endRec       = {{ $endRec }};
    var filter = false;
    var latlng = {};

    function changeBookmark(url, ele) {
        $.easyAjax({
            url: url,
            type: "GET",
            container: "#listingDataList",
            success: function (response) {
                if(response.action == 'add'){
                    ele.addClass('bookmarked');
                }
                else{
                    ele.removeClass('bookmarked');
                }
            }
        });
    }

    $('#onGoing,#temporary').change(function() {
        if ($(this).is(':checked')) {
            $(this).val('on')
        }
        else {
            $(this).val('off')
        }
    })

    function getCurrentLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var geocoder = new google.maps.Geocoder;
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                latlng = {lat: parseFloat(latitude), lng: parseFloat(longitude)}
                geocoder.geocode({'location': latlng}, function(results, status) {
                    if (status === 'OK') {
                        if (results[0]) {
                            for (var i = 0; i < results[0].address_components.length; i++) {
                                var types = results[0].address_components[i].types;

                                for (var typeIdx = 0; typeIdx < types.length; typeIdx++) {
                                    if (types[typeIdx] == 'postal_code') {
										var r = confirm("Want to share Location!");
										if (r == true) {
										  $('#location').val(results[0].address_components[i].short_name);
										} else {
											$('#location').val('');
										}
                                    }
                                }
                            }
                        } else {
                            console.log("No results found");
                        }
                    }
                })
            });
        }
    }

    //get filtering condition
    function getFormData(){
        var formdata = {};
        var keyword = [];
        var findClass = $('.keywords-container').find(".keyword-input-val");
        let location = $('#location').val().toLowerCase();
        var promise = '';

        if (findClass.length !== 0) {
            $('input[name^="keyword"]').each(function() {
                keyword.push($(this).val());
            });
        }

        if (location !== '' && location !== 'remote') {
            var geocoder = new google.maps.Geocoder;
            promise = new Promise((resolve, reject) => {
                geocoder.geocode({
                    'address': location,
                    'componentRestrictions': {
                        'postalCode': location
                    }}, function(results, status) {
                    if (status === 'OK') {
                        if (results.length) {
                           resolve(results[0]); // or `resolve(results)` to deliver all results
                        } else {
                            reject(new Error('No results found'));
                        }
                    } else {
                        if (results.length == 0) {
							funcBtns.alertError();
                            resolve(latlng);
                        }
                        reject(new Error('Geocoder failed due to: ' + status));
                    }
                });
            })
        }
        else {
            promise = location;
        }
		<?php if($user){  ?>
		var userid = <?=$user->id?>;
		<?php }else{ ?>
		var userid = '';
		<?php } ?>
		var locations = $("#location").val();
        formdata = {
            'id' 			: userid,
            'location' 		: locations,
            'radius' 		: $('#radius').val(),
            'categoryID'    : $('#catID').val().sort(),
            'sortBy'    	: $('#sortBy').val(),
            'keyword'   	: keyword.sort(),
            'onGoing'   	: $('#onGoing').val(),
            'temporary' 	: $('#temporary').val(),
            'minimum' 		: $('#min').val(),
            'maximum'	    : $('#max').val(),
			'_token' 		:  '{{ csrf_token() }}',
        };

        return { promise, formdata };
    }

    function searchData(){
        filter = true;
        paginationRequest(1);
    }

    //check pagination should be continue or not
    function checkPaging(){
        if(totalPage > currentPage){
            // next button disable
        }
        if(currentPage === 1){
            //previous button disable
        }
    }

    $('body').on('click', '#nextPage', function(e) {
        e.preventDefault();
        if(totalPage > currentPage){
            var pageNo = (parseInt(currentPage)+1);
            paginationRequest(pageNo);
        }

    });

    $('body').on('click', '#previousPage', function(e) {
        e.preventDefault();
        if(currentPage > 1){
            var pageNo = (parseInt(currentPage)-1);
            paginationRequest(pageNo);
        }
    });

    $('body').on('click', '.page-no-button', function(e) {
        e.preventDefault();
        var pageNo = $(this).data('page-no');
        paginationRequest(pageNo);
    });

    function getListings(data, pageNo) {
					// console.log(data);
					if(data != ''){
					if(data.categoryID.length > 2){
						funcBtns.alertError2();
					}else{
						if(data.categoryID == '' && data.keyword.length == 0 && !data.location){	
						$("#checkbox").prop('checked',false);
						}
        let url = '{{ route('front.search', [':catID', ':key'] ) }}'+'?page='+pageNo;
        url.replace(':catID', '{{ $catID }}');
        url.replace(':key', '{{ $key }}');

        $.easyAjax({
            url: url,
            type: "GET",
            container: "#listingDataList",
            data:data,
            success: function (response) {
				if(response.status == 1){
				$("#checkbox").prop('checked',true);
				}else{
				$("#checkbox").prop('checked',false);
				}
                $('#listingDataList').html(response.view);
                $(".current-page").removeClass("current-page");
                $("#pageButtonNo"+currentPage).addClass("current-page");
                if(filter === true){
                    $('#pageButtonList').html(response.pagination);
                }
                filter = false;
                checkPaging();
                const listings = response.listings;
                mainMap(getLocations(listings));
                if (listings.length>0) {
                    map.setCenter(new google.maps.LatLng(listings[0].latitude, listings[0].longitude))
                }
                else {
                    map.setCenter(new google.maps.LatLng(latlng.lat, latlng.lng))
                }
            }
        });
		}
	  }else{
		 let url = '{{ route('front.search', [':catID', ':key'] ) }}'+'?page='+pageNo;
        url.replace(':catID', '{{ $catID }}');
        url.replace(':key', '{{ $key }}');

        $.easyAjax({
            url: url,
            type: "GET",
            container: "#listingDataList",
            data:data,
            success: function (response) {
				if(response.status == 1){
				$("#checkbox").prop('checked',true);
				}else{
				$("#checkbox").prop('checked',false);
				}
                $('#listingDataList').html(response.view);
                $(".current-page").removeClass("current-page");
                $("#pageButtonNo"+currentPage).addClass("current-page");
                if(filter === true){
                    $('#pageButtonList').html(response.pagination);
                }
                filter = false;
                checkPaging();
                const listings = response.listings;
                mainMap(getLocations(listings));
                if (listings.length>0) {
                    map.setCenter(new google.maps.LatLng(listings[0].latitude, listings[0].longitude))
                }
                else {
                    map.setCenter(new google.maps.LatLng(latlng.lat, latlng.lng))
                }
            }
        }); 
	  }
    }
	


    function paginationRequest(pageNo){

        if(filter){
            var formData = getFormData();
        }else{
			 formData = '';
			 getListings(formData, pageNo);
		}

        if(formData.promise !== '' && formData.promise !== 'remote') {
            formData.promise.then(result =>  {
                if (result) {
                    formData.formdata = {...formData.formdata,
                        'location': {
                            'lat': result.geometry ? result.geometry.location.lat() : result.lat,
                            'lng': result.geometry ? result.geometry.location.lng() : result.lng
                        }
                    };
                }

                getListings(formData.formdata, pageNo);
            })
        }
        else {
            if (formData.promise == 'remote') {
                formData.formdata = {...formData.formdata, 'location': 'remote'};
            }
            getListings(formData.formdata, pageNo);
        }
    }
	
	function checkboxcheckfilter(event){
		var checking = event.checked;
		var keyword = [];
		var findClass = $('.keywords-container').find(".keyword-input-val");
		if (findClass.length !== 0) {
            $('input[name^="keyword"]').each(function() {
                keyword.push($(this).val());
            });
        }
		<?php if($user){  ?>
		var userid = <?=$user->id?>;
		<?php }else{ ?>
		var userid = '';
		<?php } ?>
		console.log($('#catID').val());
		event.checked == "false";
		var location = $("#location").val();
		var keywords = $('.keywords-list').children("span").length;
		var category = $("#catID").val();
		var onGoing = $("#onGoing").val();
		var temporary = $("#temporary").val();
		data = {
            'id' 			: userid,
            'location' 		: location,
            'radius' 		: $('#radius').val(),
            'categoryID'    : $('#catID').val().sort(),
            'sortBy'    	: $('#sortBy').val(),
            'keyword'   	: keyword.sort(),
            'onGoing'   	: $('#onGoing').val(),
            'temporary' 	: $('#temporary').val(),
            'minimum' 		: $('#min').val(),
            'maximum'	    : $('#max').val(),
            'check'	    	: event.checked,
			'_token' 		:  '{{ csrf_token() }}',
        };
		if(event.checked == true && !location && !keywords && category == '' && onGoing == 'off' && temporary == 'off'){
		$("#checkbox").prop('checked',false);
		}
		else{
			
		$.easyAjax({
            url: '{{ route('Home.savefilter') }}',
            type: "POST",
            data:data,
            success: function (response) {
            }
        });
			
		}
	}
	
	
</script>

<!-- Snackbar // documentation: https://www.polonel.com/snackbar/ -->
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
</script>

<!-- Google Autocomplete -->
<script>
    function initAutocomplete() {
        var options = {
            types: ['(cities)'],
            // componentRestrictions: {country: "us"}
        };

        var input = document.getElementById('autocomplete-input');
        var autocomplete = new google.maps.places.Autocomplete(input, options);
    }

    $(".keywords-container").each(function() {

        var keywordInput = $(this).find(".keyword-input");
        var keywordsList = $(this).find(".keywords-list");

        // adding keyword
        function addKeyword() {
            var $newKeyword = $("<span class='keyword'><span class='keyword-remove'></span><span class='keyword-text'>"+ keywordInput.val() +"</span><input type='hidden' class='keyword-input-val' value='"+ keywordInput.val() +"' name='keyword[]'></span>");
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

<script>
    currentPage  = '{{$currentPage}}';
    totalPage    = '{{ $totalPage }}';
    totalRecord  = '{{ $totalRecord }}';
    startRec     = '{{ $startRec }}';
    endRec       = '{{ $endRec }}';
    let data = {};

    function executeFunction(data) {
        changeBookmark(data.url, data.ele)
    }

    $('body').on('click', '.job-listing .bookmark-icon', function() {
        const id = $(this).data('listing-id');
        let url = '{{ route('list.bookmark', ':id') }}';
        url = url.replace(':id', id);
        data = { url, ele: $(this)};
        @if($user)
            executeFunction(data);
        @else
            $.magnificPopup.open({
                type: 'inline',
                items: {
                    src: '#sign-in-dialog'
                },
                fixedContentPos: false,
                fixedBgPos: true,

                overflowY: 'auto',

                closeBtnInside: true,
                preloader: false,

                midClick: true,
                removalDelay: 300,
                mainClass: 'my-mfp-zoom-in'
            });
        @endif
    });

    $('#login-form').submit(function (e) {
        e.preventDefault();
        login(data)
    });

    $('#register-account-form').submit(function (e) {
        e.preventDefault();
        register(data)
    });

    $('body').on('click', '.job-listing-details', function() {
        const id = $(this).data('listing-id');
        let url = '{{ route('listing.list.show', ':id') }}';
        url = url.replace(':id', id);
        window.open(url, '_blank');
    })
</script>

<!-- Google API & Maps -->
<!-- Geting an API Key: https://developers.google.com/maps/documentation/javascript/get-api-key -->
<script src=https://maps.googleapis.com/maps/api/js?key=AIzaSyBEySfWxTzjYb1NKEsCbk0y7Nu76mK_yYk&libraries=places"></script>
<script src="{{ asset('js/infobox.min.js')}}"></script>
<script src="{{ asset('js/markerclusterer.js')}}"></script>
<script src="{{ asset('js/maps.js')}}"></script>

<script>
    function getLocations(searchListings) {
        let listingLocations = [];
        searchListings.forEach(searchListing => {
            let url = '';
            if (searchListing.files.length > 0) {
                url = '{{ asset('storage/listing-files/:file_name.:file_format') }}';
                url = url.replace(':file_name', searchListing.files[0].file_name);
                url = url.replace(':file_format', searchListing.files[0].file_format);
            }
            else {
                url = '{{ asset('images/company-logo-05.png') }}';
            }
            const id = searchListing.id;
            let jobURL = '{{ route('listing.list.show', ':id') }}';
            jobURL = jobURL.replace(':id', id);
            const companyLogo = url;

            const companyName = searchListing.category.name;
            const jobTitle = searchListing.job_title;

            listingLocations.push([ locationData(jobURL, companyLogo, companyName, jobTitle, 'verified'), searchListing.latitude, searchListing.longitude ])
        });

        return listingLocations;
    }
    $(function () {
        const searchListings = {!! $searchListings !!};

        initMap(getLocations(searchListings));
        map.setCenter(new google.maps.LatLng(searchListings[0].latitude, searchListings[0].longitude))
    })
	
	$.ajaxSetup({
	headers: {
	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
	});
	
	$('.mark-as-read').click(function () {
        console.log('test');
        var url = "{{ route('user.message.readAllUnread',[':id']) }}";
		<?php if($user){ ?>
        url = url.replace(':id', {{ $user->id }});
		<?php }else{ 
			$user = ''; ?>
			 url = url.replace(':id', {{ $user }});
		<?php } ?>
        $.easyAjax({
            url: url,
            type: "GET",
            container: "#small-dialog-10",
            success: function (response) {
                $('span.unreadMessageCount').text(0);
            }
        });
    });

	$('.status-switch label.user-invisible').on('click', function(){
	var status = '0';
	var url = "{{ route('user.message.update-status',[':status']) }}";
	url = url.replace(':status', status);
	$.ajax({
	url: url,
	type: "GET",
	container: ".user-details",
	});
	$('.status-indicator').addClass('right');
	$('.status-switch label').removeClass('current-status');
	$('.user-invisible').addClass('current-status');
	$('.user-avatar').toggleClass('status-online');
	});

	$('.status-switch label.user-online').on('click', function(){
	var status = '1';
	var url = "{{ route('user.message.update-status',[':status']) }}";
	url = url.replace(':status', status);
	$.ajax({
	url: url,
	type: "GET",
	container: ".user-details",
	});
	$('.status-indicator').removeClass('right');
	$('.status-switch label').removeClass('current-status');
	$('.user-online').addClass('current-status');
	$('.user-avatar').toggleClass('status-online');
		});
</script>
</body>
</html>
 