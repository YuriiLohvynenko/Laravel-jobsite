<!-- Job Listing -->
<?php //print_r($searchListings); ?>
@forelse($searchListings as $searchListing)
    <div class="job-listing">

        <!-- Job Listing Details -->
        <a href="javascript:void(0);" data-listing-id="{{ $searchListing->id }}" class="job-listing-details">

            <!-- Logo -->
            <div class="job-listing-company-logo">
                <img src="{{ $searchListing->firstimage($searchListing->id) }}" alt="">
            </div>

            <!-- Details -->
            <div class="job-listing-description">
                <h3 class="job-listing-title">{{ ucwords($searchListing->job_title) }}</h3>
                @php
                    $date = null;
                    $time = null;
                    $available = true;
                    $nextMilstoneAmount = 0;

                     if($searchListing->offer->count() > 0) {
                        $offer = $searchListing->offer->filter(function ($value, $key) {
                            return $value->status = 'accepted';
                        });
                         if(count($offer) > 1){
                            $available = false;
                        }
                    }
                    if($searchListing->budgetDetails->count() > 1) {
                        $list = $searchListing->budgetDetails->filter(function ($value, $key) {
                            return $value->date_time->greaterThanOrEqualTo(Carbon\Carbon::now());
                        });

                        $date = $list->first()->date_time->format('l, F j, Y');
                        $time = $list->first()->date_time->format('h:i A');
                        $nextMilstoneAmount = $list->first()->budget;
                        // if(count($list) > 1){
                        // }
                        // else{
                        //      $date = $searchListing->budgetDetails->first()->date_time->format('l, F j, Y');
                        //      $time = $searchListing->budgetDetails->first()->date_time->format('h:i A');
                        // }

                    } else {
                        $date = $searchListing->budgetDetails->first()->date_time->format('l, F j, Y');
                        $time = $searchListing->budgetDetails->first()->date_time->format('h:i A');
                    }
                @endphp
                <div class="row">
                    <div class="col-auto">
                        <div class="search-price">
                            @if ($nextMilstoneAmount !== 0)
                                ${{$nextMilstoneAmount}} -
                            @endif
                            ${{ $searchListing->budgetDetails->sum('budget') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        @if($searchListing->immediate_assistance == 'required')
                            <span class="search-badge search-badge-red">Immediate Assistance</span>
                        @endif

                        @if(count($searchListing->budgetDetails) == 1)
                            <span class="search-badge">Temporary</span>
                        @endif

                        @if(count($searchListing->budgetDetails) > 1)
                            <span class="search-badge search-badge-green">On-going</span>                        
                        @endif
						
                        @if($searchListing->assigned == 'yes')
                            <span class="search-badge search-badge-green">Assigned</span>   
						@else 
							<span class="search-badge search-badge-green">Available</span>   
                        @endif

                    </div>
                </div>

                <!-- Job Listing Footer -->
                <div class="job-listing-footer">
                    <ul>
                        <li><i class="icon-material-outline-location-on"></i>
                            @if($searchListing->job_location == 'online')
                                Remote
                            @else
                                {{ ucfirst($searchListing->city) }}, {{ ucfirst($searchListing->state) }}
                            @endif
                        </li>
                        <li>
                            <i class="icon-material-outline-access-time"></i>
                            @if($searchListing->immediate_assistance == 'required')
                                As Soon As Possible
                            @else
                                {{ $time }} - {{ $date }}
                            @endif
                        </li>
                    </ul>
                </div>
            </div>

        </a>
        <!-- Bookmark -->
        <div class="bookmark">
            <span class="bookmark-icon @if( $user && $searchListing->bookmark->count() > 0 && $searchListing->bookmark->first()->listing_id == $searchListing->id ) bookmarked @endif" data-listing-id="{{ $searchListing->id }}"></span>
        </div>
    </div>
@empty
    <a href="javascript:void(0);" class="job-listing">
        <div class="job-listing-details">
            <!-- Logo -->
            <div class="job-listing-company-logo">
                <img src="{{ asset('images/company-logo-05.png') }}" alt="">
            </div>

            <div class="job-listing-description">
                <h4>No Listing found matching the search criteria.</h4>
            </div>
        </div>
    </a>
@endforelse
