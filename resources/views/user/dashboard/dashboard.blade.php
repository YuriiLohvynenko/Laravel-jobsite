@extends('user.layouts.app')

@section('style')
@endsection

@section('content')
    <div class="margin-bottom-10">
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 margin-bottom-20">
                <h3>Hi, <span class="themeunderline">{{ $user->first_name }}</span></h3>
            </div>
            <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                <div class="row center-field">
                    <div class="col-md-6 col-sm-6 no-padding">
                        <div>Rating</div>
                        <div class="star-rating" data-rating="{{ $user->userRating() }}"></div>
                    </div>
                    <div class="col-md-3 col-sm-3 no-padding">
                        <div class="headline-sub">Earned <i class="icon-feather-info" data-tippy-placement="top" title="Total earned as a freelancer"></i></div>
                        <div class="headline-sub-">${{ $totalearned }}</div>
                    </div>
                    <div class="col-md-3 col-sm-3 no-padding">
                        <div class="headline-sub">Paid <i class="icon-feather-info" data-tippy-placement="top" title="Total paid to freelancers"></i></div>
                        <div class="headline-sub-">${{ $totalpaid }}</div>
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

    <div class="margin-bottom-20">
        <div class="crate">
            <div class="crate-inner crate-padding add-white add-radius add-shadow">
                <div class="row">
                    <div class="col-xl-2 col-lg-3 col-md-12 col-sm-12 d-flex justify-content-center align-items-center margin-bottom-20">
                        <div class="ctitle">Let's see what you have going on</div>
                    </div>
                    <div class="col-xl-4 col-lg-3 col-md-12 col-sm-12 d-flex justify-content-center align-items-center margin-bottom-30">
                        <div>
                            <div id="custom-cells"></div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                        <div id="custom-cells-events" class="row">
                            <div class="col-12">
                                <p class="crate-calendar-title"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	<div class="row margin-bottom-40">
		<div class="col-md-6 col-sm-12">
			<div id="single-job-map-container">
				<div id="singleListingMap" data-latitude="51.507717" data-longitude="-0.131095" data-map-icon="im im-icon-Hamburger"></div>
				<a href="#" id="streetView">Street View</a>
			</div>
		</div>
		<div class="col-md-6 col-sm-12">
			<div class="crate add-radius add-shadow add-white">
                <div class="crate-head crate-custom">
                    <div class="row">
                        <div class="col-8">
							<div>Tell your friends</div>
							<div>Refer and earn money in the process</div>
						</div>
                        <div class="col-4"><a href="" class="button gray ripple-effect button-sliding-icon btn-addon">Invite <i class="icon-feather-arrow-right"></i></a></div>
                    </div>
                </div>
                <div class="crate-inner">
					<div class="col-12">
						<div class="copy-url">
							<input id="copy-url" type="text" value="" class="with-border">
							<button class="copy-url-button ripple-effect" data-clipboard-target="#copy-url" title="Copy to Clipboard" data-tippy-placement="top"><i class="icon-material-outline-file-copy"></i></button>
						</div>
					</div>
                </div>
                <div class="crate-foot crate-custom">
                    <div class="row">
                        <div class="col-4">Referrals</div>
                        <div class="col-4"><i class="icon-feather-circle"></i> 382</div>
                        <div class="col-4"><i class="icon-feather-circle"></i> $628.50</div>
                    </div>
                </div>
            </div>
		</div>
	</div>

    <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 margin-bottom-20">
            <div class="crate">
                <div class="crate-inner crate-padding add-white add-radius add-shadow">
                    <div class="row">
                        <div class="col-3 center-vertical blue-icon">
                            <i class="icon-feather-tag crate-icon-centered"></i>
                        </div>
                        <div class="col-9">
                            <div class="crate-header ellipsis">Paid This Week</div>
                            <div class="crate-header-">${{ $weeklypaid }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 margin-bottom-20">
            <div class="crate">
                <div class="crate-inner crate-padding add-white add-radius add-shadow">
                    <div class="row">
                        <div class="col-3 center-vertical blue-icon">
                            <i class="icon-feather-truck crate-icon-centered"></i>
                        </div>
                        <div class="col-9">
                            <div class="crate-header ellipsis">Earned This Week</div>
                            <div class="crate-header-">${{ $weeklyearned }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 margin-bottom-20">
            <div class="crate">
                <div class="crate-inner crate-padding add-white add-radius add-shadow">
                    <div class="row">
                        <div class="col-3 center-vertical blue-icon">
                            <i class="icon-feather-navigation crate-icon-centered"></i>
                        </div>
                        <div class="col-9">
                            <div class="crate-header ellipsis">Weekly Cashback</div>
                            <div class="crate-header-">${{ $weeklypaid/100 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 margin-bottom-50">
            <div class="crate">
                <div class="crate-inner crate-padding add-white add-radius add-shadow">
                    <div class="row">
                        <div class="col-3 center-vertical blue-icon">
                            <i class="icon-feather-shopping-bag crate-icon-centered"></i>
                        </div>
                        <div class="col-9">
                            <div class="crate-header">Bookmarked</div>
                            <div class="crate-header-">{{ $bookmark }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 col-sm-12 margin-bottom-20">
            <div class="crate add-radius add-shadow add-white">
                <div class="crate-head crate-custom">
                    <div class="row">
                        <div class="col">Jobs Assigned</div>
                        <div class="col"><a href="{{ route('user.listing.index') }}" class="button gray ripple-effect button-sliding-icon btn-addon">View All <i class="icon-feather-arrow-right"></i></a></div>
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
                        <div class="col crate-blue"><i class="icon-feather-circle"></i> Assigned</div>
                        <div class="col crate-orange"><i class="icon-feather-circle"></i> Cancelled</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 margin-bottom-40">
            <div class="crate add-radius add-shadow add-white">
                <div class="crate-head crate-custom">
                    <div class="row">
                        <div class="col">Jobs Earned</div>
                        <div class="col"><a href="{{ route('user.listing.index') }}" class="button gray ripple-effect button-sliding-icon btn-addon">View All <i class="icon-feather-arrow-right"></i></a></div>
                    </div>
                </div>
                <div class="crate-inner">
                    <div class="row">
                        <div class="chart center">
                            <canvas class="liveupdate1" width="150" height="150"></canvas>
                        </div>
                    </div>
                </div>
                <div class="crate-foot crate-custom">
                    <div class="row">
                        <div class="col crate-blue"><i class="icon-feather-circle"></i> Earned</div>
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
                            <div class="crate-header- white-text center">
							<?php $Awaitingpayment = $user->Shift()->join('listing_budget_date','shifts.listing_id','=','listing_budget_date.listing_id')->where('listing_budget_date.status','pending')->orwhere('listing_budget_date.status','wait');
							?>
							{{ $Awaitingpayment->count() }}
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
                            <div class="crate-header- center">{{ $dispute }}</div>
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
                        <?php 
						$dispute = $user->disputes()->where('status', 'accepted')->get()->count();
						$offer = $user->offer()->where('status', 'rejected')->get()->count();
						?>
                        <div class="col-4">
                            <div class="crate-header- center">{{ $dispute + $offer }}</div>
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
                            <div class="crate-header- center">{{ $feedback }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('models')
    <!-- Apply for a job popup
================================================== -->
    <div id="small-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

        <!--Tabs -->
        <div class="sign-in-form">

            <ul class="popup-tabs-nav">
                <li><a href="#tab">Add Note</a></li>
            </ul>

            <div class="popup-tabs-container">

                <!-- Tab -->
                <div class="popup-tab-content" id="tab">

                    <!-- Welcome Text -->
                    <div class="welcome-text">
                        <h3>Do Not Forget 😎</h3>
                    </div>

                    <!-- Form -->
                    <form method="post" id="add-note">

                        <select class="selectpicker with-border default margin-bottom-20" data-size="7" title="Priority">
                            <option>Low Priority</option>
                            <option>Medium Priority</option>
                            <option>High Priority</option>
                        </select>

                        <textarea name="textarea" cols="10" placeholder="Note" class="with-border"></textarea>

                    </form>

                    <!-- Button -->
                    <button class="button full-width button-sliding-icon ripple-effect" type="submit" form="add-note">Add Note <i class="icon-material-outline-arrow-right-alt"></i></button>

                </div>

            </div>
        </div>
    </div>
    <!-- Apply for a job popup / End -->
@endsection

@section('footerjs')
    <!-- Snackbar // documentation: https://www.polonel.com/snackbar/ -->
<style>

.my-class a {
  background: #FC0 !important;
}
</style>
<script src="http://goldenflowershops.rf.gd/public/js/datepicker.min.js"></script>
<script src="http://goldenflowershops.rf.gd/public/js/datepicker.en.js"></script>
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

        $(function () {
            let dateArr = finalDateArr = jobposteddates = [];
			let jobearneddates = [];
			let eventDates = [];
			let myDateArr = [];
            let postedListings = {!! $postedListings !!}
            let myListings = {!! $myListings !!}
			// console.log(myListings);
			var d = new Date();
			const unique = (value, index, self) => {
			  return self.indexOf(value) === index
			}
			dateArr = postedListings.map(listing => {
				// console.log(moment(listing.created_at).format('M/D/YYYY'));
                // return (new Date(listing.created_at)).toLocaleDateString();
                return moment(listing.date_time).format('M/D/YYYY');
            });
            myListings.map(listing => {
                listing.offer.map(off=>{
					myDateArr.push(moment(off.created_at).format('M/D/YYYY'));
				});
            });
			myDateArr = myDateArr.filter(unique);
			// console.log(dateArr);
			// console.log(myDateArr);
            finalDateArr = dateArr.concat(myDateArr.filter((date, pos) => dateArr.indexOf(date) !== pos))
			// console.log(finalDateArr);
			eventDates = finalDateArr;
			eventDates = eventDates.filter(unique);
			postedListings.map(listing => {
				listing.budget_details.map(dates => {
					if(dates.shift != null)
						// jobposteddates.push((new Date(dates.shift.start_date)).toLocaleDateString());
						jobposteddates.push(moment(dates.shift.start_date).format('M/D/YYYY'));
				});
			});
			myListings.map(listing => {
				listing.budget_details.map(dates => {
					// jobearneddates.push((new Date(dates.date_time)).toLocaleDateString());
					jobearneddates.push(moment(dates.date_time).format('M/D/YYYY'));
				});
			});
			jobposteddates = jobposteddates.filter(unique);
			jobearneddates = jobearneddates.filter(unique);
			
			var $picker = $('#custom-cells'),
			$content = $('#custom-cells-events')
			getListings(d.getMonth(), d.getFullYear());

            function getListings(month, year) {
                $.easyAjax({
                    url: '{{ route('listings.byMonth') }}',
                    type: 'GET',
                    data: {month, year},
                    success: function (response) {
                        postedListings = response.postedListings;
                        myListings = response.myListings;
						const unique = (value, index, self) => {
						  return self.indexOf(value) === index
						}

                        dateArr = response.postedListings.map(listing => {
                            // return (new Date(listing.date_time)).toLocaleDateString();
                            return moment(listing.date_time).format('M/D/YYYY');
                        });

                        response.myListings.map(listing => {
							listing.offer.map(off=>{
								// myDateArr.push((new Date(off.created_at)).toLocaleDateString());
								myDateArr.push(moment(off.created_at).format('M/D/YYYY'));
							});
						});
						myDateArr = myDateArr.filter(unique);

                        finalDateArr = dateArr.concat(myDateArr.filter((date, pos) => dateArr.indexOf(date) !== pos))
                        eventDates = finalDateArr;
						
						response.postedListings.map(listing => {
                            listing.budget_details.map(dates => {
								if(dates.shift != null)
									// jobposteddates.push((new Date(dates.shift.start_date)).toLocaleDateString());
									jobposteddates.push(moment(dates.shift.start_date).format('M/D/YYYY'));
							});
                        });
						response.myListings.map(listing => {
                            listing.budget_details.map(dates => {
								// jobearneddates.push((new Date(dates.date_time)).toLocaleDateString());
								jobearneddates.push(moment(dates.date_time).format('M/D/YYYY'));
							});
                        });
						jobposteddates = jobposteddates.filter(unique);
						jobearneddates = jobearneddates.filter(unique);

                        $picker.data('datepicker').update();
                    }
                })
            }

            
				
            $picker.datepicker({
                language: 'en',
                showOtherMonths: true,
                toggleSelected: false,
                onChangeMonth: function (month, year) {
                    getListings(month, year);
                },
                onChangeView: function (view) {
                    if (view == 'days') {
                        var currentDate = new Date($picker.data('datepicker').currentDate)
                        var month = currentDate.getMonth();
                        var year = currentDate.getFullYear();
                        getListings(month, year);
                    }
                },
                onRenderCell: function (date, cellType) {
					var html = date.getDate();
                    // var currentDate = "1/30/2020";
                    var currentDate = moment(date).format('M/D/YYYY');
                    if (cellType == 'day' && eventDates.indexOf(currentDate) != -1) {
                        html += '<span class="dp-note"></span>';
                    }
                    if (cellType == 'day' && jobposteddates.indexOf(currentDate) != -1) {
                        html += '<span class="dp-note-posted"></span>';
                    }
                    if (cellType == 'day' && jobearneddates.indexOf(currentDate) != -1) {
                        html += '<span class="dp-note-earned"></span>';
                    }
					
					return {
						html: html
					}
                },
                onSelect: function (fd, date) {
                    var title = '', html = '', listinghtml = ''
					if(date && jobposteddates.indexOf(moment(date).format('M/D/YYYY')) != -1){
						var filtered = postedListings.filter(listing => {
                            return listing.budget_details.filter(dates => {
								if(dates.shift != null)
									// return (new Date(dates.date_time)).getDate() == date.getDate();
									return moment(dates.date_time).format('M/D/YYYY') == moment(date).format('M/D/YYYY');
							});
                        });
						if (filtered.length > 0) {
							listinghtml += '<p class="margin-bottom-0"><strong>You have Freelancers working for</strong></p>';
							filtered.forEach(listing => {
								listing.budget_details.forEach(milestone=>{
									// if(milestone.shift!=null && (new Date(milestone.shift.start_date)).toLocaleDateString() == date.toLocaleDateString()){
									if(milestone.shift!=null && moment(milestone.shift.start_date).format('M/D/YYYY') == moment(date).format('M/D/YYYY')){
										let profileUrl = '';
										if (listing.offer.length > 0) {
											profileUrl = '{{ route('user.profile.show', ':id') }}';
											profileUrl = profileUrl.replace(':id', listing.offer[0].user.id);
										}
										listinghtml += `
										<div class="margin-bottom-10">
											<strong>${listing.job_title}</strong>
										</div>
										<div class="row margin-bottom-30">
											<div class="col-12 margin-bottom-5">
												Freelancer:
												${listing.offer.length > 0 ?
													`<a href="${profileUrl !== '' ? profileUrl : 'javascript:;'}" target="_blank" class="pull-right">
														${listing.offer[0].user.full_name}
													</a>`
													:
													`<span class="pull-right">N/A</span>`
												}
											</div>
											<div class="col-12 margin-bottom-5">
												Type:
												<span class="pull-right">
													${listing.budget_details.length > 1 ? 'On-Going' : 'Temporary'}
												</span>
											</div>
										</div>
										<h5>Milestones</h5>
										<div class="row margin-bottom-30">
											<div class="col-12 margin-bottom-5">
												Estimated arrival time:
												<span class="pull-right">
													${(moment(milestone.date_time)).format('Do MMM, YYYY h:mma')}
												</span>
											</div>
											<div class="col-12 margin-bottom-5">
												Arrival time:
												<span class="pull-right">
													${milestone.shift !== null ? moment(milestone.shift.start_date).format('Do MMM, YYYY h:mma') : 'Not Arrived Yet'}
												</span>
											</div>
											<div class="col-12 margin-bottom-5">
												Departure time:
												<span class="pull-right">
													${milestone.shift !== null && milestone.shift.end_date !== null ? moment(milestone.shift.end_date).format('Do MMM, YYYY h:mma') : 'Not Departed Yet'}
												</span>
											</div>
											<div class="col-12 margin-bottom-5">
												Budget:
												<span class="pull-right">
													${listing.offer.length > 0 ? '$'+milestone.budget : 'N/A'}
												</span>
											</div>
										</div>`;
									}
								});
							});
						}
						title = fd
					}
					if(date && jobearneddates.indexOf(date.toLocaleDateString()) != -1){
						var filtered = myListings.filter(listing => {
                            return listing.budget_details.filter(dates => {
								return moment(dates.date_time).format('M/D/YYYY') == moment(date).format('M/D/YYYY');
							});
                        });
						if (filtered.length > 0) {
							listinghtml += '<p class="margin-bottom-0"><strong>You must work for</strong></p>';
                            filtered.forEach(listing => {
								listing.budget_details.forEach(milestone=>{
									//if((new Date(milestone.date_time)).toLocaleDateString() == date.toLocaleDateString()){
									if(moment(milestone.date_time).format('M/D/YYYY') == moment(date).format('M/D/YYYY')){
										let profileUrl = '';
										if (listing.offer.length > 0) {
											profileUrl = '{{ route('user.profile.show', ':id') }}';
											profileUrl = profileUrl.replace(':id', listing.offer[0].user.id);
										}
										listinghtml += `
										<div class="margin-bottom-10">
											<strong>${listing.job_title}</strong>
										</div>
										<div class="row margin-bottom-30">
											<div class="col-12 margin-bottom-5">
												Freelancer:
												${listing.offer.length > 0 ?
													`<a href="${profileUrl !== '' ? profileUrl : 'javascript:;'}" target="_blank" class="pull-right">
														${listing.offer[0].user.full_name}
													</a>`
													:
													`<span class="pull-right">N/A</span>`
												}
											</div>
											<div class="col-12 margin-bottom-5">
												Type:
												<span class="pull-right">
													${listing.budget_details.length > 1 ? 'On-Going' : 'Temporary'}
												</span>
											</div>
										</div>
										<h5>Milestones</h5>
										<div class="row margin-bottom-30">
											<div class="col-12 margin-bottom-5">
												Estimated arrival time:
												<span class="pull-right">
													${(moment(milestone.date_time)).format('Do MMM, YYYY h:mma')}
												</span>
											</div>
											<div class="col-12 margin-bottom-5">
												Arrival time:
												<span class="pull-right">
													${milestone.shift !== null ? moment(milestone.shift.start_date).format('Do MMM, YYYY h:mma') : 'Not Arrived Yet'}
												</span>
											</div>
											<div class="col-12 margin-bottom-5">
												Departure time:
												<span class="pull-right">
													${milestone.shift !== null && milestone.shift.end_date !== null ? moment(milestone.shift.end_date).format('Do MMM, YYYY h:mma') : 'Not Departed Yet'}
												</span>
											</div>
											<div class="col-12 margin-bottom-5">
												Budget:
												<span class="pull-right">
													${listing.offer.length > 0 ? '$'+milestone.budget : 'N/A'}
												</span>
											</div>
										</div>`;
									}
								});
                            });
                        }
						title = fd
					}
					
                    if (date && eventDates.indexOf(moment(date).format('M/D/YYYY')) != -1) {
						//console.log(eventDates);
                        var filtered = postedListings.filter(listing => {
                            //return (new Date(listing.date_time)).getDate() == date.getDate();
                            return moment(listing.date_time).format('M/D/YYYY') == moment(date).format('M/D/YYYY');
                        });

                        var myListingsFiltered = myListings.filter(listing => {
                           return moment(listing.offer[0].created_at).format('M/D/YYYY') == moment(date).format('M/D/YYYY');
                        });
                        if (filtered.length > 0) {
							html += '<p class="margin-bottom-0"><strong>Jobs Created By You</strong></p>';
                            filtered.forEach(listing => {
                                let profileUrl = '';

                                if (listing.offer.length > 0) {
                                    profileUrl = '{{ route('user.profile.show', ':id') }}';
                                    profileUrl = profileUrl.replace(':id', listing.offer[0].user.id);
                                }

                                html += `
								<div class="timeline-height" data-simplebar>
									<ul class="timeline">
										<li>
											<h3>Mon, Feb 26 - 3:30pm</h3>
											<a href="#">${listing.job_title}</a>
											<span class="color margin-right-5">
												${listing.offer.length > 0 ?
													`<mark class="color"><a href="${profileUrl !== '' ? profileUrl : 'javascript:;'}" target="_blank">
														${listing.offer[0].user.full_name}
													</a></mark>`
													:
													`<mark class="color">Not Assigned</mark>`
												}
											</span>
											<mark class="gray">${listing.budget_details.length > 1 ? 'On-Going' : 'Temporary'}</mark>
											<p>Today you will clean the restrooms. Stack and thoroughly clean every crevice.</p>
										</li>
									</ul>
								</div>
                                `
                                listing.budget_details.forEach(milestone => {
                                    html += `
									<div class="row margin-bottom-30">
                                        <div class="col-12 margin-bottom-5">
                                            Estimated arrival time:
                                            <span class="pull-right">
                                                ${(moment(milestone.date_time)).format('Do MMM, YYYY h:mma')}
                                            </span>
                                        </div>
                                        <div class="col-12 margin-bottom-5">
                                            Arrival time:
                                            <span class="pull-right">
                                                ${milestone.shift !== null ? moment(milestone.shift.start_date).format('Do MMM, YYYY h:mma') : 'Not Arrived Yet'}
                                            </span>
                                        </div>
                                        <div class="col-12 margin-bottom-5">
                                            Departure time:
                                            <span class="pull-right">
                                                ${milestone.shift !== null && milestone.shift.end_date !== null ? moment(milestone.shift.end_date).format('Do MMM, YYYY h:mma') : 'Not Departed Yet'}
                                            </span>
                                        </div>
                                        <div class="col-12 margin-bottom-5">
                                            Budget:
                                            <span class="pull-right">
                                                ${listing.offer.length > 0 ? '$'+milestone.budget : 'N/A'}
                                            </span>
                                        </div>
                                    </div>
                                    `;
                                });
                            });
                        }

                        if (myListingsFiltered.length > 0) {
							html += '<p class="margin-bottom-0"><strong>Jobs Accepted By You</strong></p>';
                            myListingsFiltered.forEach(listing => {
                                let profileUrl = '';

                                if (listing.offer.length > 0) {
                                    profileUrl = '{{ route('user.profile.show', ':id') }}';
                                    profileUrl = profileUrl.replace(':id', listing.offer[0].user.id);
                                }

                                html +=`
                                <div class="margin-bottom-10">
                                    <strong>${listing.job_title}</strong>
                                </div>
                                <div class="row margin-bottom-30">
                                    <div class="col-12 margin-bottom-5">
                                        Freelancer:
                                        ${ listing.offer.length > 0 ?
                                            `<a href="${profileUrl !== '' ? profileUrl : '#'}" target="_blank" class="pull-right">
                                                ${listing.offer[0].user.full_name}
                                            </a>`
                                            :
                                            `<span class="pull-right">Not yet assigned</span>`
                                        }
                                    </div>
                                    <div class="col-12 margin-bottom-5">
                                        Type:
                                        <span class="pull-right">
                                            ${listing.budget_details.length > 1 ? 'On-Going' : 'Temporary'}
                                        </span>
                                    </div>
                                </div>
                                <h5>Milestones</h5>
                                `

                                listing.budget_details.map(milestone => {
                                    html += `
                                        <div class="row margin-bottom-30">
                                            <div class="col-12 margin-bottom-5">
                                                Estimated arrival time:
                                                <span class="pull-right">
                                                    ${(moment(milestone.date_time)).format('Do MMM, YYYY h:mma')}
                                                </span>
                                            </div>
                                            <div class="col-12 margin-bottom-5">
                                                Arrival time:
                                                <span class="pull-right">
                                                    ${milestone.shift !== null ? moment(milestone.shift.start_date).format('Do MMM, YYYY h:mma') : 'Not Arrived Yet'}
                                                </span>
                                            </div>
                                            <div class="col-12 margin-bottom-5">
                                                Departure time:
                                                <span class="pull-right">
                                                    ${milestone.shift !== null && milestone.shift.end_date !== null  ? moment(milestone.shift.end_date).format('Do MMM, YYYY h:mma') : 'Not Departed Yet'}
                                                </span>
                                            </div>
                                            <div class="col-12 margin-bottom-5">
                                                Budget:
                                                <span class="pull-right">
                                                    ${listing.offer.length > 0 ? '$'+milestone.budget : 'N/A'}
                                                </span>
                                            </div>
                                        </div>
                                        `
                                })
                            })
                        }
                        title = fd
                    }
                    else {
						if(listinghtml == ''){
                        html += `
                            <p><strong>Create your own schedule today</strong></p>
                        `;
						}
                    }
					html = listinghtml + html; 
                    $('strong', $content).html(title)
                    $('p', $content).html(html)
                }
            })
            var currentDate = new Date();
            $picker.data('datepicker').selectDate(new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()))
        })

    </script>

    <script>
        Chart.defaults.global.defaultFontFamily = "Nunito";
        Chart.defaults.global.defaultFontColor = '#888';
        Chart.defaults.global.defaultFontSize = '14';

        new Chart(document.getElementsByClassName("liveupdate"), {
            type: 'doughnut',
            // The data for our dataset
            data: {
                labels: ["Assigned", "Cancelled"],
                // Information about the dataset
                datasets: [{
                    label: "Views",
                    backgroundColor: ["#2a41e8", "#FF9A19"],
                    data: [{{ $assigned }},{{ $assignedcancelled }}],
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
                        text: '{{ $assigned + $assignedcancelled }}',
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
                labels: ["Earned", "Cancelled"],
                // Information about the dataset
                datasets: [{
                    label: "Views",
                    backgroundColor: ["#2a41e8", "#FF9A19"],
                    data: [{{ $earned }}, {{ $earnedcancelled }}],
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
                        text: '{{ $earned + $earnedcancelled }}',
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
					// console.log(chart.config.options.elements.center);
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
