@extends('user.layouts.app')

@section('style')
    <style>
        .p-15 {
            padding: 15px;
        }
    </style>
@endsection

@section('content')

    <!-- Dashboard Headline -->
	<div class="dashboard-headline">
        <h3>Messages</h3>

        <!-- Breadcrumbs -->
        <nav id="breadcrumbs" class="dark">
            <ul>
                <li><a href="{{ route('front.home') }}">Home</a></li>
                <li><a href="{{ route('user.dashboard.index') }}">Dashboard</a></li>
                <li>Messages</li>
            </ul>
        </nav>
    </div>

    <!-- Fun Facts Container -->
    <div class="messages-container margin-top-0">

        <div class="messages-container-inner">

            <!-- Messages -->
            <div class="messages-inbox">
                <div class="messages-headline">
                    <div class="input-with-icon">
                        <input id="autocomplete-input" class="with-border" type="text" placeholder="Search">
                        <i class="icon-material-outline-search"></i>
                    </div>
                </div>

                <ul id="message-user-list" class="message-group" data-simplebar>
                    @forelse($messageUsers as $messageUser)
                        @if($messageUsers->first() == $messageUser)
                            <li class="user-list active-message" data-user-id="{{ $messageUser->id }}" data-listing-id="{{ $messageUser->listing_id }}">
                        @else
                            <li class="user-list" data-user-id="{{ $messageUser->id }}" data-listing-id="{{ $messageUser->listing_id }}">
                        @endif
                            <a href="javascript:;">
                                <div class="message-avatar">
                                    <i class="status-icon status-{{ $messageUser->status ? 'online' : 'offline' }}"></i>
                                    <img src="{{ $messageUser->image() }}" alt="" />
                                </div>
                                <div class="message-by">
                                    <div class="message-by-headline">
                                        <h5 class="list-user-name">{{ $messageUser->first_name . ' ' . $messageUser->last_name }}</h5>
                                        <span> {{ $messageUser->message_created_at != '' ? $messageUser->message_created_at->diffForHumans() : '' }}</span>
                                    </div>
                                    @if(strpos($messageUser->message, 'Offer From'))
                                        Offer Received
                                    @elseif(strpos($messageUser->message, 'Cancellation Request'))
                                        Cancellation Request
                                    @elseif(strpos($messageUser->message, 'Invitation Received'))
                                        Invitation Received
                                    @elseif(strpos($messageUser->message, 'Send a better one'))
                                        Offer Decline
                                    @elseif(strpos($messageUser->message, 'Counter Offer'))
                                        Counter Offer
                                    @else
                                        {!! $messageUser->message !!}
                                    @endif
                                </div>
                            </a>
                        </li>
                    @empty
                        <p style="padding-left: 20px; padding-top: 15px;">Inbox Empty</p>
                    @endforelse
                </ul>
            </div>
            <!-- Messages / End -->

            <!-- Message Content -->
            <div class="message-content">
                <div class="messages-headline">
                    @if($messageUsers->count())
                        <h4 id="from_user_name" data-user-id="{{ $messageUsers->first()->id }}">{{ $messageUsers->first()->first_name . ' ' . $messageUsers->first()->last_name }}</h4>
                        <a href="#" class="message-action messageDelete" data-to-user-id="{{ $user->id }}" data-user-id="{{ $messageUsers->first()->id }}"><i class="icon-feather-trash-2"></i> Delete Conversation</a>
                    @endif
                </div>

                <!-- Message Content Inner -->
                <div class="message-content-inner reverse-scroll" id="" data-simplebar>
                    @forelse($allMessage as $key => $firstUserMessage)
{{--                        <div class="message-time-sign {{$firstUserMessage->created_at->diffInDays(\Carbon\Carbon::now())}}">--}}
{{--                            <span>{{ $firstUserMessage->created_at->diffInDays(\Carbon\Carbon::now()) > 3 ? $firstUserMessage->created_at->format('d M Y') : $firstUserMessage->created_at->diffForHumans()  }}</span>--}}
{{--                        </div>--}}
                        <div class="message-bubble {{ $firstUserMessage->user_id == $user->id ? 'me' : '' }}">
                            <div class="message-bubble-inner">
                                <div class="message-avatar"><img src="{{ $firstUserMessage->fromuser->image() }}" alt="" /></div>
                                <div class="message-text" data-message-id="{{ $firstUserMessage->id }}">
                                    {!! $firstUserMessage->message !!}
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        @php
                            if ($key == 0){
                                $date = $firstUserMessage->created_at->format('d M Y');
                                echo '<div class="message-time-sign"><span>'.$date.'</span></div>';
                            }
                            if ($date != $firstUserMessage->created_at->format('d M Y')){
                                $date = $firstUserMessage->created_at->format('d M Y');
                                echo '<div class="message-time-sign"><span>'.$date.'</span></div>';
                            }
                        @endphp
                    @empty
                        <p>No messages available</p>
                    @endforelse
                </div>
                <!-- Message Content Inner / End -->

                <!-- Reply Area -->
                <div class="message-reply">
                    <textarea id="message" cols="1" rows="1" placeholder="Your Message" data-autoresize></textarea>
                    <button class="save-message button ripple-effect">Send</button>
                </div>

            </div>
            <!-- Message Content -->

        </div>
    </div>



@endsection

@section('footerjs')
    <script src="{{ asset('js/tabby.js') }}"></script>
    <!-- Snackbar // documentation: https://www.polonel.com/snackbar/ -->
    <script>
       function acceptDispute(dispiuteId){
           console.log('accept');
           var url = "{{ route('user.message.accept-dispute',[':dispiuteId']) }}";
           url = url.replace(':dispiuteId', dispiuteId);
           $.easyAjax({
               url: url,
               type: "GET",
               container: "#small-dialog-10",
               success: function (response) {
               }
           });
       }
       function declineDispute(dispiuteId){
           var url = "{{ route('user.message.decline-dispute',[':dispiuteId']) }}";
           url = url.replace(':dispiuteId', dispiuteId);
           $.easyAjax({
               url: url,
               type: "GET",
               container: "#small-dialog-10",
               success: function (response) {
               }
           });
       }
        window.setInterval(function () {
            var to_user = $('.user-list.active-message').data('user-id');
            getMessage(to_user);
        }, 5000);
        function getMessage(fromUser){
            var url = "{{ route('user.message.get-message',':id') }}";
            url = url.replace(':id', fromUser);
            $.ajax({
                url: url,
                type: "GET",
                container: ".messages-container-inner",
                success: function (response) {
                    $('#customScroll').html(response.view);
                    // simplebar-content
                    var el = new SimpleBar(document.getElementById('customScroll'));
                    el.getContentElement();
                    el.getScrollElement().scrollTop = 10000;
                }
            });
        }
        $(document).on('click', '.user-list', function(){
            $(this).siblings().removeClass('active-message');
            $(this).addClass('active-message');
            var newUserName = $(this).find('.list-user-name').text();
            $('#from_user_name').text(newUserName);
            var newUserId = $(this).data('user-id');
            $('#from_user_name').attr('data-user-id', newUserId);
            $('.messages-headline .message-action').attr('data-user-id', newUserId);

            var fromUser = $(this).data('user-id');
            getMessage(fromUser)
        });
        $(document).on('click', '.message-text .accept-offer', function(e){
            if(!$(this).parents('.message-bubble').hasClass( "me" )){
                var id = $(this).data('offer-id');
                var messageId = $(this).parents('.message-text').data('message-id');
                var userId = $('#from_user_name').data('user-id');
                var url = "{{ route('user.message.acceptOffer',[':id', ':userId', ':messageId']) }}";
                url = url.replace(':id', id);
                url = url.replace(':userId', userId);
                url = url.replace(':messageId', messageId);
                $.easyAjax({
                    url: url,
                    type: "GET",
                    container: "#small-dialog-10",
                    success: function (response) {
                    }
                });
            }

        });

        $(document).on('click', '.message-text .decline-offer', function(e){
            if(!$(this).parents('.message-bubble').hasClass( "me" )){
                var id = $(this).data('offer-id');
                var messageId = $(this).parents('.message-text').data('message-id');
                var userId = $('#from_user_name').data('user-id');
                var url = "{{ route('user.message.declineOffer',[':id', ':userId', ':messageId']) }}";
                url = url.replace(':id', id);
                url = url.replace(':userId', userId);
                url = url.replace(':messageId', messageId);
                $.easyAjax({
                    url: url,
                    type: "GET",
                    container: "#small-dialog-10",
                    success: function (response) {
                    }
                });
            }

        });
        $(document).on('click', '.save-message', function () {
            var to_user = $('.user-list.active-message').data('user-id');
            var listing_id = $('.user-list.active-message').data('listing-id');
            var text = $('#message').val();
            var withBRs = text.replace(/\n/g, "<br />") ;
            var message = '<p>' + withBRs + '</p>' ;

            $.ajax({
                url: "{{ route('user.message.store') }}",
                type: "POST",
                container: ".message-reply",
                data: {'to_user' : to_user, 'message' : message, 'listing_id' : listing_id, '_token': "{{ csrf_token() }}" },
                success: function (response) {
                    getMessage(to_user);
                    $('#message').val('');
                }
            });
        });

        $(document).on('keyup', '.messages-headline #autocomplete-input', function () {
            var term = $(this).val();
            if(term){
                getUsers(term);
            }
            else{
                getUsers('all');
            }
        });

        function getUsers(term){
            var url = "{{ route('user.message.messageSearch', ':term') }}";
            url = url.replace(':term', term);
            $.easyAjax({
                url: url,
                type: "GET",
                container: "#small-dialog-10",
                success: function (response) {
                    $('.message-group').html(response.view);
                    const simpleBar = new SimpleBar(document.getElementById('message-user-list'));
                    simpleBar.getContentElement();
                }
            });
        }

        $(document).on('click', '.messageDelete', function () {
            var fromUser = $(this).data('user-id');
            var url = "{{ route('user.message.destroy',':id') }}";
            url = url.replace(':id', fromUser);
            $.easyAjax({
                url: url,
                type: "Delete",
                container: ".message-content",
                success: function (response) {
                    // $('#listingRow'+id).remove();
                    // $.magnificPopup.close();
                }
            });
        });


    </script>
@endsection
