<div class="popup-tab-content" id="tab">
    <!-- Welcome Text -->
    <div class="padding-bottom-0">

        <div class="row">
            <div class="col-12">
                <div class="modal-main">Receipt of Completion</div>
            </div>
        </div>
        <div class="row margin-top-10">
            <div class="col-12">
                <div class="modal-description">Thanks for using wetask! Your tasker has successfully completed their work and would love your service again.</div>
            </div>
        </div>
        <div class="row margin-top-20">
            <div class="col-6">
                <div class="modal-head">Next Task</div>
                <div class="modal-head-">{{ $upComingDate->date_time->format('d.m.Y') }}</div>
            </div>
            <div class="col-6">
                <div class="modal-head">Order NO.</div>
                <div class="modal-head-">{{ $jobDetail->order_no }}</div>
            </div>
        </div>
        <div class="row margin-top-20">
            <div class="col-6">
                <div class="modal-note">Increase: ${{ $totalBudgetIncrease }} <i class="icon-feather-info" title="Total budget with increase located below" data-tippy-placement="top"></i></div>
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
                                        <div class="modal-sub-">5:16pm</div>
                                    </div>
                                    <div class="col-2">
                                        <div class="modal-sub-">6:16pm</div>
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                        <div class="row margin-top-10">
                            <!-- Show when user starts then ENDS shift -->
                            <!-- <div class="col-6">
                                <a href="#small-dialog-1" id="payment-release" class="popup-with-zoom-anim button button-sliding-icon ripple-effect modal-button">Release Payment <i class="icon-material-outline-arrow-right-alt"></i></a>
                            </div> -->
                            <!-- Show when user starts then ENDS shift / END -->

                            <!-- Show when user starts then ENDS shift -->
                            <div class="col-6">
                                <div class="crate-badge modal-crate-gray modal-crate-full">Inactive</div>
                            </div>
                            <!-- Show when user starts then ENDS shift / END -->

                            <!-- Show ".modal-note-release-active" when timer starts -->
                            <div class="col-6">
                                <div class="modal-note-release">Payment release: <span>48h 00m</span> <i class="icon-feather-info" title="Work must be verified within 2 days or payment will release" data-tippy-placement="top"></i></div>
                            </div>
                            <!-- Show ".modal-note-release-active" when timer starts / END -->
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div class="row margin-top-10">
            <div class="col-6">
                <div class="modal-head">Freelancer</div>
                <div class="modal-head- ellipsis">{{ $freelancerData->user->first_name }} {{ $freelancerData->user->last_name }}</div>
            </div>
            <div class="col-6">
                <a href="javascript:;" onclick="showSendTip({{ $jobDetail->id }})" class="popup-with-zoom-anim button button-sliding-icon ripple-effect modal-button">Send tip <i class="icon-material-outline-arrow-right-alt"></i></a>
            </div>
        </div>
        <div class="row margin-top-10">
            <div class="col-12">
                <div class="modal-head">Location</div>
                <div class="modal-head- ellipsis">{{$jobDetail->address}}, {{$jobDetail->city}}, {{$jobDetail->state}} {{$jobDetail->zip_code}}</div>
            </div>
        </div>
        <div class="padding-bottom-0 add-border-top">
            <div class="add-border-top-">
                <div class="row">
                    <div class="col-4">
                        <div class="modal-head">Hours Worked</div>
                        <div class="modal-head- green">200</div>
                    </div>
                    <div class="col-4">
                        <div class="modal-head">Cashback</div>
                        <div class="modal-head- green cashback">${{ $totalBudget*1/100 }}</div>
                    </div>
                    <div class="col-4">
                        <div class="modal-head">Total Budget <i class="icon-feather-info" title="Includes budget plus budget increase" data-tippy-placement="top"></i></div>
                        <div class="modal-head- green total">${{ $totalBudget }}</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>

    function showSendTip(id){
        var url = "{{ route('listing.show-tip',[':id']) }}";
        url = url.replace(':id', id);
        $.easyAjax({
            url: url,
            type: "GET",
            container: "#small-dialog-10",
            success: function (response) {
                $('#modalData').html(response.view)
            }
        });
    }

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
