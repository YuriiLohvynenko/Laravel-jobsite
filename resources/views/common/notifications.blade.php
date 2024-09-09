<!-- Trigger -->
<div class="header-notifications-trigger">
    <a href="javascript:void(0);"><i class="icon-feather-bell"></i><span>{{ $unreadNotifications->count() }}</span></a>
</div>

<!-- Dropdown -->
<div class="header-notifications-dropdown">

    <div class="header-notifications-headline">
        <h4>Notifications</h4>
        @if ($unreadNotifications->count() > 0)
            <button class="mark-as-read ripple-effect-dark" title="Mark all as read" data-tippy-placement="left">
                <i class="icon-feather-check-square"></i>
            </button>
        @endif
    </div>

    <div class="header-notifications-content">
        <div class="header-notifications-scroll" data-simplebar>
            <ul id="notifications-list">
            @forelse($unreadNotifications as $notification)
                <!-- Notification -->
                <li class="notifications-not-read">
                    <a href="javascript:void(0);" data-notification_id="{{ $notification->id }}">
                        <span class="notification-icon">
                            <i class="icon-material-outline-group"></i>
                        </span>
                        <span class="notification-text">
                            @switch($notification->type)
                                @case('App\Notifications\NewBidCreated')
                                    <strong>{{ $notification->data['user_name'] }}</strong> placed a bid on your <span class="color">{{ $notification->data['project_name'] }}</span> project
                                @break
                                @case('App\Notifications\ListingExpire')
                                    Your job listing <span class="color">{{ $notification->data['listing_name'] }}</span> is expiring.
                                @break
                                @case('App\Notifications\NewJobInvitation')
                                    <strong>{{ $notification->data['user_name'] }}</strong> sent you an invitation for <span class="color">{{ $notification->data['listing_name'] }}</span> project.
                                @break
                            @endswitch
                        </span>
                    </a>
                </li>
            @empty
                <li class="notifications-not-read">
                    <a href="javascript:void(0);">
                        <span class="notification-text">
                            <strong>No new notifications</strong>
                        </span>
                    </a>
                </li>
            @endforelse

            <!-- Notification -->
                {{--                            <li class="notifications-not-read">--}}
                {{--                                <a href="dashboard-manage-candidates.html">--}}
                {{--                                    <span class="notification-icon"><i class="icon-material-outline-group"></i></span>--}}
                {{--                                    <span class="notification-text">--}}
                {{--                                                        <strong>Michael Shannah</strong> applied for a job <span class="color">Full Stack Software Engineer</span>--}}
                {{--                                                    </span>--}}
                {{--                                </a>--}}
                {{--                            </li>--}}

                {{--                            <!-- Notification -->--}}
                {{--                            <li>--}}
                {{--                                <a href="dashboard-manage-candidates.html">--}}
                {{--                                    <span class="notification-icon"><i class="icon-material-outline-group"></i></span>--}}
                {{--                                    <span class="notification-text">--}}
                {{--                                                        <strong>Sindy Forrest</strong> applied for a job <span class="color">Full Stack Software Engineer</span>--}}
                {{--                                                    </span>--}}
                {{--                                </a>--}}
                {{--                            </li>--}}
            </ul>
        </div>
    </div>

</div>
