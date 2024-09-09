@forelse($messageUsers as $messageUser)
    @if($messageUsers->first() == $messageUser)
        <li class="user-list active-message" data-user-id="{{ $messageUser->id == $user->id ? $messageUser->to_user : $messageUser->id }}" data-listing-id="{{ $messageUser->listing_id }}">
    @else
        <li class="user-list" data-user-id="{{ $messageUser->id == $user->id ? $messageUser->to_user : $messageUser->id }}" data-listing-id="{{ $messageUser->listing_id }}">
    @endif
    <a href="javascript:;">
        <div class="message-avatar">
            <i class="status-icon status-{{ $messageUser->status ? 'online' : 'offline' }}"></i>
            <img src="{{ $messageUser->image() }}" alt="" />
        </div>
        <div class="message-by">
            <div class="message-by-headline">
                <h5 class="list-user-name">{{ $messageUser->first_name . ' ' . $messageUser->last_name }}r</h5>
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
