@extends('user.layouts.app')

@section('style')
@endsection

@section('content')

    <div class="dashboard-headline">
        <h3>Reviews</h3>

        <!-- Breadcrumbs -->
        <nav id="breadcrumbs" class="dark">
            <ul>
                <li><a href="{{ route('front.home') }}">Home</a></li>
                <li><a href="{{route('user.dashboard.index')}}">Dashboard</a></li>
                <li>Reviews</li>
            </ul>
        </nav>
    </div>

    <!-- Row -->
    <div class="row">

        <!-- Dashboard Box -->
        <!-- Dashboard Box -->
        <div class="col-xl-6 margin-bottom-40">
            <div class="dashboard-box margin-top-0">

                <!-- Headline -->
                <div class="headline">
                    <h3><i class="icon-material-outline-business"></i> Rate Clients</h3>
                </div>

                <div class="content">
                    <ul class="dashboard-box-list" id="freelancerBoxList">
                        @forelse($clients as $client)
                            <li>
                                <div class="boxed-list-item" id="clientBox{{$client->list_id}}">
                                    <!-- Content -->
                                    <div class="item-content">
                                        <h4>{{ ucfirst($client->job_title) }}</h4>

                                            <span id="nonRatingBox_client{{$client->list_id}}" class="company-not-rated margin-bottom-5" @if($client->freelance_client != null) style="display: none;" @endif>Not Rated</span>
                                            <div  id="ratingBox_client{{$client->list_id}}"  class="item-details margin-top-10 "  @if($client->freelance_client == null) style="display: none;" @endif>
                                                <div class="star-rating" id="rating_client{{ $client->list_id }}" data-rating="@if($client->freelance_client != null){{ $client->freelance_client->rating }}@endif"></div>
                                                <div class="detail-item"><i class="icon-material-outline-date-range"></i>@if($client->freelance_client != null) {{ $client->freelance_client->created_at->format('F  Y ')}} @endif</div>
                                            </div>
                                            <div  id="descBox_client{{$client->list_id}}" class="item-description"  @if($client->freelance_client == null) style="display: none;" @endif>
                                                <p id="rating_desc{{ $client->list_id }}">@if($client->freelance_client != null){{ $client->freelance_client->description }}@endif</p>
                                            </div>
                                    </div>
                                </div>
                                @if($client->feedback_count == 0)
                                    <a href="javascript:;" id="sendBoxButton{{ $client->list_id }}" onclick="sendFeedback({{ $client->list_id }}, 'client'); return false;" class="popup-with-zoom-anim button ripple-effect margin-top-5 margin-bottom-10"><i class="icon-material-outline-thumb-up"></i> Leave a Review</a>
                                @endif
                            </li>
                        @empty
                            <li class="fancybox-loading">
                                <div class="boxed-list-item">
                                    No Reviews Available
                                </div>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Pagination -->
            {{--<div class="clearfix"></div>--}}
            {{--<div class="pagination-container margin-top-40 margin-bottom-0">--}}
                {{--<nav class="pagination">--}}
                    {{--<ul>--}}
                        {{--<li><a href="#" class="ripple-effect current-page">1</a></li>--}}
                        {{--<li><a href="#" class="ripple-effect">2</a></li>--}}
                        {{--<li><a href="#" class="ripple-effect">3</a></li>--}}
                        {{--<li class="pagination-arrow"><a href="#" class="ripple-effect"><i class="icon-material-outline-keyboard-arrow-right"></i></a></li>--}}
                    {{--</ul>--}}
                {{--</nav>--}}
            {{--</div>--}}
            <div class="clearfix"></div>
            <!-- Pagination / End -->

        </div>

        <!-- Dashboard Box -->
        <div class="col-xl-6">
            <div class="dashboard-box margin-top-0">

                <!-- Headline -->
                <div class="headline">
                    <h3><i class="icon-material-outline-face"></i> Rate Freelancers</h3>
                </div>

                <div class="content">
                    <ul class="dashboard-box-list" id="clientBoxList">
                        @forelse($freelancers as $freelancer)
                            <li id="fancybox-loading">
                                <div class="boxed-list-item" id="freelanceBox{{$freelancer->list_id}}">
                                    <!-- Content -->
                                    <div class="item-content">
                                        <h4>{{ ucfirst($freelancer->job_title) }}</h4>
                                            <span id="nonRatingBox_freelance{{$freelancer->list_id}}" class="company-not-rated margin-bottom-5" @if($freelancer->freelance_feedback != null) style="display: none;" @endif>Not Rated</span>
                                            <div id="ratingBox_freelancer{{$freelancer->list_id}}" class="item-details margin-top-10" @if($freelancer->freelance_feedback == null) style="display: none;" @endif>
                                                <div class="star-rating" id="rating_freelancer{{ $freelancer->list_id }}" data-rating="@if($freelancer->freelance_feedback != null){{ $freelancer->freelance_feedback->rating }}@endif"></div>
                                                <div class="detail-item"><i class="icon-material-outline-date-range"></i> @if($freelancer->freelance_feedback != null){{ $freelancer->freelance_feedback->created_at->format('F  Y ')}}@endif</div>
                                            </div>
                                            <div class="item-description" id="descBox_freelancer{{$client->list_id}}"  @if($freelancer->freelance_feedback == null) style="display: none;" @endif>
                                                <p id="desc_freelancer{{ $freelancer->list_id }}">@if($freelancer->freelance_feedback != null) {{ $freelancer->freelance_feedback->description }}@endif</p>
                                            </div>
                                    </div>
                                </div>
                                @if($freelancer->freelance_feedback == null)
                                    <a href="javascript:;" id="sendBoxButton{{ $freelancer->list_id }}" onclick="sendFeedback({{ $freelancer->list_id }}, 'freelancer'); return false;" class="popup-with-zoom-anim button ripple-effect margin-top-5 margin-bottom-10"><i class="icon-material-outline-thumb-up"></i> Leave a Review</a>
                                @endif
                            </li>
                        @empty
                            <li class="fancybox-loading">
                                <div class="boxed-list-item">
                                    No Reviews Available
                                </div>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>


    </div>
    <!-- Row / End -->
    <!-- Leave Feedback - Completed -->
    <div id="small-dialog-1" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
        <!--Tabs -->
        <div class="sign-in-form">
            <div class="popup-tabs-container">
                <!-- Tab -->
                <div class="popup-tab-content" id="tab">
                    <!-- Welcome Text -->
                    <div class="padding-bottom-0 " id="modalData">
                    </div>

                </div>

            </div>
        </div>
    </div>
    <!-- Leave Feedback - Completed / End -->


@endsection

@section('footerjs')
    <script src="{{ asset('js/tabby.js') }}"></script>
    <!-- Snackbar // documentation: https://www.polonel.com/snackbar/ -->

    <script>

        function sendFeedback(id, type){

            var url = "{{ route('user.review.model-view',[':id', ':type']) }}";
            url = url.replace(':id', id);
            url = url.replace(':type', type);
            $.easyAjax({
                url: url,
                type: "GET",
                container: "#small-dialog-10",
                success: function (response) {
                    console.log(response);
                    $('#modalData').html(response.view);
                    }
            });
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
        }

        // Update selector to match your button
        function submitForm() {
            $.easyAjax({
                url: "{!! route('user.review.store') !!}",
                type: "POST",
                container: ".feedbackPost",
                data: $(".feedbackPost").serialize(),
                success: function (response) {
                    if(response.type == 'client'){
                        $('#clientBox'+response.list_id).html(response.view);
                    }
                    else{
                        $('#freelanceBox'+response.list_id).html(response.view);
                    }
                    $('#sendBoxButton'+response.list_id).remove();
                    starRating('.rating'+response.list_id);

                    $.magnificPopup.close();
                }
            });
            return false;
        }

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
@endsection
