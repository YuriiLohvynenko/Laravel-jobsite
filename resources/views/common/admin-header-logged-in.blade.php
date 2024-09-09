<!-- Left Side Content -->
<div class="left-side">

    <!-- Logo -->
    <div id="logo">
        <a href="{{ route('front.home') }}"><img src="{{ asset('images/admin-logo.png') }}" data-sticky-logo="{{ asset('images/logo.png') }}" data-transparent-logo="{{ asset('images/logo2.png') }}" alt=""></a>
    </div>

    <!-- Main Navigation -->
    <nav id="navigation">
        <ul id="responsive">

            <li><a href="#"><i class="icon-feather-home blue-icon"></i> Dashboard Home</a>
            </li>

            <li><a href="{{ url('/') }}" target="_blank"><i class="icon-feather-search blue-icon"></i> View Website</a>
            </li>

        </ul>
    </nav>
    <div class="clearfix"></div>
    <!-- Main Navigation / End -->

</div>
<!-- Left Side Content / End -->


<!-- Right Side Content / End -->
<div class="right-side">

    <!--  User Notifications -->
    <div class="header-widget hide-on-mobile">

        <!-- Notifications -->
{{--        <div id="notifications" class="header-notifications">--}}
{{--            @include('common.notifications', ['unreadNotifications' => $user->unreadNotifications])--}}
{{--        </div>--}}

        <!-- Messages -->
        <div class="header-notifications">
            <div class="header-notifications-trigger">
                <a href="#"><i class="icon-feather-mail"></i><span class="unreadMessageCount">{{ $unseenMessages->count() }}</span></a>
            </div>

            <!-- Dropdown -->
            <div class="header-notifications-dropdown">

                <div class="header-notifications-headline">
                    <h4>Messages</h4>
                    <button class="mark-as-read ripple-effect-dark" title="Mark all as read" data-tippy-placement="left">
                        <i class="icon-feather-check-square"></i>
                    </button>
                </div>

                <div class="header-notifications-content">
                    <div class="header-notifications-scroll" data-simplebar>
                        <ul>
                            <!-- Notification -->
                            @forelse($unseenMessages as $unseenMessage)
                                <li class="notifications-not-read">
                                    <a href="{{ route('admin.messages.index') }}">
                                        <span class="notification-avatar status-online"><img src="{{ $unseenMessage->fromUser->image() }}" alt=""></span>
                                        <div class="notification-text">
                                            <strong>{{ $unseenMessage->first_name . ' ' . $unseenMessage->last_name }}</strong>
                                            @if(strpos($unseenMessage->message, 'Offer From'))
                                                Offer Received
                                            @elseif(strpos($unseenMessage->message, 'Cancellation Request'))
                                                Cancellation Request
                                            @elseif(strpos($unseenMessage->message, 'Invitation Received'))
                                                Invitation Received
                                            @elseif(strpos($unseenMessage->message, 'Send a better one'))
                                                Offer Decline
                                            @elseif(strpos($unseenMessage->message, 'Counter Offer'))
                                                Counter Offer
                                            @else
                                                {!! $unseenMessage->message !!}
                                            @endif
{{--                                            {!! strpos($unseenMessage->message, 'Offer From') ? 'Offer Received' : $unseenMessage->message !!}--}}
                                            <span class="color">{{ $unseenMessage->created_at->diffForHumans() }}</span>
                                        </div>
                                    </a>
                                </li>
                            @empty
                            @endforelse
                        </ul>
                    </div>
                </div>
                <a href="{{ route('admin.messages.index') }}" class="header-notifications-button ripple-effect button-sliding-icon">View All Messages<i class="icon-material-outline-arrow-right-alt"></i></a>
            </div>
        </div>

    </div>
    <!--  User Notifications / End -->

    <!-- User Menu -->
    <div class="header-widget">

        <!-- Messages -->
        <div class="header-notifications user-menu">
            <div class="header-notifications-trigger">
                <a href="javascript:;"><div class="user-avatar @if($user->status == 1) status-online @endif"><img src="{{ $user->image() }}" alt="" class="profile-image-change"></div></a>
            </div>

            <!-- Dropdown -->
            <div class="header-notifications-dropdown">

                <!-- User Status -->
                <div class="user-status">

                    <!-- User Name / Avatar -->
                    <div class="user-details">
                        <div class="user-avatar @if($user->status == 1) status-online @endif"><img src="{{ $user->image() }}" alt="" class="profile-image-change"></div>
                        <div class="user-name">
                            {{ ucwords($user->full_name) }} <span>Admin</span>
                        </div>
                    </div>

                    <!-- User Status Switcher -->
                    <div class="status-switch" id="snackbar-user-status">
                        <label class="user-online @if($user->status == 1) current-status @endif">Online</label>
                        <label class="user-invisible @if($user->status == 0) current-status @endif">Invisible</label>
                        <!-- Status Indicator -->
                        <span class="status-indicator" aria-hidden="true"></span>
                    </div>
                </div>

                <ul class="user-menu-small-nav">
                    <li><a href="{{ route('admin.dashboard.index') }}"><i class="icon-material-outline-dashboard"></i> Dashboard</a></li>
                    <li><a href="{{ route('admin.dashboard-setting.index') }}"><i class="icon-material-outline-settings"></i> Settings</a></li>
                    <li><a href="{{ route('admin.logout') }}"><i class="icon-material-outline-power-settings-new"></i> Logout</a></li>
                </ul>
            </div>
        </div>

    </div>
    <!-- User Menu / End -->

    <!-- Mobile Navigation Button -->
    <span class="mmenu-trigger">
        <button class="hamburger hamburger--collapse" type="button">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </button>
    </span>

</div>
<!-- Right Side Content / End -->

@push('script')
    <script>
        $('body').on('click', 'button.mark-as-read, li.notifications-not-read a', function() {
            let notification_id = $(this).data('notification_id') ? $(this).data('notification_id') : 'all';

            let url = '{{ route('notifications.markAsRead', [':notification_id']) }}';
            url = url.replace(':notification_id', notification_id);
            let token = '{{ csrf_token() }}';

            $.easyAjax({
                url: url,
                type: 'POST',
                data: { _token: token },
                success: function(response) {
					alert("h");
					toastr.success('Have fun storming the castle!', 'Miracle Max Says')
					console.log(response);
                    $('#notifications').html(response.view);
                }
            })
        });
    </script>
@endpush
