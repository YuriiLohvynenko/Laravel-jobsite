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
        <h3>Jobs</h3>

        <!-- Breadcrumbs -->
        <nav id="breadcrumbs" class="dark">
            <ul>
                <li><a href="{{ route('front.home') }}">Home</a></li>
                <li><a href="{{ route('user.dashboard.index') }}">Dashboard</a></li>
                <li>Jobs</li>
            </ul>
        </nav>
    </div>
	<div class="row margin-bottom-10">
				<div class="col-6"><mark class="gray">Hired <i class="icon-feather-info" data-tippy-placement="top" title="This is the client section"></i></mark></div>
				<div class="col-6"><a href="#freelancerprofile" class="pull-right">View freelancing jobs <i class="icon-feather-arrow-down"></i></a></div>
			</div>
    <!-- Form -->
    <div class="row margin-bottom-50">
        <!-- Dashboard Box -->
        <div class="col-xl-12">

        <!-- Tabs Container -->
        <div class="tabs">
            <div class="tabs-header tabs-white tabs-bottom-border tabs-single-border pure-menu pure-menu-horizontal pure-menu-scrollable">
                <ul class="tabs-jobs-group tabs-jobs-icons pure-menu-list scrollable">
                    <li class="active ripple-effect-dark pure-menu-item"><a href="#tab-1" data-tab-id="1"><i class="icon-feather-map-pin"></i> Posted</a></li>
                    <li class="ripple-effect-dark pure-menu-item"><a href="#tab-2" data-tab-id="2"><i class="icon-feather-map-pin"></i> Assigned</a></li>
                    <li class="ripple-effect-dark pure-menu-item"><a href="#tab-3" data-tab-id="3"><i class="icon-feather-pocket"></i> Complete</a></li>
					<li class="ripple-effect-dark pure-menu-item"><a href="#tab-5" data-tab-id="5"><i class="icon-feather-refresh-cw"></i> Ended</a></li>
                    <li class="ripple-effect-dark pure-menu-item"><a href="#tab-4" data-tab-id="4"><i class="icon-feather-tag"></i> Disputes</a></li>
                </ul>
                <div class="tab-hover"></div>
                <nav class="tabs-nav">
                    <div class="job-listing-icon-group">
                        <span class="crate-badge job-listing-badge" title="Flate rate commission for every job completed successfully" data-tippy-placement="left">Fee: 6%</span>
                        <span class="crate-badge job-listing-badge" title="Get cashback for every job completed successfully" data-tippy-placement="left">1% Cashback</span>
                    </div>
                </nav>
            </div>
            <!-- Tab Content -->
            <div class="tabs-content tabs-no-space">
                <div class="tab active" data-tab-id="1">

                    <!-- Client Jobs Active (client-active) -->

                    <div class="row tabs-jobs-border tabs-jobs-padding">
					<?php $count = 0; //print_r($listing); ?>
					
                        @forelse($activeListings as $listing)
						
						<?php if($listing->Isshow == 'Show'){ $count++; ?>
                        <div class="col-12" id="listingRow{{ $listing->id }}">
                            <div class="row">
                                <div class="col-6">
                                    <div class="job-listing-title">
                                        <a href="{{ route('listing.list.show', $listing->id) }}" class="ellipsis">{{ ucwords($listing->job_title) }}</a>
                                        <span class="dashboard-status-button green">@if($listing->budgetDetails->count() > 1) ${{ $listing->budgetDetails->first()->budget }}/shift @else ${{ $listing->budgetDetails->sum('budget') }} @endif</span>
                                        @if($listing->budgetDetails->count() > 1)
                                            <span class="dashboard-status-button green"> On-going </span>
                                        @endif
                                        @if($listing->job_location == 'online')
                                            <span class="dashboard-status-button green"> Remote </span>
                                        @endif										
                                        @if($listing->immediate_assistance == 'required')
                                            <span class="dashboard-status-button red"> Immediate Assistance </span>
                                        @endif
                                    </div>
									@if($listing->job_location != 'online')
                                    <div class="job-listing-group"><span class="icon-feather-map-pin"></span> {{ ucfirst($listing->city) }}, {{ ucfirst($listing->state) }}</div>
										@endif
                                    @php
                                        $date = null;
                                        $time = null;
										
											if($listing->budgetDetails->count() > 1) {
                                            $list = $listing->budgetDetails->filter(function ($value, $key) {
                                                return $value->date_time > Carbon\Carbon::now();
                                            });
											if($listing->immediate_assistance == 'required' ){
											 $date = $list->first()->date_time->format('l, F j, Y');
											$time = "As soon as possible";
										}else if($listing->immediate_assistance == 'required' && count($list) > 1){
											 $date = $list->first()->date_time->format('l, F j, Y');
											$time = "As soon as possible";
										}else if(count($list) > 1){
                                                $date = $list->first()->date_time->format('l, F j, Y');
                                                $time = $list->first()->date_time->format('h:i A');
                                            }
                                            else{
                                                 $date = $listing->budgetDetails->first()->date_time->format('l, F j, Y');
                                                 $time = $listing->budgetDetails->first()->date_time->format('h:i A');
                                            }


                                        } else {
                                            $date = $listing->budgetDetails->first()->date_time->format('l, F j, Y');
                                            $time = $listing->budgetDetails->first()->date_time->format('h:i A');
                                        }
                                    @endphp

                                    <div class="job-listing-group"><span class="icon-feather-calendar"></span> {{ $date }} <span>{{ $time }}</span></div>
                                </div>
                                <div class="col-6 pull-right">
                                    <div class="tabs-jobs-buttons">
                                        <a href="javascript:;" onclick="viewOffer({{ $listing->id }}, {{ count($listing->offer) }}); return false;" class="popup-with-zoom-anim button ripple-effect"><span class="button-info">{{ count($listing->offer) }}</span> View Offers <i class="icon-feather-layers"></i></a>
                                        <a href="{{ route('user.listing.edit', $listing->id) }}" class="button gray ripple-effect" title="Edit Listing" data-tippy-placement="top"><i class="icon-feather-edit-2"></i></a>
                                        <a href="javascript:;" onclick="deleteListing({{ $listing->id }})" class="popup-with-zoom-anim button gray ripple-effect" title="End Task" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
						<?php } ?>
                        @empty
							
                        @endforelse
							<?php if($count == 0){ ?>
                            <div class="col-12">
								<div class="row">
									<div class="col-6">
										<div class="job-listing-title"><a href="#">No jobs found</a></div>
										<div class="dashboard-status-button green">Get your project done today</div>
									</div>
									<div class="col-6 pull-right">
										<div class="tabs-jobs-buttons">
											<a href="#small-dialog-10" class="popup-with-zoom-anim button ripple-effect">Post a job <i class="icon-feather-upload-cloud"></i></a>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
                    </div>

                </div>
                <div class="tab" data-tab-id="2">
                    <!-- Client Jobs Assigned/Completed (client-completed) -->
                    <div class="row tabs-jobs-border tabs-jobs-padding">
					
                        @forelse($assignedListings as $listing)
                            <div class="col-12" id="listingRow{{ $listing->id }}">
							<?php //print_r($i);
									//die();							?>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="job-listing-title">
                                            <a href="{{ route('listing.list.show', $listing->id) }}" class="ellipsis">{{ ucwords($listing->job_title) }}</a>
                                            <span class="dashboard-status-button green">@if($listing->budgetDetails->count() > 1) ${{ $listing->budgetDetails->first()->budget }}/shift @else ${{ $listing->budgetDetails->sum('budget') }} @endif</span>
                                            @if($listing->budgetDetails->count() > 1)
                                                <span class="dashboard-status-button green"> On-going </span>
                                            @endif
                                            @if($listing->job_location == 'online')
                                                <span class="dashboard-status-button green"> Remote </span>
                                            @endif									
											@if($listing->immediate_assistance == 'required')
												<span class="dashboard-status-button red"> Immediate Assistance </span>
											@endif
                                        </div>

                                        <div class="job-listing-group"><span class="icon-feather-map-pin"></span> {{ ucfirst($listing->city) }}, {{ ucfirst($listing->state) }}</div>

                                        @php
                                            $date = null;
                                            $time = null;
                                            if($listing->budgetDetails->count() > 1) {
                                                $list = $listing->budgetDetails->filter(function ($value, $key) {
                                                    return $value->date_time > Carbon\Carbon::now();
                                                });

                                                if(count($list) > 1){
                                                    $date = $list->first()->date_time->format('l, F j, Y');
                                                    $time = $list->first()->date_time->format('h:i A');
                                                }
                                                else{
                                                     $date = $listing->budgetDetails->first()->date_time->format('l, F j, Y');
                                                     $time = $listing->budgetDetails->first()->date_time->format('h:i A');
                                                }

                                            } else {

                                                $date = $listing->budgetDetails->first()->date_time->format('l, F j, Y');
                                                $time = $listing->budgetDetails->first()->date_time->format('h:i A');
                                            }
                                        @endphp

                                        <div class="job-listing-group"><span class="icon-feather-calendar"></span> {{ $date }} <span>(Anytime)</span></div>
                                    </div>
                                    <div class="col-6 pull-right">
                                        <div class="tabs-jobs-buttons">
                                                @if($listing->checkCompleted())
                                                    <a href="javascript:;" onclick="showInvoice({{ $listing->id }});" class="popup-with-zoom-anim button dark ripple-effect"><span class="button-info">1</span> View Invoice <i class="icon-feather-clipboard"></i></a>
                                                    <span id="feedbackSection{{ $listing->id }}">
                                                        @if($listing->checkReviewByClient())
                                                            <a href="javascript:;" onclick="showReview({{ $listing->id }})" class="popup-with-zoom-anim button gray ripple-effect ico" title="Leave Feedback" data-tippy-placement="top"><i class="icon-feather-star"></i></a>
                                                        @else
                                                            <a href="javascript:;" onclick="leaveReview({{ $listing->id }})" class="popup-with-zoom-anim button ripple-effect ico" title="Leave Feedback" data-tippy-placement="top"><i class="icon-feather-star"></i></a>
                                                        @endif
                                                    </span>
                                                    <a href="javascript:;" onclick="sendMessage('{{ $listing->offer[0]->user_id }}', '{{ $listing->id }}', 'open')" class="popup-with-zoom-anim button gray ripple-effect ico" title="Contact Freelancer" data-tippy-placement="top"><i class="icon-feather-message-square"></i></a>
                                                    <a href="#small-dialog-6" class="popup-with-zoom-anim button gray ripple-effect ico" title="Post Similar" data-tippy-placement="top"><i class="icon-feather-copy"></i></a>
                                                @else
                                                    <a href="javascript:;"  onclick="assignedJobDetail({{ $listing->id }});" class="popup-with-zoom-anim button ripple-effect"><span class="button-info">1</span> Job Details <i class="icon-feather-clipboard"></i></a>
                                                    <a href="javascript:;" onclick="sendMessage('{{ $listing->offer_user_id }}', '{{ $listing->id }}', 'open')" class="popup-with-zoom-anim button gray ripple-effect" title="Contact Freelancer" data-tippy-placement="top"><i class="icon-feather-message-square"></i></a>
                                                    <a href="dashboard-track-jobs.html" class="button gray ripple-effect" title="View Live" data-tippy-placement="top"><i class="icon-feather-airplay"></i></a>
                                                <span id="disputeSection{{ $listing->id }}">
                                                    <a href="javascript:;"  onclick="@if(is_null($listing->dispute))openDispute({{ $listing->id }})@else showDispute({{ $listing->id }}) @endif" class="popup-with-zoom-anim button @if(is_null($listing->dispute)) gray @endif ripple-effect" title="Not Satisfied" data-tippy-placement="top"><i class="icon-feather-thumbs-down"></i></a>
                                                </span>
                                                @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
								<div class="row">
									<div class="col-6">
										<div class="job-listing-title"><a href="#">No jobs found</a></div>
										<div class="dashboard-status-button green">Get your project done today</div>
									</div>
									<div class="col-6 pull-right">
										<div class="tabs-jobs-buttons">
											<a href="#small-dialog-10" class="popup-with-zoom-anim button ripple-effect">Post a job <i class="icon-feather-upload-cloud"></i></a>
										</div>
									</div>
								</div>
							</div>
                        @endforelse
                    </div>
                </div>
             

                <div class="tab" data-tab-id="3">

                    <!-- Freelancer Jobs Completed (freelancer-completed) -->
                    <div class="row tabs-jobs-border tabs-jobs-padding">
					
                         @forelse($clientcompleted as $listing)
						 <?php //print_r($listing->offer); 
						 //die();
						 ?>
                            <div class="col-12" id="listingRow{{ $listing->id }}">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="job-listing-title">
                                            <a href="{{ route('listing.list.show', $listing->id) }}" class="ellipsis">{{ ucwords($listing->job_title) }}</a>
                                            <span class="dashboard-status-button green">@if($listing->budgetDetails->count() > 1) ${{ $listing->budgetDetails->first()->budget }}/shift @else ${{ $listing->budgetDetails->sum('budget') }} @endif</span>
                                            @if($listing->budgetDetails->count() > 1)
                                                <span class="dashboard-status-button green"> On-going </span>
                                            @endif
                                            @if($listing->job_location == 'online')
                                                <span class="dashboard-status-button green"> Remote </span>
                                            @endif									
											@if($listing->immediate_assistance == 'required')
												<span class="dashboard-status-button red"> Immediate Assistance </span>
											@endif
                                        </div>

                                        <div class="job-listing-group"><span class="icon-feather-map-pin"></span> {{ ucfirst($listing->city) }}, {{ ucfirst($listing->state) }}</div>

                                        @php
                                            $date = null;
                                            $time = null;
                                            if($listing->budgetDetails->count() > 1) {
                                                $list = $listing->budgetDetails->filter(function ($value, $key) {
                                                    return $value->date_time > Carbon\Carbon::now();
                                                });

                                                if(count($list) > 1){
                                                    $date = $list->first()->date_time->format('l, F j, Y');
                                                    $time = $list->first()->date_time->format('h:i A');
                                                }
                                                else{
                                                     $date = $listing->budgetDetails->first()->date_time->format('l, F j, Y');
                                                     $time = $listing->budgetDetails->first()->date_time->format('h:i A');
                                                }

                                            } else {

                                                $date = $listing->budgetDetails->first()->date_time->format('l, F j, Y');
                                                $time = $listing->budgetDetails->first()->date_time->format('h:i A');
                                            }
                                        @endphp

                                        <div class="job-listing-group"><span class="icon-feather-calendar"></span> {{ $date }} <span>(Anytime)</span></div>
                                    </div>
                                    <div class="col-6 pull-right">
                                        <div class="tabs-jobs-buttons">
                                                @if($listing->checkCompleted())
                                                    <a href="javascript:;" onclick="showInvoice({{ $listing->id }});" class="popup-with-zoom-anim button dark ripple-effect"><span class="button-info">1</span> View Invoice <i class="icon-feather-clipboard"></i></a>
                                                    <span id="feedbackSection{{ $listing->id }}">
                                                        @if($listing->checkReviewByClient())
                                                            <a href="javascript:;" onclick="showReview({{ $listing->id }})" class="popup-with-zoom-anim button gray ripple-effect ico" title="Leave Feedback" data-tippy-placement="top"><i class="icon-feather-star"></i></a>
                                                        @else
                                                            <a href="javascript:;" onclick="leaveReview({{ $listing->id }})" class="popup-with-zoom-anim button ripple-effect ico" title="Leave Feedback" data-tippy-placement="top"><i class="icon-feather-star"></i></a>
                                                        @endif
                                                    </span>
                                                    <a href="javascript:;" onclick="sendMessage('{{ $listing->offer[0]->user_id }}', '{{ $listing->id }}', 'open')" class="popup-with-zoom-anim button gray ripple-effect ico" title="Contact Freelancer" data-tippy-placement="top"><i class="icon-feather-message-square"></i></a>
                                                    <a href="#small-dialog-6" class="popup-with-zoom-anim button gray ripple-effect ico" title="Post Similar" data-tippy-placement="top"><i class="icon-feather-copy"></i></a>
                                                @else
                                                    <a href="javascript:;"  onclick="assignedJobDetail({{ $listing->id }});" class="popup-with-zoom-anim button ripple-effect"><span class="button-info">1</span> Job Details <i class="icon-feather-clipboard"></i></a>
                                                    <a href="javascript:;" onclick="sendMessage('{{ $listing->offer_user_id }}', '{{ $listing->id }}', 'open')" class="popup-with-zoom-anim button gray ripple-effect" title="Contact Freelancer" data-tippy-placement="top"><i class="icon-feather-message-square"></i></a>
                                                    <a href="dashboard-track-jobs.html" class="button gray ripple-effect" title="View Live" data-tippy-placement="top"><i class="icon-feather-airplay"></i></a>
                                                <span id="disputeSection{{ $listing->id }}">
                                                    <a href="javascript:;"  onclick="@if(is_null($listing->dispute))openDispute({{ $listing->id }})@else showDispute({{ $listing->id }}) @endif" class="popup-with-zoom-anim button @if(is_null($listing->dispute)) gray @endif ripple-effect" title="Not Satisfied" data-tippy-placement="top"><i class="icon-feather-thumbs-down"></i></a>
                                                </span>
                                                @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
								<div class="row">
									<div class="col-6">
										<div class="job-listing-title"><a href="#">No jobs found</a></div>
										<div class="dashboard-status-button green">Get your project done today</div>
									</div>
									<div class="col-6 pull-right">
										<div class="tabs-jobs-buttons">
											<a href="#small-dialog-10" class="popup-with-zoom-anim button ripple-effect">Post a job <i class="icon-feather-upload-cloud"></i></a>
										</div>
									</div>
								</div>
							</div>
                        @endforelse
                    </div>
                </div>
                <div class="tab" data-tab-id="4">

                    <!-- Unfilled Jobs (jobs-unfilled) -->
                    <div class="row tabs-jobs-border tabs-jobs-padding">
					
                        @forelse($clientdisputelist as $listing)
						<?php //print_r($listing->offer[0]->user_id); 
						// die();
						?>
                            <div class="col-12" id="listingRow{{ $listing->id }}">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="job-listing-title">
                                            <a href="{{ route('listing.list.show', $listing->id) }}" class="ellipsis">{{ ucwords($listing->job_title) }}</a>
                                            <span class="dashboard-status-button green">@if($listing->budgetDetails->count() > 1) ${{ $listing->budgetDetails->first()->budget }}/shift @else ${{ $listing->budgetDetails->sum('budget') }} @endif</span>
                                            @if($listing->budgetDetails->count() > 1)
                                                <span class="dashboard-status-button green"> On-going </span>
                                            @endif
                                            @if($listing->job_location == 'online')
                                                <span class="dashboard-status-button green"> Remote </span>
                                            @endif
                                        </div>

                                        <div class="job-listing-group"><span class="icon-feather-map-pin"></span> {{ ucfirst($listing->city) }}, {{ ucfirst($listing->state) }}</div>

                                        @php
                                            $date = null;
                                            $time = null;
                                            if($listing->budgetDetails->count() > 1) {
                                                $list = $listing->budgetDetails->filter(function ($value, $key) {
                                                    return $value->date_time < Carbon\Carbon::now();
                                                });
                                                $date = $list->first()->date_time->format('l, F j, Y');
                                                $time = $list->first()->date_time->format('h:i A');

                                            } else {

                                                $date = $listing->budgetDetails->first()->date_time->format('l, F j, Y');
                                                $time = $listing->budgetDetails->first()->date_time->format('h:i A');
                                            }
                                        @endphp

                                        <div class="job-listing-group"><span class="icon-feather-calendar"></span> {{ $date }} <span>(Anytime)</span></div>
                                    </div>
                                    <div class="col-6 pull-right">
                                        <div class="tabs-jobs-buttons">
										<a href="javascript:;" onclick="assignedJobDetail({{ $listing->id }})"  class="popup-with-zoom-anim button dark ripple-effect">Job Details <i class="icon-feather-clipboard"></i></a>
										<a href="javascript:;" onclick="sendMessage('{{ $listing->offer[0]->user_id }}', '{{ $listing->offer[0]->user_id }}', 'open')" class="popup-with-zoom-anim button gray ripple-effect" title="Contact freelancer" data-tippy-placement="top"><i class="icon-feather-message-square"></i></a>
                                            <!--<a href="{{ route('listing.copy', $listing->id) }}" class="popup-with-zoom-anim button ripple-effect"><i class="icon-material-outline-supervisor-account"></i> Repost Listing</a>-->
                                            <!--<a href="javascript:;" onclick="deleteListing({{ $listing->id }})" class="popup-with-zoom-anim button gray ripple-effect" title="Contact Client" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>-->
											<a href="javascript:;" onclick="@if(is_null($listing->dispute))openBidDispute({{ $listing->id }})@else showBidDispute({{ $listing->id }}) @endif" class="popup-with-zoom-anim button @if(is_null($listing->dispute)) gray @endif ripple-effect" title="Cancel Task" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        @empty
                            <div class="col-12">
								<div class="row">
									<div class="col-6">
										<div class="job-listing-title"><a href="#">No disputes found</a></div>
										<div class="dashboard-status-button green">Get your project done today</div>
									</div>
									<div class="col-6 pull-right">
										<div class="tabs-jobs-buttons">
											<a href="#small-dialog-10" class="popup-with-zoom-anim button ripple-effect">Post a job <i class="icon-feather-upload-cloud"></i></a>
										</div>
									</div>
								</div>
							</div>
                        @endforelse

                    </div>

                </div>
				<div class="tab" data-tab-id="5">

                    <!-- Unfilled Jobs (jobs-unfilled) -->
                    <div class="row tabs-jobs-border tabs-jobs-padding">
                        @forelse($clientendedListings as $listing)
                            <div class="col-12" id="listingRow{{ $listing->id }}">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="job-listing-title">
                                            <a href="{{ route('listing.list.show', $listing->id) }}" class="ellipsis">{{ ucwords($listing->job_title) }}</a>
                                            <span class="dashboard-status-button green">@if($listing->budgetDetails->count() > 1) ${{ $listing->budgetDetails->first()->budget }}/shift @else ${{ $listing->budgetDetails->sum('budget') }} @endif</span>
                                            @if($listing->budgetDetails->count() > 1)
                                                <span class="dashboard-status-button green"> On-going </span>
                                            @endif
                                            @if($listing->job_location == 'online')
                                                <span class="dashboard-status-button green"> Remote </span>
                                            @endif
                                        </div>

                                        <div class="job-listing-group"><span class="icon-feather-map-pin"></span> {{ ucfirst($listing->city) }}, {{ ucfirst($listing->state) }}</div>

                                        @php
                                            $date = null;
                                            $time = null;
                                            if($listing->budgetDetails->count() > 1) {
                                                $list = $listing->budgetDetails->filter(function ($value, $key) {
                                                    return $value->date_time < Carbon\Carbon::now();
                                                });
                                                $date = $list->first()->date_time->format('l, F j, Y');
                                                $time = $list->first()->date_time->format('h:i A');

                                            } else {

                                                $date = $listing->budgetDetails->first()->date_time->format('l, F j, Y');
                                                $time = $listing->budgetDetails->first()->date_time->format('h:i A');
                                            }
                                        @endphp

                                        <div class="job-listing-group"><span class="icon-feather-calendar"></span> {{ $date }} <span>(Anytime)</span></div>
                                    </div>
                                    <div class="col-6 pull-right">
                                        <div class="tabs-jobs-buttons">
                                            <a href="{{ route('listing.copy', $listing->id) }}" class="popup-with-zoom-anim button ripple-effect"><i class="icon-material-outline-supervisor-account"></i> Repost Listing</a>
                                            <a href="javascript:;" onclick="deleteListing({{ $listing->id }})" class="popup-with-zoom-anim button gray ripple-effect" title="Contact Client" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        @empty
                            <div class="col-12">
								<div class="row">
									<div class="col-6">
										<div class="job-listing-title"><a href="#">No jobs found</a></div>
										<div class="dashboard-status-button green">Get your project done today</div>
									</div>
									<div class="col-6 pull-right">
										<div class="tabs-jobs-buttons">
											<a href="#small-dialog-10" class="popup-with-zoom-anim button ripple-effect">Post a job <i class="icon-feather-upload-cloud"></i></a>
										</div>
									</div>
								</div>
							</div>
                        @endforelse

                    </div>

                </div>
            </div>
        </div>
        <!-- Tabs Container / End -->
		
    </div>
    </div>
		<div class="row margin-bottom-10" id="freelancersection">
			<div class="col-6"><mark class="gray">Worked <i class="icon-feather-info" data-tippy-placement="top" title="This is the freelancer section"></i></mark></div>
			<div class="col-6"><a href="#freelancerprofile" class="pull-right">View client jobs <i class="icon-feather-arrow-up"></i></a></div>
		</div>
	<!-- Form -->
    <div class="row margin-bottom-10">
        <!-- Dashboard Box -->
        <div class="col-xl-12">

        <!-- Tabs Container -->
        <div class="tabs">
            <div class="tabs-header tabs-white tabs-bottom-border tabs-single-border pure-menu pure-menu-horizontal pure-menu-scrollable">
                <ul class="tabs-jobs-group tabs-jobs-icons pure-menu-list">
                    <li class="active ripple-effect-dark pure-menu-item"><a href="#tab-1" data-tab-id="1"><i class="icon-feather-map-pin"></i> Offers</a></li>
                    <li class="ripple-effect-dark pure-menu-item"><a href="#tab-2" data-tab-id="2"><i class="icon-feather-map-pin"></i> Earned</a></li>
                    <li class="ripple-effect-dark pure-menu-item"><a href="#tab-3" data-tab-id="3"><i class="icon-feather-pocket"></i> Completed</a></li>
					<li class="ripple-effect-dark pure-menu-item"><a href="#tab-5" data-tab-id="5"><i class="icon-feather-refresh-cw"></i> Ended</a></li>
                    <li class="ripple-effect-dark pure-menu-item"><a href="#tab-4" data-tab-id="4"><i class="icon-feather-tag"></i> Disputes</a></li>
                </ul>
                <div class="tab-hover"></div>
                <nav class="tabs-nav">
                    <div class="job-listing-icon-group">
                        <span class="crate-badge job-listing-badge" title="Flate rate commission for every job completed successfully" data-tippy-placement="left">Fee: 6%</span>
                        <span class="crate-badge job-listing-badge" title="Get cashback for every job completed successfully" data-tippy-placement="left">1% Cashback</span>
                    </div>
                </nav>
            </div>
            <!-- Tab Content -->
            <div class="tabs-content tabs-no-space">
					<div class="tab active" data-tab-id="1">
                    <!-- Freelancer Jobs Active (freelancer-active) -->
                    <div class="row tabs-jobs-border tabs-jobs-padding">
					
                        @forelse($freelancerActive as $myBid)
						<?php //print_r($myBid);
							// die();
						?>
						<?php //if($myBid->selected_offer->status == 'pending'){ ?>
                            <div class="col-12"  id="listingRow{{ $myBid->id }}">
                            <div class="row">
                                <div class="col-6">
                                    <div class="job-listing-title">
                                        <a href="{{ route('listing.list.show', $myBid->id) }}" class="ellipsis">{{ ucwords($myBid->job_title) }}</a>
                                        <span class="dashboard-status-button green">@if($myBid->budgetDetails->count() > 1) ${{ $myBid->budgetDetails->first()->budget }}/shift @else ${{ $myBid->budgetDetails->sum('budget') }} @endif</span>
                                        @if($myBid->budgetDetails->count() > 1)
                                            <span class="dashboard-status-button green"> On-going </span>
                                        @endif
                                        @if($myBid->job_location == 'online')
                                            <span class="dashboard-status-button green"> Remote </span>
                                        @endif								
											@if($myBid->immediate_assistance == 'required')
												<span class="dashboard-status-button red"> Immediate Assistance </span>
											@endif
                                    </div>

                                    <div class="job-listing-group"><span class="icon-feather-map-pin"></span> {{ ucfirst($myBid->city) }}, {{ ucfirst($myBid->state) }}</div>
                                    @php
                                        $budgetData = null;

                                        $clockOut = $myBid->budgetDetails->filter(function ($value, $key) {
                                                return $value->shift != null &&  $value->shift->start_date != null &&  $value->shift->end_date == null;
                                            })->first();

                                        $date = null;
                                        $time = null;
                                        if($myBid->budgetDetails->count() > 1) {
                                            $list = $myBid->budgetDetails->filter(function ($value, $key) {
                                                return $value->date_time > Carbon\Carbon::now();
                                            });

                                            if(count($list) > 1){
                                                $date = $list->first()->date_time->format('l, F j, Y');
                                                $time = $list->first()->date_time->format('h:i A');
                                                $latestBudget = $list;
                                            }
                                            else{
                                                $date = $myBid->budgetDetails->first()->date_time->format('l, F j, Y');
                                                $time = $myBid->budgetDetails->first()->date_time->format('h:i A');
                                                $latestBudget = $myBid->budgetDetails->first();
                                            }


                                        } else {

                                            $date = $myBid->budgetDetails->first()->date_time->format('l, F j, Y');
                                            $time = $myBid->budgetDetails->first()->date_time->format('h:i A');
                                            $latestBudget = $myBid->budgetDetails->first();
                                        }
                                    @endphp
                                    <div class="job-listing-group"><span class="icon-feather-calendar"></span> {{ $date }} <span>(Anytime)</span></div>
                                </div>


                                <div class="col-6 pull-right">
                                    <div class="tabs-jobs-buttons">
                                        @if($myBid->selected_offer->status == 'pending')
                                            @forelse($myBid->offer as $counter)
                                                @if($counter->user_id != $user->id && $counter->status == 'pending')
                                                    <!-- <a href="javascript:;" onclick="counterOffer({{ $counter->id }})"  class="popup-with-zoom-anim button ripple-effect">Counter <i class="icon-feather-clipboard"></i></a> -->
                                                @endif
                                            @empty
                                            @endforelse
                                            <a href="javascript:;" onclick="updateOffer({{ $myBid->id }})" class="popup-with-zoom-anim button ripple-effect">Modify Offer <i class="icon-feather-watch"></i></a>
                                        @else
                                         <!--   <span id="shiftButton{{$myBid->id}}">
                                                @if($clockOut)
                                                    <a href="javascript:;" onclick="changeShift({{ $myBid->id }}, 'end')" class="popup-with-zoom-anim button dark ripple-effect">End Shift <i class="icon-feather-watch"></i></a>
                                                @else
                                                    <a href="javascript:;" onclick="changeShift({{ $myBid->id }}, 'start')"  class="popup-with-zoom-anim button blue ripple-effect">Start Shift <i class="icon-feather-watch"></i></a>
                                                @endif
                                            </span>-->
                                        @endif
                                        <a href="javascript:;" onclick="bidJobDetail({{ $myBid->id }})"  class="popup-with-zoom-anim button dark ripple-effect">Job Details <i class="icon-feather-clipboard"></i></a>
                                        <a href="javascript:;" onclick="sendMessage('{{ $myBid->user_id }}', '{{ $myBid->id }}', 'open')" class="popup-with-zoom-anim button gray ripple-effect" title="Contact Client" data-tippy-placement="top"><i class="icon-feather-message-square"></i></a>
                                        @if($myBid->selected_offer->status == 'accepted')
                                            <span id="disputeBidSection{{ $myBid->id }}">
                                                <a href="javascript:;" onclick="@if(is_null($myBid->dispute))openBidDispute({{ $myBid->id }})@else showBidDispute({{ $myBid->id }}) @endif" class="popup-with-zoom-anim button @if(is_null($myBid->dispute)) gray @endif ripple-effect" title="Cancel Task" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
					<?php //} ?>
                        @empty
                            <div class="col-12">
								<div class="row">
									<div class="col-6">
										<div class="job-listing-title"><a href="#">No jobs found</a></div>
										<div class="dashboard-status-button green">Get your project done today</div>
									</div>
									<div class="col-6 pull-right">
										<div class="tabs-jobs-buttons">
											<a href="#small-dialog-10" class="popup-with-zoom-anim button ripple-effect">Find jobs <i class="icon-feather-upload-cloud"></i></a>
										</div>
									</div>
								</div>
							</div>
                        @endforelse
                    </div>
					
                </div>
                <div class="tab" data-tab-id="2">
                    <!-- Client Jobs Assigned/Completed (client-completed) -->
                    <div class="row tabs-jobs-border tabs-jobs-padding">
                    
                        @forelse($freelancerAssigned as $myBid)
						<?php //print_r($myBid->selected_offer->status);
							// die();
						?>
						<?php //if($myBid->selected_offer->status == 'accepted'){ ?>
                            <div class="col-12"  id="listingRow{{ $myBid->id }}">
                            <div class="row">
                                <div class="col-6">
                                    <div class="job-listing-title">
                                        <a href="{{ route('listing.list.show', $myBid->id) }}" class="ellipsis">{{ ucwords($myBid->job_title) }}</a>
                                        <span class="dashboard-status-button green">@if($myBid->budgetDetails->count() > 1) ${{ $myBid->budgetDetails->first()->budget }}/shift @else ${{ $myBid->budgetDetails->sum('budget') }} @endif</span>
                                        @if($myBid->budgetDetails->count() > 1)
                                            <span class="dashboard-status-button green"> On-going </span>
                                        @endif
                                        @if($myBid->job_location == 'online')
                                            <span class="dashboard-status-button green"> Remote </span>
                                        @endif								
											@if($myBid->immediate_assistance == 'required')
												<span class="dashboard-status-button red"> Immediate Assistance </span>
											@endif
                                    </div>

                                    <div class="job-listing-group"><span class="icon-feather-map-pin"></span> {{ ucfirst($myBid->city) }}, {{ ucfirst($myBid->state) }}</div>
                                    @php
                                        $budgetData = null;

                                        $clockOut = $myBid->budgetDetails->filter(function ($value, $key) {
                                                return $value->shift != null &&  $value->shift->start_date != null &&  $value->shift->end_date == null;
                                            })->first();

                                        $date = null;
                                        $time = null;
                                        if($myBid->budgetDetails->count() > 1) {
                                            $list = $myBid->budgetDetails->filter(function ($value, $key) {
                                                return $value->date_time > Carbon\Carbon::now();
                                            });

                                            if(count($list) > 1){
                                                $date = $list->first()->date_time->format('l, F j, Y');
                                                $time = $list->first()->date_time->format('h:i A');
                                                $latestBudget = $list;
                                            }
                                            else{
                                                $date = $myBid->budgetDetails->first()->date_time->format('l, F j, Y');
                                                $time = $myBid->budgetDetails->first()->date_time->format('h:i A');
                                                $latestBudget = $myBid->budgetDetails->first();
                                            }


                                        } else {

                                            $date = $myBid->budgetDetails->first()->date_time->format('l, F j, Y');
                                            $time = $myBid->budgetDetails->first()->date_time->format('h:i A');
                                            $latestBudget = $myBid->budgetDetails->first();
                                        }
                                    @endphp
                                    <div class="job-listing-group"><span class="icon-feather-calendar"></span> {{ $date }} <span>(Anytime)</span></div>
                                </div>


                                <div class="col-6 pull-right">
                                    <div class="tabs-jobs-buttons">
                                        @if($myBid->selected_offer->status == 'pending')
                                            @forelse($myBid->offer as $counter)
                                                @if($counter->user_id != $user->id && $counter->status == 'pending')
                                                    <a href="javascript:;" onclick="counterOffer({{ $counter->id }})"  class="popup-with-zoom-anim button ripple-effect">Counter <i class="icon-feather-clipboard"></i></a>
                                                @endif
                                            @empty
                                            @endforelse
                                            <a href="javascript:;" onclick="updateOffer({{ $myBid->id }})" class="popup-with-zoom-anim button ripple-effect">Modify Offer <i class="icon-feather-watch"></i></a>
                                        @else
                                           <span id="shiftButton{{$myBid->id}}">
                                                @if($clockOut)
                                                    <a href="javascript:;" onclick="changeShift({{ $myBid->id }}, 'end')" class="popup-with-zoom-anim button dark ripple-effect">End Shift <i class="icon-feather-watch"></i></a>
                                                @else
                                                    <a href="javascript:;" onclick="changeShift({{ $myBid->id }}, 'start')"  class="popup-with-zoom-anim button blue ripple-effect">Start Shift <i class="icon-feather-watch"></i></a>
                                                @endif
                                            </span>
                                        @endif
                                        <a href="javascript:;" onclick="bidJobDetail({{ $myBid->id }})"  class="popup-with-zoom-anim button dark ripple-effect">Job Details <i class="icon-feather-clipboard"></i></a>
                                        <a href="javascript:;" onclick="sendMessage('{{ $myBid->user_id }}', '{{ $myBid->id }}', 'open')" class="popup-with-zoom-anim button gray ripple-effect" title="Contact Client" data-tippy-placement="top"><i class="icon-feather-message-square"></i></a>
                                        @if($myBid->selected_offer->status == 'accepted')
                                            <span id="disputeBidSection{{ $myBid->id }}">
                                                <a href="javascript:;" onclick="@if(is_null($myBid->dispute))openBidDispute({{ $myBid->id }})@else showBidDispute({{ $myBid->id }}) @endif" class="popup-with-zoom-anim button @if(is_null($myBid->dispute)) gray @endif ripple-effect" title="Cancel Task" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
					<?php //} ?>
                        @empty
                            <div class="col-12">
								<div class="row">
									<div class="col-6">
										<div class="job-listing-title"><a href="#">No jobs found</a></div>
										<div class="dashboard-status-button green">Get your project done today</div>
									</div>
									<div class="col-6 pull-right">
										<div class="tabs-jobs-buttons">
											<a href="#small-dialog-10" class="popup-with-zoom-anim button ripple-effect">Find jobs <i class="icon-feather-upload-cloud"></i></a>
										</div>
									</div>
								</div>
							</div>
                        @endforelse
                    </div>
					
                </div>
              

                <div class="tab" data-tab-id="3">

                    <!-- Freelancer Jobs Completed (freelancer-completed) -->
                    <div class="row tabs-jobs-border tabs-jobs-padding">
					
                        @forelse($completed as $complete)
                            <div class="col-12" id="listingRow{{ $complete->id }}">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="job-listing-title">
                                            <a href="{{ route('listing.list.show', $complete->id) }}" class="ellipsis">{{ ucwords($complete->job_title) }}</a>

                                            <span class="dashboard-status-button green">@if($complete->budgetDetails->count() > 1) ${{ $complete->budgetDetails->first()->budget }}/shift @else ${{ $complete->budgetDetails->sum('budget') }} @endif</span>
                                            @if($complete->budgetDetails->count() > 1)
                                                <span class="dashboard-status-button green"> On-going </span>
                                            @endif
                                            @if($complete->job_location == 'online')
                                                <span class="dashboard-status-button green"> Remote </span>
                                            @endif								
											@if($complete->immediate_assistance == 'required')
												<span class="dashboard-status-button search-badge-red"> Immediate Assistance </span>
											@endif
                                        </div>

                                        <div class="job-listing-group"><span class="icon-feather-map-pin"></span> {{ ucfirst($complete->city) }}, {{ ucfirst($complete->state) }}</div>
                                        @php
                                            $budgetData = null;

                                            $clockOut = $complete->budgetDetails->filter(function ($value, $key) {
                                                    return $value->shift != null &&  $value->shift->start_date != null &&  $value->shift->end_date == null;
                                                })->first();

                                            $date = null;
                                            $time = null;
                                            if($complete->budgetDetails->count() > 1) {
                                                $list = $complete->budgetDetails->filter(function ($value, $key) {
                                                    return $value->date_time > Carbon\Carbon::now();
                                                });

                                                if(count($list) > 1){
                                                    $date = $list->first()->date_time->format('l, F j, Y');
                                                    $time = $list->first()->date_time->format('h:i A');
                                                    $latestBudget = $list;
                                                }
                                                else{
                                                     $date = $complete->budgetDetails->first()->date_time->format('l, F j, Y');
                                                    $time = $complete->budgetDetails->first()->date_time->format('h:i A');
                                                    $latestBudget = $complete->budgetDetails->first();
                                                }

                                            } else {

                                                $date = $complete->budgetDetails->first()->date_time->format('l, F j, Y');
                                                $time = $complete->budgetDetails->first()->date_time->format('h:i A');
                                                $latestBudget = $complete->budgetDetails->first();
                                            }
                                        @endphp
                                        <div class="job-listing-group"><span class="icon-feather-calendar"></span> {{ $date }} <span>(Anytime)</span></div>
                                    </div>


                                    <div class="col-6 pull-right">
                                        <div class="tabs-jobs-buttons">
                                            <span id="feedbackCompleteSection{{$complete->id}}">
                                                @if($complete->checkReviewByClient())
                                                    <a href="javascript:;" onclick="showReview({{ $complete->id }})" class="popup-with-zoom-anim button gray ripple-effect"><i class="icon-material-outline-supervisor-account"></i> View Review <span class="button-info"></span></a>
                                                @else
                                                    <a href="javascript:;" onclick="leaveReview({{ $complete->id }})" class="popup-with-zoom-anim button ripple-effect"><i class="icon-material-outline-supervisor-account"></i> Leave Review <span class="button-info"></span></a>
                                                @endif
                                            </span>
                                            <a href="javascript:;" onclick="completeJobDetail({{ $complete->id }})"  class="popup-with-zoom-anim button dark ripple-effect">Job Details <i class="icon-feather-clipboard"></i></a>
                                            <a href="javascript:;" onclick="sendMessage('{{ $complete->user_id }}', '{{ $complete->id }}', 'open')" class="popup-with-zoom-anim button gray ripple-effect" title="Contact" data-tippy-placement="top"><i class="icon-feather-message-square"></i></a>
                                            <a href="javascript:;" onclick="repostListing({{ $complete->id }})" class="popup-with-zoom-anim button gray ripple-effect" title="Post Similar" data-tippy-placement="top"><i class="icon-feather-copy"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
								<div class="row">
									<div class="col-6">
										<div class="job-listing-title"><a href="#">No jobs found</a></div>
										<div class="dashboard-status-button green">Get your project done today</div>
									</div>
									<div class="col-6 pull-right">
										<div class="tabs-jobs-buttons">
											<a href="#small-dialog-10" class="popup-with-zoom-anim button ripple-effect">Find jobs <i class="icon-feather-upload-cloud"></i></a>
										</div>
									</div>
								</div>
							</div>
                        @endforelse
                    </div>
                </div>
                <div class="tab" data-tab-id="4">

                    <!-- Unfilled Jobs (jobs-unfilled) -->
                    <div class="row tabs-jobs-border tabs-jobs-padding">
					
                        @forelse($freelancerdisputelist as $listing)
						<?php  //print_r($listing);
							 // die();
						?>
						
						<div class="col-12" id="listingRow{{ $listing->id }}">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="job-listing-title">
                                            <a href="{{ route('listing.list.show', $listing->id) }}" class="ellipsis">{{ ucwords($listing->job_title) }}</a>
                                            <span class="dashboard-status-button green">@if($listing->budgetDetails->count() > 1) ${{ $listing->budgetDetails->first()->budget }}/shift @else ${{ $listing->budgetDetails->sum('budget') }} @endif</span>
                                            @if($listing->budgetDetails->count() > 1)
                                                <span class="dashboard-status-button green"> On-going </span>
                                            @endif
                                            @if($listing->job_location == 'online')
                                                <span class="dashboard-status-button green"> Remote </span>
                                            @endif
                                        </div>

                                        <div class="job-listing-group"><span class="icon-feather-map-pin"></span> {{ ucfirst($listing->city) }}, {{ ucfirst($listing->state) }}</div>

                                        @php
                                            $date = null;
                                            $time = null;
                                            if($listing->budgetDetails->count() > 1) {
                                                $list = $listing->budgetDetails->filter(function ($value, $key) {
                                                    return $value->date_time < Carbon\Carbon::now();
                                                });
                                                $date = $list->first()->date_time->format('l, F j, Y');
                                                $time = $list->first()->date_time->format('h:i A');

                                            } else {

                                                $date = $listing->budgetDetails->first()->date_time->format('l, F j, Y');
                                                $time = $listing->budgetDetails->first()->date_time->format('h:i A');
                                            }
                                        @endphp

                                        <div class="job-listing-group"><span class="icon-feather-calendar"></span> {{ $date }} <span>(Anytime)</span></div>
                                    </div>
                                    <div class="col-6 pull-right">
                                        <div class="tabs-jobs-buttons">
										<a href="javascript:;" onclick="assignedJobDetail({{ $listing->id }})"  class="popup-with-zoom-anim button dark ripple-effect">Job Details <i class="icon-feather-clipboard"></i></a>
										<a href="javascript:;" onclick="sendMessage('{{ $listing->user_id }}', '{{ $listing->user_id }}', 'open')" class="popup-with-zoom-anim button gray ripple-effect" title="Contact Client" data-tippy-placement="top"><i class="icon-feather-message-square"></i></a>
                                            <!--<a href="{{ route('listing.copy', $listing->id) }}" class="popup-with-zoom-anim button ripple-effect"><i class="icon-material-outline-supervisor-account"></i> Repost Listing</a>-->
                                            <!--<a href="javascript:;" onclick="deleteListing({{ $listing->id }})" class="popup-with-zoom-anim button gray ripple-effect" title="Contact Client" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>-->
											<a href="javascript:;" onclick="@if(is_null($listing->dispute))openBidDispute({{ $listing->id }})@else showBidDispute({{ $listing->id }}) @endif" class="popup-with-zoom-anim button @if(is_null($listing->dispute)) gray @endif ripple-effect" title="Cancel Task" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            


                        @empty
                            <div class="col-12">
								<div class="row">
									<div class="col-6">
										<div class="job-listing-title"><a href="#">No disputes found</a></div>
										<div class="dashboard-status-button green">Get your project done today</div>
									</div>
									<div class="col-6 pull-right">
										<div class="tabs-jobs-buttons">
											<a href="#small-dialog-10" class="popup-with-zoom-anim button ripple-effect">Find jobs <i class="icon-feather-upload-cloud"></i></a>
										</div>
									</div>
								</div>
							</div>
                        @endforelse

                    </div>

                </div>
				<div class="tab" data-tab-id="5">

                    <!-- Unfilled Jobs (jobs-unfilled) -->
                    <div class="row tabs-jobs-border tabs-jobs-padding">
                        @forelse($freelancerendedListings as $listing)
                            <div class="col-12" id="listingRow{{ $listing->id }}">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="job-listing-title">
                                            <a href="{{ route('listing.list.show', $listing->id) }}" class="ellipsis">{{ ucwords($listing->job_title) }}</a>
                                            <span class="dashboard-status-button green">@if($listing->budgetDetails->count() > 1) ${{ $listing->budgetDetails->first()->budget }}/shift @else ${{ $listing->budgetDetails->sum('budget') }} @endif</span>
                                            @if($listing->budgetDetails->count() > 1)
                                                <span class="dashboard-status-button green"> On-going </span>
                                            @endif
                                            @if($listing->job_location == 'online')
                                                <span class="dashboard-status-button green"> Remote </span>
                                            @endif
                                        </div>

                                        <div class="job-listing-group"><span class="icon-feather-map-pin"></span> {{ ucfirst($listing->city) }}, {{ ucfirst($listing->state) }}</div>

                                        @php
                                            $date = null;
                                            $time = null;
                                            if($listing->budgetDetails->count() > 1) {
                                                $list = $listing->budgetDetails->filter(function ($value, $key) {
                                                    return $value->date_time < Carbon\Carbon::now();
                                                });
                                                $date = $list->first()->date_time->format('l, F j, Y');
                                                $time = $list->first()->date_time->format('h:i A');

                                            } else {

                                                $date = $listing->budgetDetails->first()->date_time->format('l, F j, Y');
                                                $time = $listing->budgetDetails->first()->date_time->format('h:i A');
                                            }
                                        @endphp

                                        <div class="job-listing-group"><span class="icon-feather-calendar"></span> {{ $date }} <span>(Anytime)</span></div>
                                    </div>
                                    <div class="col-6 pull-right">
                                        <div class="tabs-jobs-buttons">
                                            <a href="{{ route('listing.copy', $listing->id) }}" class="popup-with-zoom-anim button ripple-effect"><i class="icon-material-outline-supervisor-account"></i> Repost Listing</a>
                                            <a href="javascript:;" onclick="deleteListing({{ $listing->id }})" class="popup-with-zoom-anim button gray ripple-effect" title="Contact Client" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        @empty
                            <div class="col-12">
								<div class="row">
									<div class="col-6">
										<div class="job-listing-title"><a href="#">No jobs found</a></div>
										<div class="dashboard-status-button green">Get your project done today</div>
									</div>
									<div class="col-6 pull-right">
										<div class="tabs-jobs-buttons">
											<a href="#small-dialog-10" class="popup-with-zoom-anim button ripple-effect">Find jobs <i class="icon-feather-upload-cloud"></i></a>
										</div>
									</div>
								</div>
							</div>
                        @endforelse

                    </div>

                </div>
            </div>
        </div>
        <!-- Tabs Container / End -->
		
    </div>
    </div>
    <!-- View Offers  -->
    <div id="small-dialog-10" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
        <!--Tabs -->
        <div class="sign-in-form">
            <div class="popup-tabs-container" id="modalData">
                <!-- Tab -->
            </div>
        </div>
    </div>
    <!-- View Offers / END -->

@endsection

@section('footerjs')
    <script src="{{ asset('js/tabby.js') }}"></script>
    <!-- Snackbar // documentation: https://www.polonel.com/snackbar/ -->
    <script>
        function sendMessage(toUserId, listingId, status){
            if(status == 'open'){
                var url = "{{ route('user.message.get-message-popup', [':toUserId', ':listingId']) }}";
                url = url.replace(':toUserId', toUserId);
                url = url.replace(':listingId', listingId);
                $.easyAjax({
                    url: url,
                    type: "GET",
                    container: "#small-dialog-10",
                    success: function (response) {
                        // console.log(response);
                        $('#modalData').html(response.view);
                        openModal();
                    }
                });
            }
            else{
                var to_user = toUserId;
                var listing_id = listingId;
                var text = $('#directMessage').val();
                var withBRs = text.replace(/\n/g, "<br />") ;
                var message = '<p>' + withBRs + '</p>' ;

                $.ajax({
                    url: "{{ route('user.message.store') }}",
                    type: "POST",
                    container: ".message-reply",
                    data: {'to_user' : to_user, 'message' : message, 'listing_id' : listing_id, '_token': "{{ csrf_token() }}" },
                    success: function (response) {
                        $('#directMessage').val('');
                        closeModel();
                    }
                });
            }
        }
        function viewOffer(id, totalOffer){
			// console.log(id);
			// console.log(totalOffer);
            listingId = id;
            totalListingOffer = totalOffer;
            if(totalOffer > 0){
                var url = "{{ route('listing.view-offer',':id') }}";
                url = url.replace(':id', id);
                $.easyAjax({
                    url: url,
                    type: "GET",
                    container: "#small-dialog-10",
                    success: function (response) {
                        // console.log(response);
                        $('#modalData').html(response.view)
                        openModal();
                    }
                });
            }
            else{
                Snackbar.show({
                    text: 'No offer found for this listing.',
                    pos: 'bottom-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 3000,
                    textColor: '#fff',
                    backgroundColor: '#ed6359'
                });
            }
        }
        function repostListing(listingId){
            var url = "{{ route('listing.repost-listing',':id') }}";
            url = url.replace(':id', listingId);
            $.easyAjax({
                url: url,
                type: "GET",
                container: "#small-dialog-10",
                success: function (response) {
                    // console.log(response);
                    $('#modalData').html(response.view);
                    openModal();
                }
            });
        }
        function openModal(){
            $.magnificPopup.open({
                type: 'inline',
                items: {
                    src: '#small-dialog-10'
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
        function deleteListing(id){
            var url = "{{ route('listing.delete-listing',':id') }}";
            url = url.replace(':id', id);
            $.easyAjax({
                url: url,
                type: "GET",
                container: ".tabs-content",
                success: function (response) {
                    $('#modalData').html(response.view)
                    openModal();
                }
            });
        }
        function jobDetail(id){
            var url = "{{ route('listing.job-detail',':id') }}";
            url = url.replace(':id', id);
            $.easyAjax({
                url: url,
                type: "GET",
                container: ".tabs-content",
                success: function (response) {
                    $('#modalData').html(response.view);
                    openModal();
                }
            });
        }
        function assignedJobDetail(id){
            var url = "{{ route('listing.assigned-job-detail',':id') }}";
            url = url.replace(':id', id);
            $.easyAjax({
                url: url,
                type: "GET",
                container: ".tabs-content",
                success: function (response) {
                    $('#modalData').html(response.view);
                    openModal();
                }
            });
        }
        function completeJobDetail(id){
            var url = "{{ route('listing.view-complete-job',':id') }}";
            url = url.replace(':id', id);
            $.easyAjax({
                url: url,
                type: "GET",
                container: ".tabs-content",
                success: function (response) {
                    $('#modalData').html(response.view);
                    openModal();
                }
            });
        }
        function bidJobDetail(id){
            var url = "{{ route('listing.view-bid-job',':id') }}";
            url = url.replace(':id', id);
            $.easyAjax({
                url: url,
                type: "GET",
                container: ".tabs-content",
                success: function (response) {
                    $('#modalData').html(response.view);
                    openModal();
                }
            });
        }
        function showInvoice(id){
            var url = "{{ route('listing.show-invoice',':id') }}";
            url = url.replace(':id', id);
            $.easyAjax({
                url: url,
                type: "GET",
                container: ".tabs-content",
                success: function (response) {
                    $('#modalData').html(response.view);
                    openModal();
                }
            });
        }
        function updateOffer(id){
            var url = "{{ route('listing.update-offer',':id') }}";
            url = url.replace(':id', id);
            $.easyAjax({
                url: url,
                type: "GET",
                container: ".tabs-content",
                success: function (response) {
                    $('#modalData').html(response.view);
                    openModal();
                }
            });
        }
        function counterOffer(id){
            var url = "{{ route('listing.counter-offer',':id') }}";
            url = url.replace(':id', id);
            $.easyAjax({
                url: url,
                type: "GET",
                container: ".tabs-content",
                success: function (response) {
                    $('#modalData').html(response.view);
                    openModal();
                }
            });
        }

        function changeShift(id, type){
            var url = "{{ route('listing.change-shift',[':id', ':type']) }}";
            url = url.replace(':id', id);
            url = url.replace(':type', type);
            $.easyAjax({
                url: url,
                type: "GET",
                container: ".tabs-content",
                success: function (response) {
                    $('#modalData').html(response.view);
                    openModal();
                }
            });
        }
        function cancelTask(id){
            {{--var url = "{{ route('listing.cancel-task',':id') }}";--}}
            {{--url = url.replace(':id', id);--}}
            {{--$.easyAjax({--}}
                {{--url: url,--}}
                {{--type: "GET",--}}
                {{--container: ".tabs-content",--}}
                {{--success: function (response) {--}}
                    {{--$('#modalData').html(response.view);--}}
                    {{--openModal();--}}
                {{--}--}}
            {{--});--}}
        }
        function showReview(id){
            var url = "{{ route('listing.show-review',':id') }}";
            url = url.replace(':id', id);
            $.easyAjax({
                url: url,
                type: "GET",
                container: ".tabs-content",
                success: function (response) {
                    $('#modalData').html(response.view);
                    openModal();
                }
            });
        }
        function showCompletedReview(id){
            var url = "{{ route('listing.show-complete-review',':id') }}";
            url = url.replace(':id', id);
            $.easyAjax({
                url: url,
                type: "GET",
                container: ".tabs-content",
                success: function (response) {
                    $('#modalData').html(response.view);
                    openModal();
                }
            });
        }
        function leaveReview(id){
            var url = "{{ route('listing.leave-review',':id') }}";
            url = url.replace(':id', id);
            $.easyAjax({
                url: url,
                type: "GET",
                container: ".tabs-content",
                success: function (response) {
                    $('#modalData').html(response.view);
                    openModal();
                }
            });
        }
        function leaveCompletedReview(id){
            var url = "{{ route('listing.leave-complete-review',':id') }}";
            url = url.replace(':id', id);
            $.easyAjax({
                url: url,
                type: "GET",
                container: ".tabs-content",
                success: function (response) {
                    $('#modalData').html(response.view);
                    openModal();
                }
            });
        }
        function openDispute(id){

            var url = "{{ route('listing.open-dispute',':id') }}";
            url = url.replace(':id', id);
            $.easyAjax({
                url: url,
                type: "GET",
                container: ".tabs-content",
                success: function (response) {
                    $('#modalData').html(response.view)
                    openModal();
                }
            });

        }
        function openBidDispute(id){

            var url = "{{ route('listing.open-bid-dispute',':id') }}";
            url = url.replace(':id', id);
            $.easyAjax({
                url: url,
                type: "GET",
                container: ".tabs-content",
                success: function (response) {
                    $('#modalData').html(response.view)
                    openModal();
                }
            });

        }
        function showDispute(id){
            var url = "{{ route('listing.show-dispute',':id') }}";
            url = url.replace(':id', id);
            $.easyAjax({
                url: url,
                type: "GET",
                container: ".tabs-content",
                success: function (response) {
                    $('#modalData').html(response.view)
                    openModal();
                }
            });

        }
        function showBidDispute(id){
            var url = "{{ route('listing.show-bid-dispute',':id') }}";
            url = url.replace(':id', id);
            $.easyAjax({
                url: url,
                type: "GET",
                container: ".tabs-content",
                success: function (response) {
                    $('#modalData').html(response.view)
                    openModal();
                }
            });

        }
        function deleteList(id){
            var listingId = id;
            var url = "{{ route('listing.destroy',':id') }}";
            url = url.replace(':id', listingId);
            $.easyAjax({
                url: url,
                type: "GET",
                container: ".tabs-content",
                success: function (response) {
                    $('#listingRow'+id).remove();
                    $.magnificPopup.close();
                }
            });
        }
        function closeModel(){
           $.magnificPopup.close();
        }

    </script>
@endsection
