@extends('admin.layouts.admin-app')

@section('style')
@endsection

@section('content')
    <!-- Dashboard Headline -->
    <div class="margin-bottom-10">
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 margin-bottom-20">
                <h3>Admin Panel</h3>
                <div class="crate-note margin-top-5">Welcome, {{ $user->full_name }}</div>
            </div>
            <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                <div class="row center-field">
                    <div class="col-md-3 col-sm-3 no-padding">
                        <div class="headline-sub">Total Paid</div>
                        <div class="headline-sub-">$1,520,450</div>
                    </div>
                    <div class="col-md-3 col-sm-3 no-padding">
                        <div class="headline-sub">Total Earned</div>
                        <div class="headline-sub-">$500,650</div>
                    </div>
                    <div class="col-md-3 col-sm-3 no-padding">
                        <div class="headline-sub">Total Cashback</div>
                        <div class="headline-sub-">$15,204.50</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-3 col-sm-12 hide-under-1221px">
                <!-- Breadcrumbs -->
                <nav id="breadcrumbs" class="dark fixed-breadcrumbs pull-right">
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li>Dashboard</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>





    <div class="margin-bottom-30">
        <!-- Row -->
        <div class="row">

            <div class="col-xl-8">
                <!-- Dashboard Box -->
                <div class="dashboard-box main-box-in-row margin-top-5 margin-bottom-20">
                    <div class="headline">
                        <h3><i class="icon-feather-bar-chart-2"></i> Platform Revenue (11%)</h3>
                        <div class="sort-by">
                            <select class="selectpicker hide-tick">
                                <option>Last 6 Months</option>
                                <option>This Year</option>
                                <option>This Month</option>
                            </select>
                        </div>
                    </div>
                    <div class="content">
                        <!-- Chart -->
                        <div class="chart">
                            <canvas id="chart" width="100" height="45"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Dashboard Box / End -->
            </div>
            <div class="col-xl-4">
                <div class="crate">
                    <div class="crate-inner crate-padding add-radius add-shadow add-white crate- margin-bottom-20">
                        <div class="row">
                            <div class="col-md-8 col-sm-8 center-vertical white-text">
                                <i class="icon-feather-shopping-bag crate-icon-centered margin-right-10"></i>
                                <div class="crate-header">Total Users</div>
                            </div>
                            <div class="col-md-4 col-sm-4 no-padding">
                                <div class="crate-header- white-text center">{{ $totalUser }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="crate">
                    <div class="crate-inner crate-padding add-white add-radius add-shadow margin-bottom-20">
                        <div class="row">
                            <div class="col-8 center-vertical blue-icon">
                                <i class="icon-feather-shopping-bag crate-icon-centered margin-right-10"></i>
                                <div class="crate-header">Badge Requests</div>
                            </div>
                            <div class="col-4">
                                <div class="crate-header- center">{{ $totalBadgeRequest }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="crate">
                    <div class="crate-inner crate-padding add-white add-radius add-shadow margin-bottom-20">
                        <div class="row">
                            <div class="col-8 center-vertical blue-icon">
                                <i class="icon-feather-shopping-bag crate-icon-centered margin-right-10"></i>
                                <div class="crate-header">Open Disputes</div>
                            </div>
                            <div class="col-4">
                                <div class="crate-header- center">{{ $totalOpenDispute }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="crate">
                    <div class="crate-inner crate-padding add-white add-radius add-shadow margin-bottom-20">
                        <div class="row">
                            <div class="col-8 center-vertical blue-icon">
                                <i class="icon-feather-shopping-bag crate-icon-centered margin-right-10"></i>
                                <div class="crate-header">Total Listings</div>
                            </div>
                            <div class="col-4">
                                <div class="crate-header- center">{{ $totalListings }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="crate">
                    <div class="crate-inner crate-padding add-white add-radius add-shadow margin-bottom-20">
                        <div class="row">
                            <div class="col-8 center-vertical blue-icon">
                                <i class="icon-feather-shopping-bag crate-icon-centered margin-right-10"></i>
                                <div class="crate-header">Completed Listings</div>
                            </div>
                            <div class="col-4">
                                <div class="crate-header- center">{{ $totalCompletedListings }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 margin-bottom-40">
            <div class="crate">
                <div class="crate-inner crate-padding add-white add-radius add-shadow">
                    <div class="row">
                        <div class="col-3 center-vertical blue-icon">
                            <i class="icon-feather-tag crate-icon-centered"></i>
                        </div>
                        <div class="col-9">
                            <div class="crate-header ellipsis">Payout (this week)</div>
                            <div class="crate-header-">$50,080</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 margin-bottom-40">
            <div class="crate">
                <div class="crate-inner crate-padding add-white add-radius add-shadow">
                    <div class="row">
                        <div class="col-3 center-vertical blue-icon">
                            <i class="icon-feather-truck crate-icon-centered"></i>
                        </div>
                        <div class="col-9">
                            <div class="crate-header ellipsis">Earned (this week)</div>
                            <div class="crate-header-">$50,080</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 margin-bottom-40">
            <div class="crate">
                <div class="crate-inner crate-padding add-white add-radius add-shadow">
                    <div class="row">
                        <div class="col-3 center-vertical blue-icon">
                            <i class="icon-feather-navigation crate-icon-centered"></i>
                        </div>
                        <div class="col-9">
                            <div class="crate-header ellipsis">Weekly Cashback</div>
                            <div class="crate-header-">$500.80</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 margin-bottom-40">
            <div class="crate">
                <div class="crate-inner crate-padding add-white add-radius add-shadow">
                    <div class="row">
                        <div class="col-3 center-vertical blue-icon">
                            <i class="icon-feather-shopping-bag crate-icon-centered"></i>
                        </div>
                        <div class="col-9">
                            <div class="crate-header">Profit (11%)</div>
                            <div class="crate-header-">$55,000</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-sm-6 margin-bottom-20">
            <div class="crate add-radius add-shadow add-white">
                <div class="crate-head crate-custom">
                    <div class="row">
                        <div class="col">Jobs Assigned</div>
                        <div class="col"><a href="#" class="button gray ripple-effect button-sliding-icon btn-addon">View All <i class="icon-feather-arrow-right"></i></a></div>
                    </div>
                </div>
                <div class="crate-inner">
                    <div class="row">
                        <div class="chart center">
                            <canvas class="liveupdate" width="150" height="150"></canvas>
                        </div>
                    </div>
                </div>
                <div class="crate-foot crate-custom">
                    <div class="row">
                        <div class="col crate-blue"><i class="icon-feather-circle"></i> Completed</div>
                        <div class="col crate-orange"><i class="icon-feather-circle"></i> Cancelled</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="crate">
                <div class="crate-inner crate-padding add-radius add-shadow add-white crate- margin-bottom-20">
                    <div class="row">
                        <div class="col-md-8 col-sm-8 center-vertical white-text">
                            <i class="icon-feather-shopping-bag crate-icon-centered margin-right-10"></i>
                            <div class="crate-header crate-border-right- padding-right-20">Awaiting Payment</div>
                        </div>
                        <div class="col-md-4 col-sm-4 no-padding">
                            <div class="crate-header- white-text center">5</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="crate">
                <div class="crate-inner crate-padding add-white add-radius add-shadow margin-bottom-20">
                    <div class="row">
                        <div class="col-8 center-vertical blue-icon">
                            <i class="icon-feather-shopping-bag crate-icon-centered margin-right-10"></i>
                            <div class="crate-header">Disputes</div>
                        </div>
                        <div class="col-4">
                            <div class="crate-header- center">5</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="crate">
                <div class="crate-inner crate-padding add-white add-radius add-shadow margin-bottom-20">
                    <div class="row">
                        <div class="col-8 center-vertical blue-icon">
                            <i class="icon-feather-shopping-bag crate-icon-centered margin-right-10"></i>
                            <div class="crate-header">Cancellations</div>
                        </div>
                        <div class="col-4">
                            <div class="crate-header- center">1</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="crate">
                <div class="crate-inner crate-padding add-white add-radius add-shadow margin-bottom-20">
                    <div class="row">
                        <div class="col-8 center-vertical blue-icon">
                            <i class="icon-feather-shopping-bag crate-icon-centered margin-right-10"></i>
                            <div class="crate-header">Reviews</div>
                        </div>
                        <div class="col-4">
                            <div class="crate-header- center">162</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row -->
    <div class="row">

        <!-- Dashboard Box -->
        <div class="col-xl-12">
            <div class="dashboard-box">
                <div class="headline">
                    <h3><i class="icon-material-baseline-notifications-none"></i> Notifications</h3>
                    <button class="mark-as-read ripple-effect-dark" data-tippy-placement="left" title="Mark all as read">
                        <i class="icon-feather-check-square"></i>
                    </button>
                </div>
                <div class="content" data-simplebar>
                    <ul class="dashboard-box-list">
                    @forelse($unreadNotifications as $notification)
                        <!-- Notification -->

                            <li>
                                <span class="notification-icon"><i class="icon-material-outline-group"></i></span>
                                <span class="notification-text">
                                    @switch($notification->type)
                                        @case('App\Notifications\NewBidCreated')
                                        <a href="javascript:;">{{ $notification->notification_data->user_name }}</a> placed a bid on <a href="javascript:;">{{ $notification->notification_data->project_name }}</a> project
                                        @break
                                        @case('App\Notifications\ListingExpire')
                                            Job listing <a href="javascript:;">{{ $notification->notification_data->listing_name }}</a> is expiring.
                                        @break
                                        @case('App\Notifications\NewJobInvitation')
                                        <a href="javascript:;">{{ $notification->notification_data->user_name }}</a> sent an invitation for <a href="javascript:;"> {{ $notification->notification_data->listing_name }} </a> project.
                                        @break
                                    @endswitch
                                </span>
                                <div class="buttons-to-right">
                                    <a href="#" class="button ripple-effect ico" title="Mark as read" data-tippy-placement="left"><i class="icon-feather-check-square"></i></a>
                                </div>
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

{{--                            <span class="notification-icon"><i class=" icon-material-outline-gavel"></i></span>--}}
{{--                            <span class="notification-text">--}}
{{--										<strong>Gilber Allanis</strong> created a job in <strong>Cleveland, Ohio</strong> for <a href="#">iOS App Development (#23usm)</a> project--}}
{{--									</span>--}}
{{--                            <!-- Buttons -->--}}
{{--                            <div class="buttons-to-right">--}}
{{--                                <a href="#" class="button ripple-effect ico" title="Mark as read" data-tippy-placement="left"><i class="icon-feather-check-square"></i></a>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <span class="notification-icon"><i class="icon-material-outline-autorenew"></i></span>--}}
{{--                            <span class="notification-text">--}}
{{--										Job listing <a href="#">Full Stack Software Engineer (#23usm)</a> was reported by <strong>--}}
{{--										Cindy Craws</strong> for <i>"Illegal/Misleading Post"</i>--}}
{{--									</span>--}}
{{--                            <!-- Buttons -->--}}
{{--                            <div class="buttons-to-right">--}}
{{--                                <a href="#" class="button ripple-effect ico" title="Mark as read" data-tippy-placement="left"><i class="icon-feather-check-square"></i></a>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <span class="notification-icon"><i class="icon-material-outline-autorenew"></i></span>--}}
{{--                            <span class="notification-text">--}}
{{--										Message sent by <strong>Andy Crane</strong> <a href="#">(#m58)</a> was reported by <strong>--}}
{{--										Cindy Craws</strong> for <i>"Inappropriate language"</i>--}}
{{--									</span>--}}
{{--                            <!-- Buttons -->--}}
{{--                            <div class="buttons-to-right">--}}
{{--                                <a href="#" class="button ripple-effect ico" title="Mark as read" data-tippy-placement="left"><i class="icon-feather-check-square"></i></a>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <span class="notification-icon"><i class="icon-material-outline-group"></i></span>--}}
{{--                            <span class="notification-text">--}}
{{--										<strong>Eric Turner</strong> requested that feedback left for <a href="#">Full Stack Software Engineer (#35cht)</a>--}}
{{--										be removed <i>"Freelancer is very rude and I hate him"</i>--}}
{{--									</span>--}}
{{--                            <!-- Buttons -->--}}
{{--                            <div class="buttons-to-right">--}}
{{--                                <a href="#" class="button ripple-effect ico" title="Mark as read" data-tippy-placement="left"><i class="icon-feather-check-square"></i></a>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <span class="notification-icon"><i class="icon-material-outline-rate-review"></i></span>--}}
{{--                            <span class="notification-text">--}}
{{--										<strong>David Peterson</strong> has requested <strong><i><a href="">Digital ID</a></i></strong> badge--}}
{{--									</span>--}}
{{--                            <!-- Buttons -->--}}
{{--                            <div class="buttons-to-right">--}}
{{--                                <a href="#" class="button ripple-effect ico" title="Mark as read" data-tippy-placement="left"><i class="icon-feather-check-square"></i></a>--}}
{{--                            </div>--}}
{{--                        </li>--}}
                    </ul>
                </div>
            </div>
        </div>

    </div>
    <!-- Row / End -->
@endsection

@section('models')

@endsection

@section('footerjs')
    <script>
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

        $('.profilepicker').datepicker({
            language: 'en',
            inline: true,
        })

        var eventDates = [1, 10, 12, 22],
            $picker = $('#custom-cells'),
            $content = $('#custom-cells-events'),
            sentences = [
                'Unloading furniture from Container',
                'Clean my 5 bedroom / 3 bathroom apartment',
                'Carpenter - Skirting and moulding install',
                'Pickup Groceries Every Two Weeks'
            ]
        $picker.datepicker({
            language: 'en',
            onRenderCell: function (date, cellType) {
                var currentDate = date.getDate();
                if (cellType == 'day' && eventDates.indexOf(currentDate) != -1) {
                    return {
                        html: currentDate + '<span class="dp-note"></span>'
                    }
                }
            },
            onSelect: function onSelect(fd, date) {
                var title = '', content = ''
                if (date && eventDates.indexOf(date.getDate()) != -1) {
                    title = fd;
                    content = sentences[Math.floor(Math.random() * eventDates.length)];
                }
                $('strong', $content).html(title)
                $('p', $content).html(content)
            }
        })
        var currentDate = new Date();
        $picker.data('datepicker').selectDate(new Date(currentDate.getFullYear(), currentDate.getMonth(), 10))
    </script>
    <script>
        Chart.defaults.global.defaultFontFamily = "Nunito";
        Chart.defaults.global.defaultFontColor = '#888';
        Chart.defaults.global.defaultFontSize = '14';

        var ctx = document.getElementById('chart').getContext('2d');

        var chart = new Chart(ctx, {
            type: 'line',

            // The data for our dataset
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                // Information about the dataset
                datasets: [{
                    label: "Revenue",
                    backgroundColor: 'rgba(42,65,232,0.08)',
                    borderColor: '#2a41e8',
                    borderWidth: "3",
                    data: [196,132,215,362,210,252,500,120,225,275,200,400],
                    pointRadius: 5,
                    pointHoverRadius:5,
                    pointHitRadius: 10,
                    pointBackgroundColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointBorderWidth: "2",
                }]
            },

            // Configuration options
            options: {

                layout: {
                    padding: 10,
                },

                legend: { display: false },
                title:  { display: false },

                scales: {
                    yAxes: [{
                        scaleLabel: {
                            display: false
                        },
                        gridLines: {
                            borderDash: [6, 10],
                            color: "#d8d8d8",
                            lineWidth: 1,
                        },
                    }],
                    xAxes: [{
                        scaleLabel: { display: false },
                        gridLines:  { display: false },
                    }],
                },

                tooltips: {
                    backgroundColor: '#333',
                    titleFontSize: 13,
                    titleFontColor: '#fff',
                    bodyFontColor: '#fff',
                    bodyFontSize: 13,
                    displayColors: false,
                    xPadding: 10,
                    yPadding: 10,
                    intersect: false
                }
            },


        });

        new Chart(document.getElementsByClassName("liveupdate"), {
            type: 'doughnut',
            // The data for our dataset
            data: {
                labels: ["Completed", "Cancelled"],
                // Information about the dataset
                datasets: [{
                    label: "Views",
                    backgroundColor: ["#2a41e8", "#FF9A19"],
                    data: [20,4],
                    pointRadius: 5,
                    pointHoverRadius:5,
                    pointHitRadius: 10,
                    pointBackgroundColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointBorderWidth: "2",
                }]
            },

            // Configuration options
            options: {
                elements: {
                    center: {
                        text: '555,298',
                        color: '#666', //Default black
                        fontStyle: 'Helvetica', //Default Arial
                        sidePadding: 15 //Default 20 (as a percentage)
                    }
                },
                layout: {
                    padding: 10,
                },

                legend: { display: false },
                title:  { display: false },

                scales: { display: false },

                tooltips: {
                    backgroundColor: '#333',
                    titleFontSize: 13,
                    titleFontColor: '#fff',
                    bodyFontColor: '#fff',
                    bodyFontSize: 13,
                    displayColors: false,
                    xPadding: 10,
                    yPadding: 10,
                    intersect: false
                }
            },
        });

        new Chart(document.getElementsByClassName("liveupdate1"), {
            type: 'doughnut',
            // The data for our dataset
            data: {
                labels: ["Completed", "Cancelled"],
                // Information about the dataset
                datasets: [{
                    label: "Views",
                    backgroundColor: ["#2a41e8", "#FF9A19"],
                    data: [8,5],
                    pointRadius: 5,
                    pointHoverRadius:5,
                    pointHitRadius: 10,
                    pointBackgroundColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointBorderWidth: "2",
                }]
            },

            // Configuration options
            options: {

                elements: {
                    center: {
                        text: '13',
                        color: '#666', //Default black
                        fontStyle: 'Helvetica', //Default Arial
                        sidePadding: 15 //Default 20 (as a percentage)
                    }
                },
                layout: {
                    padding: 10,
                },

                legend: { display: false },
                title:  { display: false },

                scales: { display: false },

                tooltips: {
                    backgroundColor: '#333',
                    titleFontSize: 13,
                    titleFontColor: '#fff',
                    bodyFontColor: '#fff',
                    bodyFontSize: 13,
                    displayColors: false,
                    xPadding: 10,
                    yPadding: 10,
                    intersect: false
                }
            },
        });

        Chart.pluginService.register({
            beforeDraw: function (chart) {
                if (chart.config.options.elements.center) {
                    //Get ctx from string
                    var ctx = chart.chart.ctx;

                    //Get options from the center object in options
                    var centerConfig = chart.config.options.elements.center;
                    var fontStyle = centerConfig.fontStyle || 'Arial';
                    var txt = centerConfig.text;
                    var color = centerConfig.color || '#000';
                    var sidePadding = centerConfig.sidePadding || 20;
                    var sidePaddingCalculated = (sidePadding/100) * (chart.innerRadius * 2)
                    //Start with a base font of 30px
                    ctx.font = "30px " + fontStyle;

                    //Get the width of the string and also the width of the element minus 10 to give it 5px side padding
                    var stringWidth = ctx.measureText(txt).width;
                    var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

                    // Find out how much the font can grow in width.
                    var widthRatio = elementWidth / stringWidth;
                    var newFontSize = Math.floor(20 * widthRatio);
                    var elementHeight = (chart.innerRadius * 2);

                    // Pick a new font size so it will not be larger than the height of label.
                    var fontSizeToUse = Math.min(newFontSize, elementHeight);

                    //Set font settings to draw it correctly.
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
                    var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
                    ctx.font = fontSizeToUse+"px " + fontStyle;
                    ctx.fillStyle = color;

                    //Draw text in center
                    ctx.fillText(txt, centerX, centerY);
                }
            }
        });
    </script>
@endsection
