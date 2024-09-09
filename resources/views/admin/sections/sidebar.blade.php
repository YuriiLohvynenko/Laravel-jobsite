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
                            <a href="{{ route('admin.dashboard-setting.index') }}" class="button ripple-effect button-sliding-icon">Change Settings <i class="icon-feather-check"></i></a>
                        </div>
                    </div>

                    <ul>
                        <li class="active"><a href="{{ route('admin.dashboard.index') }}"><i class="icon-material-outline-dashboard"></i> Overview</a></li>
                        <li><a href="{{ route('admin.messages.index') }}"><i class="icon-material-outline-question-answer"></i> Messages <span class="nav-tag unreadMessageCount">{{ $unseenMessages->count() }}</span></a></li>
                        <li><a href="{{ route('admin.reviews.index') }}"><i class="icon-material-outline-rate-review"></i> Reviews</a></li>
                    </ul>

                    <ul>
                        <li><a href="{{ route('admin.jobs.index') }}"><i class="icon-material-outline-business-center"></i> Jobs</a></li>
                        <li><a href="{{ route('admin.badges.index') }}"><i class="icon-material-outline-assignment"></i> Badges</a></li>
                        <li><a href="{{ route('admin.dispute.index') }}"><i class="icon-material-outline-assignment"></i> Resolution Center</a></li>
                    </ul>

                    <ul>
                        <li><a href="{{ route('admin.users.index') }}"><i class="icon-material-outline-settings"></i> Users</a></li>
                        <li><a href="{{ route('admin.dashboard-setting.index') }}"><i class="icon-material-outline-settings"></i> Settings</a></li>
                    </ul>

                </div>
            </div>
            <!-- Navigation / End -->

        </div>
    </div>
</div>
<!-- Dashboard Sidebar / End -->
