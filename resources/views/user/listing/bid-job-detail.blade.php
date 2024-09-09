<div class="popup-tab-content" id="tab">
    <!-- Welcome Text -->
    <div class="padding-bottom-0">

        <div class="row">
            <div class="col-12">
                <div class="modal-main">Job Details</div>
            </div>
        </div>
        <div class="row margin-top-10">
            <div class="col-12">
                <div class="modal-description">Detailed view of the current scope of work. For full details visit listing.</div>
            </div>
        </div>
        <div class="row margin-top-20">
            <div class="col-6">
                <div class="modal-head">Start Date</div>
                <div class="modal-head-">{{ $startDate->date_time->format('d.m.Y') }}</div>
            </div>
            <div class="col-6">
                <div class="modal-head">Order NO.</div>
                <div class="modal-head-">{{ $jobDetail->order_no }}</div>
            </div>
        </div>
        <div class="margin-top-20">
            <div class="row">
                <div class="col-6">
                    <div class="modal-head">Task</div>
                </div>
                <div class="col-3">
                    <div class="modal-head">Budget</div>
                </div>
                <div class="col-3">
                    <div class="modal-head">Date</div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="modal-head- ellipsis">{{ ucwords($jobDetail->job_title) }}</div>
                </div>
                <div class="col-3">
                    <div class="modal-head- green">${{ $totalBudget }}</div>
                </div>
                <div class="col-3">
                    <div class="modal-head-">{{ $jobDetail->created_at->format('d.m.Y') }}</div>
                </div>
            </div>
        </div>

        <div class="margin-top-0">

            <div class="js-accordion">
                <div class="js-accordion-item">
                    <div class="accordion-custom-btn js-accordion-header">View Milestones <i class="icon-feather-plus"></i></div>

                    <div class="row-group accordion-body js-accordion-body">
                        <div class="margin-top-10">
                            <div class="row">
                                <div class="col-6">
                                    <div class="modal-head">Milestones</div>
                                </div>
                                <div class="col-2">
                                    <div class="modal-head">Pay</div>
                                </div>
                                <div class="col-2">
                                    <div class="modal-head">In</div>
                                </div>
                                <div class="col-2">
                                    <div class="modal-head">Out</div>
                                </div>
                            </div>
                            @forelse($jobDetail->budgetDetails as $budgetDetail)
                                <div class="row">
                                    <div class="col-6">
                                        <div class="modal-sub">{{ $budgetDetail->date_time->format('D, F dS, Y') }}</div>
                                    </div>
                                    <div class="col-2">
                                        <div class="modal-sub-">${{ $budgetDetail->budget }}</div>
                                    </div>
                                    <div class="col-2">
                                        <div class="modal-sub-">@if(!is_null($budgetDetail->shift) && $budgetDetail->shift->start_date != null)  {{ $budgetDetail->shift->start_date->format('H:ia') }} @else -- @endif</div>
                                    </div>
                                    <div class="col-2">
                                        <div class="modal-sub-">@if(!is_null($budgetDetail->shift) && $budgetDetail->shift->end_date != null)  {{ $budgetDetail->shift->end_date->format('H:ia') }} @else -- @endif</div>
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div class="row margin-top-10">
            <div class="col-6">
                <div class="modal-head">Client</div>
                <div class="modal-head- ellipsis">{{ $jobDetail->user->first_name }} {{ $jobDetail->user->last_name }}</div>
            </div>
            <div class="col-6">
                <div class="modal-head">Location</div>
                <div class="modal-head- ellipsis">{{$jobDetail->address}}, {{$jobDetail->city}}, {{$jobDetail->state}} {{$jobDetail->zip_code}}</div>
            </div>
        </div>

        <div class="padding-bottom-0 add-border-top">
            <div class="add-border-top-">
                <div class="row">
                    <div class="col-6">
                        <div class="modal-head">Scheduled Days</div>
                        <div class="modal-head- green">{{ count($jobDetail->budgetDetails) }}</div>
                    </div>
                    <div class="col-6">
                        <div class="modal-head">Total Budget <i class="icon-feather-info" data-tippy-placement="top" data-tippy="" data-original-title="What you'll receive in total so far"></i></div>
                        <div class="modal-head- green">${{ $totalBudget }}</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>

    var accordion = (function(){

        var $accordion = $('.js-accordion');
        var $accordion_header = $accordion.find('.js-accordion-header');

        // default settings
        var settings = {
            // animation speed
            speed: 400,

            // close all other accordion items if true
            oneOpen: false
        };

        return {
            // pass configurable object literal
            init: function($settings) {
                $accordion_header.on('click', function() {
                    accordion.toggle($(this));
                });

                $.extend(settings, $settings);

                // ensure only one accordion is active if oneOpen is true
                if(settings.oneOpen && $('.js-accordion-item.active').length > 1) {
                    $('.js-accordion-item.active:not(:first)').removeClass('active');
                }

                // reveal the active accordion bodies
                $('.js-accordion-item.active').find('> .js-accordion-body').show();
            },
            toggle: function($this) {

                if(settings.oneOpen && $this[0] != $this.closest('.js-accordion').find('> .js-accordion-item.active > .js-accordion-header')[0]) {
                    $this.closest('.js-accordion')
                        .find('> .js-accordion-item')
                        .removeClass('active')
                        .find('.js-accordion-body')
                        .slideUp();
                }

                // show/hide the clicked accordion item
                $this.closest('.js-accordion-item').toggleClass('active');
                $this.next().stop().slideToggle(settings.speed);
            }
        };
    })();
    $(document).ready(function(){
        accordion.init({ speed: 300, oneOpen: true });
    });

</script>
