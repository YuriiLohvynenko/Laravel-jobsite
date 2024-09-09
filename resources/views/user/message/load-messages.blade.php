@forelse($allMessage as $key => $firstUserMessage)
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
    <p>No Messages</p>
@endforelse
