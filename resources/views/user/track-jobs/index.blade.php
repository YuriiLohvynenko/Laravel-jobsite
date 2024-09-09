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
    @include('user.sections.style')

</head>
<body class="gray">

<!-- Wrapper -->
<div id="wrapper">

    <!-- Header Container
    ================================================== -->
    <header id="header-container" class="fullwidth dashboard-header not-sticky">
        <!-- Header -->
        <div id="header">
            <div class="container">
                @include('common.header-logged-in')
            </div>
        </div>
    </header>
    <div class="clearfix"></div>
    <!-- Header Container / End -->






    <!-- Page Content
    ================================================== -->
    <div class="full-page-container with-map">

        @include('user.sections.sidebar')

        <!-- Full Page Content -->
        <div class="full-page-content-container" data-simplebar>
            <div class="full-page-content-inner">

                <div class="">
                    <h3 class="page-title">On-Site Jobs</h3>
                    <div class="notify-box margin-top-15">
                        <div class="switch-container">
                            <label class="switch"><input type="checkbox" onchange="textAlert('on-site');return false;" id="onSite" @if($user->onSiteAlert && $user->onSiteAlert->alert == 1) checked @endif><span class="switch-button"></span><span class="switch-text">Turn on text alerts when active</span></label>
                        </div>

                        <div class="sort-by">
                            <span>Sort by:</span>
                            <select class="selectpicker hide-tick" id="onSiteSortBy">
                                <option>Active</option>
                                <option>Inactive</option>
                                <option>Oldest</option>
                            </select>
                        </div>
                    </div>
                    <div class="row crate-lineup">
                        @forelse($onSiteListings as $listing)
                        <div class="col-6">
                            <div class="crate">
                                <div class="crate-inner add-radius add-shadow add-white crate-padding crate-hover">
                                    <div class="row margin-bottom-15">
                                        <div class="col-12">
                                            <div class="modal-head ellipsis">{{ $listing->job_title }}</div>
                                            <div class="modal-head- blue-icon"><i class="icon-feather-user"></i> {{ $listing->user->full_name }}</div>
                                            <div class="modal-head- blue-icon ellipsis"><i class="icon-feather-map-pin"></i> 8:00pm - 12:30pm (10.25.2019)</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <span class="blog-post-date full-width center"><i class="icon-feather-map-pin"></i> Active</span>
                                        </div>
                                        <div class="col-6">
                                            <a href="javascript:;" onclick="sendMessage('{{ $listing->user_id }}', '{{ $listing->id }}', 'open')" class="popup-with-zoom-anim button gray ripple-effect modal-button full-width">Contact</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                            <div class="col-12">
                                <div class="center">
                                    No listing found!
                                </div>
                            </div>
                        @endforelse

                        <div class="col-12">
                            <!-- Pagination -->
                            <div class="clearfix"></div>

                            <div class="remote" data-listing-type="onSite">
                                {{ $onSiteListings->links() }}
                            </div>

                            <div class="clearfix"></div>
                            <!-- Pagination / End -->
                        </div>

                    </div>

                </div>

                <div class="">
                    <h3 class="page-title">Remote Jobs</h3>
                    <div class="notify-box margin-top-15">
                        <div class="switch-container">
                            <label class="switch"><input type="checkbox" onchange="remoteTextAlert('remote');return false;" id="remote" @if($user->remoteAlert && $user->remoteAlert->alert== 1) checked @endif><span class="switch-button"></span><span class="switch-text">Turn on text alerts when active</span></label>
                        </div>

                        <div class="sort-by">
                            <span>Sort by:</span>
                            <select class="selectpicker hide-tick" id="remoteSortBy">
                                <option>Active</option>
                                <option>Inactive</option>
                                <option>Oldest</option>
                            </select>
                        </div>
                    </div>
                    <div class="row crate-lineup">
                        @forelse($remoteListings as $listing)
                        <div class="col-6">
                            <div class="crate">
                                <div class="crate-inner add-radius add-shadow add-white crate-padding crate-hover">
                                    <div class="row margin-bottom-15">
                                        <div class="col-12">
                                            <div class="modal-head ellipsis">{{ $listing->job_title }}</div>
                                            <div class="modal-head- blue-icon"><i class="icon-feather-user"></i> {{ $listing->user->full_name }}</div>
                                            <div class="modal-head- blue-icon ellipsis"><i class="icon-feather-map-pin"></i> 8:00pm - 12:30pm (10.25.2019)</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <span class="blog-post-date full-width center"><i class="icon-feather-globe"></i> Active</span>
                                        </div>
                                        <div class="col-6">
                                            <a href="javascript:;" onclick="sendMessage('{{ $listing->user_id }}', '{{ $listing->id }}', 'open')" class="popup-with-zoom-anim button gray ripple-effect modal-button full-width">Contact</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                            <div class="col-12">
                                <div class="center">
                                    No listing found!
                                </div>
                            </div>
                        @endforelse
                        <div class="col-12">
                            <!-- Pagination -->
                            <div class="clearfix"></div>
                            <div class="remote" data-listing-type="remote">
                                {{ $remoteListings->links() }}
                            </div>


                            <div class="clearfix"></div>
                            <!-- Pagination / End -->
                        </div>

                    </div>

                </div>

            </div>
        </div>

        <!-- Full Page Map -->
        <div class="full-page-map-container">

            <!-- Enable Filters Button -->
            <div class="filter-button-container">
                <button class="enable-filters-button">
                    <i class="enable-filters-button-icon"></i>
                    <span class="show-text">Show Filters</span>
                    <span class="hide-text">Hide Filters</span>
                </button>
            </div>

            <!-- Map -->
            <div id="map" data-map-zoom="5" data-map-scroll="true"></div>
        </div>
        <!-- Full Page Map / End -->

    </div>
</div>
<!-- Wrapper / End -->

<!-- Contact Freelancer -->
<div id="small-dialog-10" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
    <!--Tabs -->
    <div class="sign-in-form">
        <div class="popup-tabs-container" id="modalData">
            <!-- Tab -->
        </div>
    </div>
</div>
<!-- Contact Freelancer / End -->

<!-- Scripts
================================================== -->
@include('user.sections.footer-scripts')

<script>
    function sendMessage(toUserId, listingId, status){
        if(status == 'open'){
            var url = "{{ route('user.message.get-message-popup', [':toUserId', ':listingId']) }}";
            url = url.replace(':toUserId', toUserId);
            url = url.replace(':listingId', listingId);
            $.easyAjax({
                url: url,
                type: "GET",
                container: "#small-dialog-10",
                success: function (response) {
                    console.log(response);
                    $('#modalData').html(response.view);
                    openModal();
                }
            });
        }
        else{
            var to_user = toUserId;
            var listing_id = listingId;
            var text = $('#directMessage').val();
            var withBRs = text.replace(/\n/g, "<br />") ;
            var message = '<p>' + withBRs + '</p>' ;

            $.ajax({
                url: "{{ route('user.message.store') }}",
                type: "POST",
                container: ".message-reply",
                data: {'to_user' : to_user, 'message' : message, 'listing_id' : listing_id, '_token': "{{ csrf_token() }}" },
                success: function (response) {
                    $('#directMessage').val('');
                    closeModel();
                }
            });
        }
    }
    function openModal(){
        $.magnificPopup.open({
            type: 'inline',
            items: {
                src: '#small-dialog-10'
            },
            fixedContentPos: false,
            fixedBgPos: true,

            overflowY: 'auto',

            closeBtnInside: true,
            preloader: false,

            midClick: true,
            removalDelay: 300,
            mainClass: 'my-mfp-zoom-in',
        });
    }
    function closeModel(){
        $.magnificPopup.close();
    }
    var filter = false;

    //get filtering condition
    function getFormData(){
        var formdata;

        formdata = {
            'sortBy'    : $('#sortBy').val(),
        };

        return formdata;
    }


    $('body').on('click', '.page-no-button', function(e) {
        e.preventDefault();
        var element = $(this).closest('.crate-lineup');
        var type = $(this).closest('.remote').data('listing-type');

        var pageNo = $(this).data('page-no');
        paginationRequest(pageNo, element, type);
    });


    function paginationRequest(pageNo, element, type){

        if(filter){
            var formData = getFormData();
        }
        else{
            var formData = {};
        }
        $.easyAjax({
            url: '{{ route('user.track-job.index') }}'+'?page='+pageNo+'&type='+type,
            type: "GET",
            container: ".full-page-content-inner",
            data:formData,
            success: function (response) {
                element.html(response.view);
            }
        });
    }

    function textAlert(listingType) {
        // Get the checkbox
        var checkBox = document.getElementById("onSite");

        // If the checkbox is checked, display the output text
        if (checkBox.checked == true) {
            $.easyAjax({
                url: '{{ route('user.text-alert.store') }}',
                type: "POST",
                container: ".full-page-content-inner",
                data: {
                    type: listingType,
                    _token: '{{ csrf_token() }}'
                }
            });
        } else {
            $.easyAjax({
                url: '{{ route('user.text-alert.delete') }}',
                type: "POST",
                container: ".full-page-content-inner",
                data: {
                    type: listingType,
                    _token: '{{ csrf_token() }}'
                },
            });
        }
    }

    function remoteTextAlert(listingType)
    {
        // Get the checkbox
        var checkBox = document.getElementById("remote");

        // If the checkbox is checked, display the output text
        if (checkBox.checked == true){
            $.easyAjax({
                url: '{{ route('user.text-alert.store') }}',
                type: "POST",
                container: ".full-page-content-inner",
                data:{
                    type:listingType,
                    _token:'{{ csrf_token() }}'
                }
            });
        } else {
            $.easyAjax({
                url: '{{ route('user.text-alert.delete') }}',
                type: "POST",
                container: ".full-page-content-inner",
                data:{
                    type:listingType,
                    _token:'{{ csrf_token() }}'
                },
            });
        }

    }
</script>

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
        let onSiteListings = {!! $onSiteListingsArr !!};
        let remoteListings = {!! $remoteListingsArr !!};
        let listings = onSiteListings.concat(remoteListings);

        initMap(getLocations(listings));
        map.setCenter(new google.maps.LatLng(listings[0].latitude, listings[0].longitude));
    });
</script>
</body>
</html>
