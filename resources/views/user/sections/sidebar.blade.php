<!-- Dashboard Sidebar
================================================== -->
<div class="dashboard-sidebar">
    <div class="dashboard-sidebar-inner" data-simplebar>
        <div class="dashboard-nav-container">

            <!-- Responsive Navigation Trigger -->
            <a href="#" class="dashboard-responsive-nav-trigger">
					<span class="hamburger hamburger--collapse" >
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</span>
                <span class="trigger-title">Dashboard Navigation</span>
            </a>

            <!-- Navigation -->
            <div class="dashboard-nav">
                <div class="dashboard-nav-inner">

                    <div class="row create-project">
                        <div class="col">
                            <a href="{{ route('user.listing.create') }}" class="button ripple-effect button-sliding-icon">Create Project <i class="icon-feather-check"></i></a>
                        </div>
                    </div>
					
					<ul data-submenu-title="Dashboard">
                        <li class="@if(strpos(\Request::route()->getName(),'user.dashboard.index') !== false) active @endif"><a href="{{ route('user.dashboard.index') }}"><i class="icon-material-outline-dashboard"></i> Activity</a></li>
                        <li><a href="{{ route('user.listing.index') }}"><i class="icon-material-outline-business-center"></i> Projects</a></li>
                        <li><a href="{{ route('user.badges.index') }}"><i class="icon-material-outline-assignment"></i> Badges</a></li>
					</ul>

                    <ul data-submenu-title="Manage">
                        <li><a href="{{ route('user.message.index') }}"><i class="icon-material-outline-question-answer"></i> Messages <span class="nav-tag unreadMessageCount">{{ $unseenMessages->count() }}</span></a></li>
                        <li><a href="{{ route('user.bookmark.index') }}"><i class="icon-material-outline-star-border"></i> Bookmarks</a></li>
                        <li><a href="{{ route('user.review.index') }}"><i class="icon-material-outline-rate-review"></i> Leave Reviews</a></li>
                    </ul>

                    <ul data-submenu-title="Account">
                        <li><a href="{{ route('user.track-job.index') }}"><i class="icon-material-outline-power-settings-new"></i> View Jobs Live</a></li>
                        <li><a href="{{ route('setting.dashboard-setting.index') }}"><i class="icon-material-outline-settings"></i> My Profile</a></li>
                        <li><a href="{{ route('setting.dashboard-setting.index') }}"><i class="icon-material-outline-settings"></i> Settings</a></li>
                    </ul>

                </div>
            </div>
            <!-- Navigation / End -->

        </div>
    </div>
</div>
<!-- Dashboard Sidebar / End -->
