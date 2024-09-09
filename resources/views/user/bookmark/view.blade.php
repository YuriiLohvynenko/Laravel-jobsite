@extends('user.layouts.app')

@section('style')
@endsection

@section('content')
    <!-- Dashboard Headline -->
    <div class="dashboard-headline">
        <h3>Bookmarks</h3>

        <!-- Breadcrumbs -->
        <nav id="breadcrumbs" class="dark">
            <ul>
                <li><a href="{{ route('front.home') }}">Home</a></li>
                <li><a href="{{ route('user.dashboard.index') }}">Dashboard</a></li>
                <li>Bookmarks</li>
            </ul>
        </nav>
    </div>

    <!-- Row -->
    <div class="row">

        <!-- Dashboard Box -->
        <div class="col-xl-12">
            <!-- Tabs Container -->
            <div class="tabs">
                <div class="tabs-header tabs-white tabs-bottom-border tabs-single-border">
                    <ul class="tabs-jobs-group tabs-jobs-icons">
                        <li class="active ripple-effect-dark" id="listingTab"><a href="#" data-tab-id="1"><i class="icon-feather-book-open"></i> Listings</a></li>
                        <li class="ripple-effect-dark" id="peopleTab"><a href="#" data-tab-id="2"><i class="icon-feather-book-open"></i> People</a></li>
                    </ul>
                    <div class="tab-hover"></div>
                    <nav class="tabs-nav">
                        <div class="job-listing-icon-group">
                            <span class="crate-badge job-listing-badge" title="Flate rate commission for every job completed successfully" data-tippy-placement="left">Fee: 6%</span>
                            <span class="crate-badge job-listing-badge" title="Get cashback for every job completed successfully" data-tippy-placement="left">1% Cashback</span>
                        </div>
                    </nav>
                </div>
                <!-- Tab Content -->
                <div class="tabs-content tabs-no-space">
                    <div class="tab active" data-tab-id="1">
                        <!-- Client Jobs Active (client-active) -->
                        <div class="row tabs-jobs-border tabs-jobs-padding">
                            @forelse($bookmarks as $bookmark)
                                <div class="col-12" id="bookmarkList_{{ $bookmark->id }}">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="job-listing-title">
                                                <a href="{{ route('listing.list.show', $bookmark->listing->id) }}" class="ellipsis">{{ ucwords($bookmark->listing->job_title) }}</a>
                                                <span class="dashboard-status-button green">@if($bookmark->listing->budgetDetails->count() > 1) ${{ $bookmark->listing->budgetDetails->first()->budget }}/shift @else ${{ $bookmark->listing->budgetDetails->sum('budget') }} @endif</span>
                                                @if($bookmark->listing->budgetDetails->count() > 1)
                                                    <span class="dashboard-status-button green"> On-going </span>
                                                @endif
                                                @if($bookmark->listing->job_location == 'online')
                                                    <span class="dashboard-status-button green"> Remote </span>
                                                @endif
                                            </div>

                                            <div class="job-listing-group"><span class="icon-feather-map-pin"></span> {{ ucfirst($bookmark->listing->city) }}, {{ ucfirst($bookmark->listing->state) }}</div>

                                            @php
                                                $date = null;
                                                $time = null;
                                                if($bookmark->listing->budgetDetails->count() > 1) {
                                                    $list = $bookmark->listing->budgetDetails->filter(function ($value, $key) {
                                                        return $value->date_time > Carbon\Carbon::now();
                                                    });

                                                    $date = $list->first()->date_time->format('l, F j, Y');
                                                    $time = $list->first()->date_time->format('h:i A');

                                                } else {

                                                    $date = $bookmark->listing->budgetDetails->first()->date_time->format('l, F j, Y');
                                                    $time = $bookmark->listing->budgetDetails->first()->date_time->format('h:i A');
                                                }
                                            @endphp

                                            <div class="job-listing-group"><span class="icon-feather-calendar"></span> {{ $date }} <span>{{ $time }}</span></div>
                                        </div>
                                        <div class="col-6 pull-right">
                                            <div class="tabs-jobs-buttons">
                                                <a href="{{ route('listing.list.show', $bookmark->listing->id) }}" class="button button-sliding-icon ripple-effect">View Listing <i class="icon-material-outline-arrow-right-alt"></i></a>
                                                <a href="javascript:;" class="popup-with-zoom-anim button gray ripple-effect removeBookmark" data-bookmark-id="{{ $bookmark->id }}"  title="Remove Bookmark" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-7 col-sm-6">
                                            <div class="job-listing-title"><a href="#" class="ellipsis">Listing bookmark not found.</a></div>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="tab active" data-tab-id="2">
                        <!-- Client Jobs Active (client-active) -->
                        <div class="row tabs-jobs-border tabs-jobs-padding">
                            @forelse($peoples as $people)
                                <div class="col-12" id="bookmarkList_{{ $people->id }}">
                                    <div class="row">
                                        <div class="col-md-1 col-sm-2">
                                            <span class="user-avatar bookmark-avatar @if($people->people->status == 1) status-online @else status-offline @endif "><img src="{{ $people->people->image() }}" alt=""></span>
                                        </div>
                                        <div class="col-md-7 col-sm-6">
                                            <div class="job-listing-title"><a href="#" class="ellipsis">{{ $people->people->full_name }}</a> <span class="dashboard-status-button green">Verified</span></div>
                                            <div class="job-listing-group"><span class="icon-feather-user-plus margin-right-5"></span> {{ $people->people->get_specialties($people->people->specialties) != '' ? $people->people->get_specialties($people->people->specialties) : 'Not set' }} </div>
                                            <div class="job-listing-group"><span class="icon-feather-check-circle margin-right-5"></span>
                                                <!-- Rating -->
                                                <div class="star-rating bookmarks-rating" data-rating="{{ $people->people->userRating() }}"></div>
                                            </div>
                                        </div>
                                        <div class="col-4 pull-right">
                                            <div class="tabs-jobs-buttons">
                                                <a href="{{ route('user.profile.show', $people->people->id) }}" class="button button-sliding-icon ripple-effect">View Profile <i class="icon-material-outline-arrow-right-alt"></i></a>
                                                <a href="#small-dialog-1" class="popup-with-zoom-anim button gray ripple-effect removeBookmark" data-bookmark-id="{{ $people->id }}"  title="Remove Bookmark" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-7 col-sm-6">
                                            <div class="job-listing-title"><a href="#" class="ellipsis">People bookmark not found.</a></div>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- Row / End -->

    <div id="small-dialog-1" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
        <!--Tabs -->
        <div class="sign-in-form">
            <div class="popup-tabs-container">
                <!-- Tab -->
                <div class="popup-tab-content" id="tab">
                    <!-- Welcome Text -->
                    <div class="padding-bottom-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="modal-main">Confirm Bookmark Removal</div>
                            </div>
                            <div class="col-12">
                                <div class="modal-head-">Are you sure you want to remove this bookmark?</div>
                            </div>
                        </div>
                        <div class="row margin-top-40">
                            <div class="col-6">
                                <input type="hidden" id="bookmarkID" name="bookmarkID">
                                <a href="javascript:;" id="confirmPopup"  class="popup-with-zoom-anim button gray ripple-effect">Yes</a>
                            </div>
                            <div class="col-6">
                                <a href="javascript:;" id="closePopup" class="popup-with-zoom-anim button button-sliding-icon ripple-effect">No <i class="icon-material-outline-arrow-right-alt"></i></a>
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
        /*----------------------------------------------------*/
        /*  Magnific Popup
         /*----------------------------------------------------*/

        $('.removeBookmark').on('click', function(e) {
            var id = $(this).data('bookmark-id');
            $('#bookmarkID').val(id);
            $.magnificPopup.open({
                type: 'inline',
                items: {
                    src: '#small-dialog-1'
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
        });

        $('#confirmPopup').on('click', function(e) {
            var id = $('#bookmarkID').val();
            var url = "{{ route('user.bookmark.destroy',':id') }}";
            url = url.replace(':id', id);
            var token = "{{ csrf_token() }}";

            $.easyAjax({
                type: 'POST',
                url: url,
                data: {'_token': token, '_method': 'DELETE'},
                success: function (response) {
                    if (response.status == "success") {
                        $('#bookmarkList_'+id).remove();
                        $('#bookmarkID').val('');
                        $.magnificPopup.close();
                        animateTabHeight();
                    }
                }
            });
        });

        // Animate Tab Height
        function animateTabHeight() {
            // Update Tab Height
            tabHeight = $('.tabs').find('.tab.active').outerHeight();

            // Animate Height
            $('.tabs').find('.tabs-content').stop().css({
                height: tabHeight + 'px'
            });
        }

    </script>
@endsection
