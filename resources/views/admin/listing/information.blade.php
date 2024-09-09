<!--Tabs -->
<div class="sign-in-form">

    <div class="popup-tabs-container">

        <!-- Tab -->
        <div class="popup-tab-content" id="tab">

            <!-- Welcome Text -->
            <div class="padding-bottom-0">

                <div class="row">
                    <div class="col-12">
                        <div class="modal-main">Listing Information</div>
                    </div>
                </div>

                <div class="row margin-top-10">
                    <div class="col-12">
                        <div class="modal-description">Detailed listing information</div>
                    </div>
                </div>

                <div class="row margin-top-20">
                    <div class="col-4">
                        <div class="modal-head">Date Posted <i class="icon-feather-info" title="View Timesheet and Milestones below" data-tippy-placement="top"></i></div>
                        <div class="modal-head-">{{ $listing->created_at->format('d.m.Y') }}</div>
                    </div>
                    <div class="col-4">
                        <div class="modal-head">Listing ID</div>
                        <div class="modal-head- green">{{ $listing->order_no }}</div>
                    </div>
                    <div class="col-4">
                        <div class="modal-head">Increases</div>

                        @php
                        $total = 0;
                        $totalIncrease = 0;
                        foreach($listing->budgetDetails as $milestone) {
                            $total += $milestone->increase_history->count();
                            $totalIncrease += $milestone->increase_history->sum('amount');
                        }
                        @endphp
                        <div class="modal-head-">{{ $total }}</div>
                    </div>
                </div>

                <div class="margin-top-20">
                    <div class="row">
                        <div class="col-6">
                            <div class="modal-head">Client</div>
                            <div class="modal-head-"><a href="#">{{ $listing->user->full_name }} ({{$listing->user->username}})</a></div>
                        </div>
                        <div class="col-6">
                            <div class="modal-head">Freelancer</div>
                            <div class="modal-head-">
                                @if($listing->selectedOffers)
                                    <a href="#">{{ $listing->selectedOffers ? $listing->selectedOffers->user->full_name : '-' }} ({{ $listing->selectedOffers ? $listing->selectedOffers->user->username : '-' }})
                                    </a>
                                    @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row margin-top-20">
                    <div class="col-6">
                        <a href="#small-dialog-4" class="popup-with-zoom-anim button button-sliding-icon ripple-effect modal-button">Release Funds <i class="icon-material-outline-arrow-right-alt"></i></a>
                    </div>
                </div>

                <div class="row margin-top-10">
                    <div class="col-6">
                        <div class="modal-head">Address</div>
                        <div class="modal-head-">{{ $listing->user->detail ? $listing->user->detail->address : '-'  }}</div>
                    </div>
                    <div class="col-6">
                        <div class="modal-head">Mobile Phone</div>
                        <div class="modal-head-">{{ $listing->user->detail ? $listing->user->detail->mobile_no : '-' }}</div>
                    </div>
                </div>
                <div class="row margin-top-20">
                    <div class="col-6">
                        <div class="modal-head">Category</div>
                        <div class="modal-head-">{{ $listing->category ? $listing->category->name : '-' }}</div>
                    </div>
                    <div class="col-6">
                        <div class="modal-head">Scheduled Days</div>
                        <div class="modal-head-">{{ $listing->budgetDetails->count() }}</div>
                    </div>
                </div>
            </div>

            <div class="padding-bottom-0 add-border-top">
                <div class="add-border-top-">
                    <div class="row">
                        <div class="col-4">
                            <div class="modal-head">Budget Increase</div>
                            <div class="modal-head- green">${{ $totalIncrease }}</div>
                        </div>
                        <div class="col-4">
                            <div class="modal-head">Cashback</div>
                            <div class="modal-head- green">${{ ($listing->budgetDetails->sum('budget') + $totalIncrease)*1/100 }}</div>
                        </div>
                        <div class="col-4">
                            <div class="modal-head">Total Budget <i class="icon-feather-info" title="Includes budget plus budget increase" data-tippy-placement="top"></i></div>
                            <div class="modal-head- green">${{ $listing->budgetDetails->sum('budget') + $totalIncrease }}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
