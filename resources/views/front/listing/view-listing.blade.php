@extends('front.layout.front-app')

@section('content')
    <div class="container margin-top-30">
        <div class="row">

            <!-- Header -->
            <div class="col-xl-12 margin-bottom-30">
                <div class="row">
                    <div class="col-md-7 col-sm-12">
                        <div class="post-category">{{ $listing->category->name }}</div>
                        <div class="post-head">{{ ucfirst($listing->job_title) }} @if($listing->immediate_assistance == 'required')<i class="icon-feather-clock red"></i> @endif</div>
                        <div class="post-location">{{ ucfirst($listing->city) }}, {{ ucfirst($listing->state) }}</div>
                    </div>
                    <div class="col-md-5 col-sm-12">
                        <div class="account-type margin-bottom-0 absolute-right">
                            <div class="status-listing">
                                <input type="radio" name="account-type-radio" id="freelancer-radio" class="account-type-radio" @if($listing->status == 'pending')checked @else disabled @endif/>
                                <label for="freelancer-radio" class="ripple-effect-dark"><i class="icon-material-outline-account-circle"></i> Open</label>
                            </div>

                            <div class="status-listing">
                                <input type="radio" name="account-type-radio" id="employer-radio" class="account-type-radio" @if($listing->status == 'accepted')checked @else disabled @endif/>
                                <label for="employer-radio" class="ripple-effect-dark"><i class="icon-material-outline-business-center"></i> Assigned</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-xl-4 col-lg-4">
                <div class="sidebar-container">

                    <div class="sidebar-widget">
                        <div class="job-overview">
                            <div class="job-overview-headline">Job Summary</div>
                            <div class="job-overview-inner">
                                <ul>
                                    <li>
                                        <span>Posted by</span>
                                        <h5 class="post-client"><a href="{{ route('user.profile.show', $listing->user->id) }}">{{ $listing->user->full_name }}</a></h5>
                                    </li>
                                    <li>
                                        <span>Total Budget</span>
                                        <div class="post-price">${{ $totalBudget }}</div>
                                    </li>
                                    @if(isset($user) && $listing->user_id != $user->id)
                                        <li>
                                            <a href="javascript:;" id="sendOffer" class="button popup-with-zoom-anim ripple-effect move-on-hover full-width margin-top-30">Send Offer</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="row center">
                        <div class="col-6">
                            <strong class="">Bookmarks</strong>
                            <div class="" id="totalBookmarks">{{ $listing->bookmark->count() }}</div>
                        </div>
                        <div class="col-6">
                            <strong class="">Offers</strong>
                            <div class="">{{ $listing->offer->count() }}</div>
                        </div>
                    </div>

                    <div class="row margin-top-10 margin-bottom-20">
                        <div class="col-12">
                            <div class="split-border"></div>
                        </div>
                    </div>

                    <!-- Sidebar Widget -->
                    <div class="sidebar-widget">
                        <h3>Bookmark or Share</h3>

                        <!-- Bookmark Button -->
                        <button class="bookmark-button margin-bottom-25 @if($checkBookmark == true) bookmarked @endif ">
                            <span class="bookmark-icon"></span>
                            <span class="bookmark-text">Bookmark</span>
                            <span class="bookmarked-text">Bookmarked</span>
                        </button>

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
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Content -->
            <div class="col-xl-8 col-lg-8">

                <div class="boxed-list-headline margin-bottom-30">
                    <h3 class="profile-headline"><i class="icon-material-outline-thumb-up"></i> Job Details</h3>
                </div>


                <!-- Description -->
                <div class="single-page-section">
                    <h3 class="margin-bottom-5">Project Description</h3>
                    <p>{{ ucwords($listing->description) }}</p>
                    @if($listing->immediate_assistance == 'required')
                        <div class="margin-top-10 immediate-assistance"><i class="icon-feather-clock red"></i> Immediate Assistance Required</div>
                    @endif
                </div>

                <!-- Description -->
                <div class="single-page-section">
                    <h3 class="margin-bottom-5">Materials or Travel</h3>
                    @if($listing->materials == 'included_in_budget')
                        <p>Included In Budget</p>
                    @elseif($listing->materials == 'not_required')
                        <p>None Required</p>
                    @else
                        <p>None Included</p>
                    @endif
                </div>

                <!-- Description -->
                <div class="single-page-section">
                    <h3 class="margin-bottom-5">Milestones (Scheduled Days)</h3>
                    <div class="row">
                        <div class="col-12">
                            @forelse($listing->budgetDetails as $budgetDetail)
                                <div class="post-milestone"><span class="milestone-price">${{ number_format($budgetDetail->budget) }}</span> {{ $budgetDetail->date_time->format('D, F dS, Y - H:ia') }}</div>
                            @empty
                            @endforelse
                        </div>

                    </div>
                </div>

                <!-- Atachments -->
                <div class="single-page-section">
                    <h3>Attachments</h3>
                    <div class="attachments-container">
                        @forelse($attachments as $attachment)
                        <a href="{{ asset('../storage/app/public/listing-files/'.$attachment->file_name.'.'.$attachment->file_format) }}" target="_blank" class="attachment-box ripple-effect"><span>{{ $attachment->file_name }}</span><i>{{ strtoupper($attachment->file_format) }}</i></a>
                        @empty
                        @endforelse
                    </div>
                    <div class="row margin-top-20">
                        <div class="col-12 my-gallery" itemscope itemtype="http://schema.org/ImageGallery">
                            @forelse($images as $img)
                            <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                                <a href="{{ asset('../storage/app/public/listing-files/'.$img->file_name.'.'.$img->file_format) }}" itemprop="contentUrl" data-size="1024x1024">
                                    <div class="photoswipe-container"><img src="{{ asset('../storage/app/public/listing-files/'.$img->file_name.'.'.$img->file_format) }}" /></div>
                                </a>
                            </figure>
                            @empty
                            @endforelse

                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

                <!-- Freelancers Bidding -->
                <div class="boxed-list margin-bottom-60">
                    <div class="boxed-list-headline">
                        <h3><i class="icon-material-outline-group"></i> Freelancers Bidding</h3>
                    </div>
                    <ul class="boxed-list-ul boxed-list-padding">
                        @forelse($listing->offer as $offer)
                        <li>
						<?php //print_r($offer); ?>
                            <div class="bid">
                                <!-- Avatar -->
                                <div class="bids-avatar">
                                    <div class="freelancer-avatar">
                                        <div class="verified-badge"></div>
                                        <a href="{{ route('user.profile.show', $offer->user->id) }}"><img src="{{ $offer->user->image() }}" alt="" /></a>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="bids-content">
                                    <!-- Name -->
                                    <div class="freelancer-name">
                                        <h4><a href="{{ route('user.profile.show', $offer->user->id) }}">{{ ucfirst($offer->user->full_name) }}</a></h4>
                                        <div class="star-rating" data-rating="{{ $offer->rating }}"></div>
                                    </div>
                                    <div class="margin-top-10">{{ $offer->description }}</div>
                                </div>

                                <!-- Bid -->
                                <div class="bids-bid">
                                    <div class="bid-rate">
                                        <div class="rate">${{ $offer->amount }}</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @empty
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <!-- Contact Freelancer -->
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
                                <div class="modal-main">Send Offer <i class="icon-feather-info" title="Offers can be modified as long as the listing is active and hasn't been assigned" data-tippy-placement="top"></i></div>
                            </div>
                            <div class="col-12">
                                <div class="modal-head-">Show the client your interested in their project. Be sure that materials, if any, are included in your offer.</div>
                            </div>
                        </div>
                        <form id="sendOfferForm">
                            {{ csrf_field() }}
                            <input type="hidden" id="listingID" name="listingID" value="{{ $listing->id }}">
                        <div class="row margin-top-50">
                            <div class="col-12">
                                <div class="bidding-field">
                                    <!-- Quantity Buttons -->
                                    <div class="qtyButtons">
                                        <div class="qtyDec"></div>
                                        <input type="text" id="budgetAmount" name="amount" value="{{ $totalBudget }}">

                                        <div class="qtyInc"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row margin-top-30">
                            <div class="col-12">
                                <textarea name="description" cols="5" placeholder="Sharing personal information may result in action taken against your account. You can not charge clients for taskapron fees." class=""></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <a href="" class="button  gray ripple-effect">Cancel</a>
                            </div>
                            <div class="col-6">
                                <a href="javascript:;"  id="snackbar-place-bid" class="button button-sliding-icon ripple-effect">Send Offer <i class="icon-material-outline-arrow-right-alt"></i></a>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Root element of PhotoSwipe. Must have class pswp. -->
    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

        <!-- Background of PhotoSwipe.
             It's a separate element, as animating opacity is faster than rgba(). -->
        <div class="pswp__bg"></div>

        <!-- Slides wrapper with overflow:hidden. -->
        <div class="pswp__scroll-wrap">

            <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
            <!-- don't modify these 3 pswp__item elements, data is added later on. -->
            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>

            <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
            <div class="pswp__ui pswp__ui--hidden">

                <div class="pswp__top-bar">

                    <!--  Controls are self-explanatory. Order can be changed. -->

                    <div class="pswp__counter"></div>

                    <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

                    <button class="pswp__button pswp__button--share" title="Share"></button>

                    <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                    <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                    <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
                    <!-- element will get class pswp__preloader--active when preloader is running -->
                    <div class="pswp__preloader">
                        <div class="pswp__preloader__icn">
                            <div class="pswp__preloader__cut">
                                <div class="pswp__preloader__donut"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div>
                </div>

                <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                </button>

                <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                </button>

                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('footerjs')
    <script>
        /*$('input[type=radio][name=account-type-radio]').change(function() {
            $.ajax({
                {{--url: "{{ route() }}",--}}
                cache: false,
                success: function(html){
                    $("#results").append(html);
                }
            });
        });*/

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

        function changeBookmark(){
            $.easyAjax({
                url: "{!! route('list.bookmark', $listing->id) !!}",
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

        $('#sendOffer').on('click', function(e) {
            @if($user)
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
                    mainClass: 'my-mfp-zoom-in'
                });
            @else
                Snackbar.show({
                    text: 'Please login for place bid',
                    pos: 'bottom-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 3000,
                    textColor: '#fff',
                    backgroundColor: '#ed6359'
                });
            @endif
        });

        $('#snackbar-place-bid').on('click', function(e) {
            @if($user)
                var amount = $('#budgetAmount').val();

                if(amount === '0' || amount === undefined || amount === 'NaN'  || amount === ''){
                    alert("Amount cann't be blank." );
                }
                else{
                    $.easyAjax({
                        url: "{!! route('list.offer') !!}",
                        type: "POST",
                        container: "#sendOfferForm",
                        data: $("#sendOfferForm").serialize(),
                        success: function (response) {
                            if(response.status == 'success') {
                                Snackbar.show({
                                    text: 'Your bid has been placed!'
                                });
                                $('.boxed-list-ul').append(response.postedData);
                                $.magnificPopup.close();
                                starRating('.star-rating');
                            }
                        }
                    });
                }
            @endif
            return false;
        });

        function starRating(ratingElem) {

            $(ratingElem).each(function() {

                var dataRating = $(this).attr('data-rating');

                // Rating Stars Output
                function starsOutput(firstStar, secondStar, thirdStar, fourthStar, fifthStar) {
                    return(''+
                    '<span class="'+firstStar+'"></span>'+
                    '<span class="'+secondStar+'"></span>'+
                    '<span class="'+thirdStar+'"></span>'+
                    '<span class="'+fourthStar+'"></span>'+
                    '<span class="'+fifthStar+'"></span>');
                }

                var fiveStars = starsOutput('star','star','star','star','star');

                var fourHalfStars = starsOutput('star','star','star','star','star half');
                var fourStars = starsOutput('star','star','star','star','star empty');

                var threeHalfStars = starsOutput('star','star','star','star half','star empty');
                var threeStars = starsOutput('star','star','star','star empty','star empty');

                var twoHalfStars = starsOutput('star','star','star half','star empty','star empty');
                var twoStars = starsOutput('star','star','star empty','star empty','star empty');

                var oneHalfStar = starsOutput('star','star half','star empty','star empty','star empty');
                var oneStar = starsOutput('star','star empty','star empty','star empty','star empty');

                // Rules
                if (dataRating >= 4.75) {
                    $(this).append(fiveStars);
                } else if (dataRating >= 4.25) {
                    $(this).append(fourHalfStars);
                } else if (dataRating >= 3.75) {
                    $(this).append(fourStars);
                } else if (dataRating >= 3.25) {
                    $(this).append(threeHalfStars);
                } else if (dataRating >= 2.75) {
                    $(this).append(threeStars);
                } else if (dataRating >= 2.25) {
                    $(this).append(twoHalfStars);
                } else if (dataRating >= 1.75) {
                    $(this).append(twoStars);
                } else if (dataRating >= 1.25) {
                    $(this).append(oneHalfStar);
                } else if (dataRating < 1.25) {
                    $(this).append(oneStar);
                }

            });

        }
    </script>
    <script>

        // Photo Boxes
        $(".photo-box, .photo-section, .video-container").each(function() {
            var photoBox = $(this);
            var photoBoxBG = $(this).attr('data-background-image');

            if(photoBox !== undefined) {
                $(this).css('background-image', 'url('+photoBoxBG+')');
            }
        });

        var initPhotoSwipeFromDOM = function(gallerySelector) {

            // parse slide data (url, title, size ...) from DOM elements
            // (children of gallerySelector)
            var parseThumbnailElements = function(el) {
                var thumbElements = el.childNodes,
                    numNodes = thumbElements.length,
                    items = [],
                    figureEl,
                    linkEl,
                    size,
                    item;

                for(var i = 0; i < numNodes; i++) {

                    figureEl = thumbElements[i]; // <figure> element

                    // include only element nodes
                    if(figureEl.nodeType !== 1) {
                        continue;
                    }

                    linkEl = figureEl.children[0]; // <a> element

                    size = linkEl.getAttribute('data-size').split('x');

                    // create slide object
                    item = {
                        src: linkEl.getAttribute('href'),
                        w: parseInt(size[0], 10),
                        h: parseInt(size[1], 10)
                    };



                    if(figureEl.children.length > 1) {
                        // <figcaption> content
                        item.title = figureEl.children[1].innerHTML;
                    }

                    if(linkEl.children.length > 0) {
                        // <img> thumbnail element, retrieving thumbnail url
                        item.msrc = linkEl.children[0].getAttribute('src');
                    }

                    item.el = figureEl; // save link to element for getThumbBoundsFn
                    items.push(item);
                }

                return items;
            };

            // find nearest parent element
            var closest = function closest(el, fn) {
                return el && ( fn(el) ? el : closest(el.parentNode, fn) );
            };

            // triggers when user clicks on thumbnail
            var onThumbnailsClick = function(e) {
                e = e || window.event;
                e.preventDefault ? e.preventDefault() : e.returnValue = false;

                var eTarget = e.target || e.srcElement;

                // find root element of slide
                var clickedListItem = closest(eTarget, function(el) {
                    return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
                });

                if(!clickedListItem) {
                    return;
                }

                // find index of clicked item by looping through all child nodes
                // alternatively, you may define index via data- attribute
                var clickedGallery = clickedListItem.parentNode,
                    childNodes = clickedListItem.parentNode.childNodes,
                    numChildNodes = childNodes.length,
                    nodeIndex = 0,
                    index;

                for (var i = 0; i < numChildNodes; i++) {
                    if(childNodes[i].nodeType !== 1) {
                        continue;
                    }

                    if(childNodes[i] === clickedListItem) {
                        index = nodeIndex;
                        break;
                    }
                    nodeIndex++;
                }



                if(index >= 0) {
                    // open PhotoSwipe if valid index found
                    openPhotoSwipe( index, clickedGallery );
                }
                return false;
            };

            // parse picture index and gallery index from URL (#&pid=1&gid=2)
            var photoswipeParseHash = function() {
                var hash = window.location.hash.substring(1),
                    params = {};

                if(hash.length < 5) {
                    return params;
                }

                var vars = hash.split('&');
                for (var i = 0; i < vars.length; i++) {
                    if(!vars[i]) {
                        continue;
                    }
                    var pair = vars[i].split('=');
                    if(pair.length < 2) {
                        continue;
                    }
                    params[pair[0]] = pair[1];
                }

                if(params.gid) {
                    params.gid = parseInt(params.gid, 10);
                }

                return params;
            };

            var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
                var pswpElement = document.querySelectorAll('.pswp')[0],
                    gallery,
                    options,
                    items;

                items = parseThumbnailElements(galleryElement);

                // define options (if needed)
                options = {

                    // define gallery index (for URL)
                    galleryUID: galleryElement.getAttribute('data-pswp-uid'),

                    getThumbBoundsFn: function(index) {
                        // See Options -> getThumbBoundsFn section of documentation for more info
                        var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
                            pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                            rect = thumbnail.getBoundingClientRect();

                        return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
                    }

                };

                // PhotoSwipe opened from URL
                if(fromURL) {
                    if(options.galleryPIDs) {
                        // parse real index when custom PIDs are used
                        // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                        for(var j = 0; j < items.length; j++) {
                            if(items[j].pid == index) {
                                options.index = j;
                                break;
                            }
                        }
                    } else {
                        // in URL indexes start from 1
                        options.index = parseInt(index, 10) - 1;
                    }
                } else {
                    options.index = parseInt(index, 10);
                }

                // exit if index not found
                if( isNaN(options.index) ) {
                    return;
                }

                if(disableAnimation) {
                    options.showAnimationDuration = 0;
                }

                // Pass data to PhotoSwipe and initialize it
                gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
                gallery.init();
            };

            // loop through all gallery elements and bind events
            var galleryElements = document.querySelectorAll( gallerySelector );

            for(var i = 0, l = galleryElements.length; i < l; i++) {
                galleryElements[i].setAttribute('data-pswp-uid', i+1);
                galleryElements[i].onclick = onThumbnailsClick;
            }

            // Parse URL and open gallery if it contains #&pid=3&gid=1
            var hashData = photoswipeParseHash();
            if(hashData.pid && hashData.gid) {
                openPhotoSwipe( hashData.pid ,  galleryElements[ hashData.gid - 1 ], true, true );
            }
        };

        // execute above function
        initPhotoSwipeFromDOM('.my-gallery');
		
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
@endsection
