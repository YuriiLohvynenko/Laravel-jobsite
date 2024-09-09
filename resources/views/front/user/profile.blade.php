@extends('front.layout.front-app')

@push('style')
@endpush

@section('content')

    <div class="single-page-header freelancer-header">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6">
				
                    <div class="profile-name">{{ $profile->full_name }}</div>
                    <div class="profile-title">{{ $profile->get_specialties($profile->specialties) }}</div>
                    <div class="profile-description">  {{$profile->detail->introduction}} </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <div class="center-vertical">
                        <div class="profile-picture"><img src="{{ $profile->image() }}" /></div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
				@if($profile->status == 1)
                    <div class="row">
                        <div class="col-12">
                            <div class="star-rating" data-rating="{{ $profile->userRating() }}"></div>
                        </div>
                        <div class="col-12">
                            <div class="profile-location blue-icon"><i class="icon-feather-map-pin"></i> {{ !is_null($profile->city) && is_null($profile->city) ? ucfirst($profile->city). ', '. ucfirst($profile->state) : 'Not set yet' }}</div>
                        </div>
                        <div class="col-12">
                            <div class="profile-list">
                                <div class="profile-head">Badges</div>
                                @if($profile->badge->count() > 0)
                                    @badge(['badges' => $profile->badge]) @endbadge
                                @else
                                    <div class="modal-super- modal-badges">
                                        Not Earned Yet
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
					@endif
                </div>
            </div>
        </div>
    </div>


    <!-- Page Content
    ================================================== -->
    <div class="container">
        <div class="row">
<?php if($profile->status == 1) { ?>
            <!-- Sidebar -->
            <div class="col-xl-4 col-lg-4">
                <div class="sidebar-container">
                    @if($user)
                        @if($user->id != $profile->id)
                            <!-- Button -->
                            <a href="javascript:;" onclick="hirePopup()" class="apply-now-button popup-with-zoom-anim margin-bottom-50">Hire <i class="icon-material-outline-arrow-right-alt"></i></a>
                        @endif
                    @else
                        <a href="javascript:;" onclick="hirePopup()" class="apply-now-button popup-with-zoom-anim margin-bottom-50">Hire <i class="icon-material-outline-arrow-right-alt"></i></a>

                    @endif
                    <!-- Freelancer Indicators -->
                    <div class="sidebar-widget">
                        <div class="freelancer-indicators">

                            <!-- Indicator -->
                            <div class="indicator">
                                <strong>{{ $jobSuccess }}%</strong>
                                <div class="indicator-bar" data-indicator-percentage="{{ $jobSuccess }}"><span></span></div>
                                <span>Job Success</span>
                            </div>

                            <!-- Indicator -->
                            <div class="indicator">
                                <strong>{{ $percentRating }}%</strong>
                                <div class="indicator-bar" data-indicator-percentage="{{ $percentRating }}"><span></span></div>
                                <span>Reliability</span> <!-- feedback (60%), job success (40%) -->
                            </div>
                        </div>
                    </div>

                    <!-- Widget -->
                    <div class="sidebar-widget">
                        <h3>Previous Job Title</h3>
                        <div class="task-tags">
                            @forelse($previousTitles as $previousTitle)
                                <span>{{ $previousTitle }}</span>
                            @empty
                            @endforelse

                         </div>
						 <span><p>{{ $intro['introduction'] }}</p></span>
                    </div>

                    <!-- Sidebar Widget -->
                    <div class="sidebar-widget">
                        <h3>Bookmark or Share</h3>


                    @if($user)
                        @if($user->id != $profile->id)
                            <!-- Bookmark Button -->
                                <button class="bookmark-button margin-bottom-25 @if($checkBookmark == true) bookmarked @endif ">
                                    <span class="bookmark-icon"></span>
                                    <span class="bookmark-text">Bookmark</span>
                                    <span class="bookmarked-text">Bookmarked</span>
                                </button>
                            @endif
                        @else
                            <button class="bookmark-button margin-bottom-25 @if($checkBookmark == true) bookmarked @endif ">
                                <span class="bookmark-icon"></span>
                                <span class="bookmark-text">Bookmark</span>
                                <span class="bookmarked-text">Bookmarked</span>
                            </button>
                    @endif



                        <!-- Copy URL -->
                        <div class="copy-url">
                            <input id="copy-url" type="text" value="" class="with-border">
                            <button class="copy-url-button ripple-effect" data-clipboard-target="#copy-url" title="Copy to Clipboard" data-tippy-placement="top"><i class="icon-material-outline-file-copy"></i></button>
                        </div>

                        <!-- Share Buttons -->
                        <div class="share-buttons margin-top-25">
                            <div class="share-buttons-trigger"><i class="icon-feather-share-2"></i></div>
                            <div class="share-buttons-content">
                                <span>Interesting? <strong>Share It!</strong></span>
                                <ul class="share-buttons-icons">
                                    {!! $share !!}
{{--                                    <li><a href="#" data-button-color="#3b5998" title="Share on Facebook" data-tippy-placement="top"><i class="icon-brand-facebook-f"></i></a></li>--}}
{{--                                    <li><a href="#" data-button-color="#1da1f2" title="Share on Twitter" data-tippy-placement="top"><i class="icon-brand-twitter"></i></a></li>--}}
{{--                                    <li><a href="#" data-button-color="#0077b5" title="Share on LinkedIn" data-tippy-placement="top"><i class="icon-brand-linkedin-in"></i></a></li>--}}
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Content -->
            <div class="col-xl-8 col-lg-8">
                <div class="boxed-list-headline margin-bottom-30">
                    <h3 class="profile-headline"><i class="icon-material-outline-thumb-up"></i> Work History and Feedback</h3>
                </div>
                <!-- Tabs Container -->
                <div class="tabs margin-bottom-30">
                    <div class="tabs-header tabs-white tabs-bottom-border tabs-single-border">
                        <ul class="tabs-jobs-group tabs-jobs-icons">
                            <li class="active ripple-effect-dark"><a href="#tab-1" data-tab-id="1"><i class="icon-feather-map-pin"></i> As a Client</a></li>
                            <li class="ripple-effect-dark"><a href="#tab-2" data-tab-id="2"><i class="icon-feather-map-pin"></i> As a Freelancer</a></li>
                        </ul>
                        <div class="tab-hover"></div>
                        <nav class="tabs-nav blue-nav-tabs">
                            <span class="tab-prev"><i class="icon-material-outline-keyboard-arrow-left"></i></span>
                            <span class="tab-next"><i class="icon-material-outline-keyboard-arrow-right"></i></span>
                        </nav>
                    </div>
                    <!-- Tab Content -->
                    <div class="tabs-content tabs-no-space">
                        <div class="tab active" data-tab-id="1">
                            <!-- Client Jobs Active (client-active) -->
                            <div class="row tabs-jobs-border tabs-jobs-padding">
                                @forelse($freelanceFeedbacks as $freelanceFeedback)
                                    <div class="col-12">
                                        <div class="boxed-list-item">
                                            <!-- Content -->
                                            <div class="item-content">
                                                <h4>{{ ucwords($freelanceFeedback->listing->job_title) }}</h4>
                                                <div class="item-details margin-top-10">
                                                    <div class="star-rating" data-rating="{{ $freelanceFeedback->rating }}"></div>
                                                    <div class="detail-item"><i class="icon-material-outline-date-range"></i> August 2019</div>
                                                </div>
                                                <div class="item-description">
                                                    <p>{{ ucwords($freelanceFeedback->description) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="boxed-list-item">
                                            <!-- Content -->
                                            <div class="item-content">
                                                <h4>Feedback not found.</h4>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="tab active" data-tab-id="2">
                            <!-- Client Jobs Active (client-active) -->
                            <div class="row tabs-jobs-border tabs-jobs-padding">
                                @forelse($clientFeedbacks as $clientFeedback)
                                    <div class="col-12">
                                        <div class="boxed-list-item">
                                            <!-- Content -->
                                            <div class="item-content">
                                                <h4>{{ ucwords($clientFeedback->listing->job_title) }}</h4>
                                                <div class="item-details margin-top-10">
                                                    <div class="star-rating" data-rating="{{ $clientFeedback->rating }}"></div>
                                                    <div class="detail-item"><i class="icon-material-outline-date-range"></i> August 2019</div>
                                                </div>
                                                <div class="item-description">
                                                    <p>{{ ucwords($clientFeedback->description) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="boxed-list-item">
                                            <!-- Content -->
                                            <div class="item-content">
                                                <h4>Feedback not found.</h4>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

            </div>
			<?php }else{ ?>
			<div class="col-xl-12 col-lg-12">
<h1 class="center">User has been Disabled.</h1>
</div>
<?php } ?>
        </div>
    </div>
    <!-- Spacer -->
    <div class="margin-top-15"></div>
    <!-- Spacer / End-->

    <!-- Make an Offer Popup
================================================== -->
    @if($user)
    <!-- Contact Freelancer -->
    <div id="small-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
        <!--Tabs -->
        <div class="sign-in-form">
            <div class="popup-tabs-container">
                <!-- Tab -->
                <div class="popup-tab-content" id="tab">
                    <!-- Welcome Text -->
                    <div class="padding-bottom-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="modal-main">Send Job Invitation <i class="icon-feather-info" title="You may receive a notification if the user responds" data-tippy-placement="top"></i></div>
                            </div>
                            <div class="col-12">
                                <div class="modal-head-">Let this person know you're interested in working work them.</div>
                            </div>
                        </div>
                        <div class="row margin-top-10">
                            <div class="col-12 input-with-icon-left">
                                <div>
                                    <input type="hidden" name="userID" id="userID" value="{{ $profile->id }}">
                                    <select class="selectpicker" id="job" name="job" multiple data-max-options="1" data-size="3" title="Start selecting an open job" data-live-search="true">
                                        @forelse($user->listings as $userListing)
                                            <option value="{{ $userListing->id }}">{{ ucfirst($userListing->job_title) }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="row margin-top-40">
                            <div class="col-6">
                                <a href="javascript:;" class="popup-with-zoom-anim button gray ripple-effect" onclick="closeModel(); return false;">Cancel</a>
                            </div>
                            <div class="col-6">
                                <a href="" id="message-sent" onclick="submitInvite(); return false;"  class="popup-with-zoom-anim button button-sliding-icon ripple-effect">Send Invite <i class="icon-material-outline-arrow-right-alt"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Freelancer / End -->
    @endif
@endsection

@section('footerjs')
    <script>
        function hirePopup() {
            @if($user)
                $.magnificPopup.open({
                    type: 'inline',
                    items: {
                        src: '#small-dialog'
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
            @else
                Snackbar.show({
                    text: 'Please login for hire',
                    pos: 'bottom-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 3000,
                    textColor: '#fff',
                    backgroundColor: '#ed6359'
                });
            @endif
        }

        function submitInvite(){
            var userList = $('#job').val();
            var userID = '{{ $profile->id }}';
            var token = '{{ csrf_token() }}';
            $.easyAjax({
                url: "{!! route('profile.invite') !!}",
                type: "POST",
                container: "#small-dialog",
                data: {'userID': userID, 'job': userList, '_token': token},
                success: function (response) {
                    $.magnificPopup.close();
                }
            });
            return false;
        }

        $('.bookmark-icon').on('click', function(e){
            e.preventDefault();
            @if($user)
                changeBookmark();
                $(this).toggleClass('bookmarked');
            @else
                Snackbar.show({
                text: 'Please login for bookmark',
                pos: 'bottom-center',
                showAction: false,
                actionText: "Dismiss",
                duration: 3000,
                textColor: '#fff',
                backgroundColor: '#ed6359'
            });
            @endif
        });

        $('.bookmark-button').on('click', function(e){
            e.preventDefault();
            @if($user)
                changeBookmark();
                $(this).toggleClass('bookmarked');
            @else
            Snackbar.show({
                text: 'Please login for bookmark',
                pos: 'bottom-center',
                showAction: false,
                actionText: "Dismiss",
                duration: 3000,
                textColor: '#fff',
                backgroundColor: '#ed6359'
            });
            @endif
        });
        function closeModel() {
            $.magnificPopup.close();
        }
        function changeBookmark(){
            $.easyAjax({
                url: "{!! route('profile.bookmark', $profile->id) !!}",
                type: "GET",
                container: ".bookmark-button",
                success: function (response) {
                    var bookmark = $('#totalBookmarks');
                    var totalBookmark = parseInt(bookmark.html());
                    if(response.action == 'add'){
                        totalBookmark = (totalBookmark+1);
                    }
                    else{
                        totalBookmark = (totalBookmark-1);
                    }

                    bookmark.html(totalBookmark);
                }
            });
        }

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

        // Snackbar for "place a bid" button
        $('#snackbar-place-bid').click(function() {
            Snackbar.show({
                text: 'Your bid has been placed!',
            });
        });

        // Snackbar for copy to clipboard button
        $('.copy-url-button').click(function() {
            Snackbar.show({
                text: 'Copied to clipboard!',
            });
        });
		
		$.ajaxSetup({
					headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
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
@endsection
