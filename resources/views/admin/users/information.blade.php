<!--Tabs -->
<div class="sign-in-form">

    <div class="popup-tabs-container">

        <!-- Tab -->
        <div class="popup-tab-content" id="tab">

            <!-- Welcome Text -->
            <div class="padding-bottom-0">

                <div class="row">
                    <div class="col-12">
                        <div class="modal-main">Profile Information</div>
                    </div>
                </div>

                <div class="row margin-top-10">
                    <div class="col-12">
                        <div class="modal-description">Detailed user information</div>
                    </div>
                </div>

                <div class="row margin-top-20">
                    <div class="col-4">
                        <div class="modal-head">Sign Up Date <i class="icon-feather-info" title="View Timesheet and Milestones below" data-tippy-placement="top"></i></div>
                        <div class="modal-head-">{{ $user->created_at->format('d.m.Y') }}</div>
                    </div>
                    <div class="col-4">
                        <div class="modal-head">Cashback</div>
                        <div class="modal-head- green">$549.20</div>
                    </div>
                    <div class="col-4">
                        <div class="modal-head">Cancellations</div>
                        <div class="modal-head-">20</div>
                    </div>
                </div>

                <div class="margin-top-20">
                    <div class="row">
                        <div class="col-6">
                            <div class="modal-head">Profile Email</div>
                        </div>
                        <div class="col-6">
                            <div class="modal-head">Paypal Email</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="modal-head-">{{ $user->email }}</div>
                        </div>
                        <div class="col-3">
                            <div class="modal-head-">{{ $user->paypal_email ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                <div class="margin-top-10">

                    <div class="js-accordion">
                        <div class="js-accordion-item">
                            <div class="accordion-custom-btn js-accordion-header">Activation Settings <i class="icon-feather-plus"></i></div>

                            <div class="row-group accordion-body js-accordion-body">
                                <div class="margin-top-10 margin-bottom-40">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="modal-head-">Activation Status <label class="switch"><input onchange="changeStatus(); return false;" name="status" type="checkbox" @if($user->status == 1) checked @endif value="1"><span class="switch-button"></span></label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="row margin-top-10">
                    <div class="col-4">
                        <div class="modal-head">User</div>
                        <div class="modal-head-">{{ $user->full_name }}</div>
                    </div>
                    <div class="col-4">
                        <div class="modal-head">Address</div>
                        <div class="modal-head-">{{ $user->detail->address ?? '-' }}</div>
                    </div>
                    <div class="col-4">
                        <div class="modal-head">Mobile Phone</div>
                        <div class="modal-head-">{{ $user->detail->mobile_no ?? '-' }}</div>
                    </div>
                </div>
                <div class="row margin-top-10">
                    <div class="col-12">
                        <div class="modal-head">Current Badges</div>
                        <div class="modal-super- modal-badges">
                            @forelse($user->badge as $badge)
                                <a href="javascript:;" onclick="showConfirmationModal('{{ $badge->id }}')" class="popup-with-zoom-anim"><span class="{{ $badge->badge->icon }}" title="{{ $badge->badge->name }}" data-tippy-placement="top"></span></a>
                            @empty
                                -
                            @endforelse
                        </div>

                    </div>
                </div>
                <div class="row margin-top-20">
                    <div class="col-6">
                        <div class="modal-head">Main Specialty</div>
                        <div class="modal-head-">{{ $user->get_specialties($user->specialties) }}</div>
                    </div>
                    <div class="col-6">
                        <div class="modal-head">Previous Titles</div>
                        @php
                            $previousTitles = ($user->detail->previous_job_titles != null) ? \GuzzleHttp\json_decode($user->detail->previous_job_titles) : []

                        @endphp
                        <div class="modal-head-">
                            @forelse($previousTitles as $previousTitle)
                                <span>{{ $previousTitle }},</span>
                            @empty
                                -
                            @endforelse
                        </div>


                    </div>
                </div>
            </div>

            <div class="padding-bottom-0 add-border-top">
                <div class="add-border-top-">
                    <div class="row">
                        <div class="col-4">
                            <div class="modal-head">Hours Worked</div>
                            <div class="modal-head- green">-</div>
                        </div>
                        <div class="col-4">
                            <div class="modal-head">Total Paid <i class="icon-feather-info" title="Includes budget plus budget increase" data-tippy-placement="top"></i></div>
                            <div class="modal-head- green">-</div>
                        </div>
                        <div class="col-4">
                            <div class="modal-head">Total Made <i class="icon-feather-info" title="Includes budget plus budget increase" data-tippy-placement="top"></i></div>
                            <div class="modal-head- green">-</div>
                        </div>
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

    $(".switch, .radio").each(function() {
        var intElem = $(this);
        intElem.on('click', function() {
            intElem.addClass('interactive-effect');
            setTimeout(function() {
                intElem.removeClass('interactive-effect');
            }, 400);
        });
    });

    function showConfirmationModal(badgeId){
        var url = "{{ route('admin.users.badge.confirmation') }}";
        $.easyAjax({
            url: url,
            type: "GET",
            container: "#badgeConfirmation",
            data: {
                badgeId:badgeId,
            },
            success: function (response) {
                $('#small-dialog-1').html(response.view);
            }
        });
    }

    function changeStatus() {
        var status = 0;
        if ($('input[name=status]').is(':checked')) {
            status = 1;
        }

        var url = "{{ route('admin.users.change-status') }}";
        $.easyAjax({
            url: url,
            type: "POST",
            container: ".js-accordion",
            data: {
                id:'{{ $user->id }}',
                status:status
            },
        });
    }
</script>
