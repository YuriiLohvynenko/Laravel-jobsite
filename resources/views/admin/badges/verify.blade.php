
<!--Tabs -->
<div class="sign-in-form">

    <div class="popup-tabs-container" id="badgeConfirmation">

        <!-- Tab -->
        <div class="popup-tab-content" id="tab">

            <!-- Welcome Text -->
            <div class="padding-bottom-0">

                <div class="row">
                    <div class="col-12">
                        <div class="modal-main">Badge Confirmation</div>
                    </div>
                </div>

                <div class="row margin-top-10">
                    <div class="col-12">
                        <div class="modal-description">Detailed badge information</div>
                    </div>
                </div>

                <div class="row margin-top-20">
                    <div class="col-4">
                        <div class="modal-head">Request Date <i class="icon-feather-info" title="View Timesheet and Milestones below" data-tippy-placement="top"></i></div>
                        <div class="modal-head-">{{ $badge->created_at->format('d.m.Y') }}</div>
                    </div>
                    <div class="col-4">
                        <div class="modal-head">User</div>
                        <div class="modal-head-">{{ $badge->user->full_name }}</div>
                    </div>
                    <div class="col-4">
                        <div class="modal-head">Badges</div>
                        <div class="modal-head-">{{ $accepted->count() }}</div>
                    </div>
                </div>

                <div class="margin-top-10">

                    <div class="js-accordion">
                        <div class="js-accordion-item">
                            <div class="accordion-custom-btn js-accordion-header">Badge Approvals <i class="icon-feather-plus"></i></div>

                            <div class="row-group accordion-body js-accordion-body">
                                <div class="margin-top-10 margin-bottom-20">
                                    @foreach($pending as $request)
                                        <div class="row margin-bottom-5">
                                            <div class="col-6">
                                                <div class="modal-head-">{{ $request->badge->name }}</div>
                                            </div>
                                            <div class="col-5 offset-1">
                                                <a href="javascript:;" onclick="openBadgeDetails('{{ $request->id }}', 'small-dialog-1')" class="popup-with-zoom-anim button button-sliding-icon ripple-effect modal-button">View Documents <i class="icon-material-outline-arrow-right-alt"></i></a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="row margin-top-10">
                    <div class="col-6">
                        <div class="modal-head">User</div>
                        <div class="modal-head-">{{ $badge->user->full_name }}</div>
                    </div>
                    <div class="col-6">
                        <div class="modal-head">Address</div>
                        <div class="modal-head-">{{ $badge->user->detail->address }}</div>
                    </div>
                </div>
                <div class="row margin-top-10">
                    <div class="col-12">
                        <div class="modal-head">Current Badges</div>
                        <div class="modal-super- modal-badges">
                            @forelse($badge->user->badge as $badge)
                                <a href="javascript:;" onclick="showConfirmationModal('{{ $badge->id }}')" class="popup-with-zoom-anim"><span class="{{ $badge->badge->icon }}" title="{{ $badge->badge->name }}" data-tippy-placement="top"></span></a>
                            @empty
                                -
                            @endforelse
                        </div>
                        {{--<div class="modal-super- modal-badges">
                            <a href="#small-dialog-5" class="popup-with-zoom-anim"><span class="icon-feather-alert-circle" title="Gas and Propane License" data-tippy-placement="top"></span></a>
                            <a href="#small-dialog-5" class="popup-with-zoom-anim"><span class="icon-feather-alert-triangle" title="Asbestos/Hazardous Waste" data-tippy-placement="top"></span></a>
                            <a href="#small-dialog-5" class="popup-with-zoom-anim"><span class="icon-feather-wind" title="HVAC License" data-tippy-placement="top"></span></a>
                            <a href="#small-dialog-5" class="popup-with-zoom-anim"><span class="icon-material-outline-home" title="Residential Contracting License" data-tippy-placement="top"></span></a>
                            <a href="#small-dialog-5" class="popup-with-zoom-anim"><span class="icon-material-outline-business" title="Commercial Contracting License" data-tippy-placement="top"></span></a>
                            <a href="#small-dialog-5" class="popup-with-zoom-anim"><span class="icon-line-awesome-tint" title="Plumbers License" data-tippy-placement="top"></span></a>
                            <a href="#small-dialog-5" class="popup-with-zoom-anim"><span class="icon-feather-scissors" title="Carpenters License" data-tippy-placement="top"></span></a>
                            <a href="#small-dialog-5" class="popup-with-zoom-anim"><span class="icon-feather-anchor" title="Ironworkers License" data-tippy-placement="top"></span></a>
                            <a href="#small-dialog-5" class="popup-with-zoom-anim"><span class="icon-line-awesome-unlink" title="Welders License" data-tippy-placement="top"></span></a>
                            <a href="#small-dialog-5" class="popup-with-zoom-anim"><span class="icon-feather-cloud-rain" title="Weatherproofing" data-tippy-placement="top"></span></a>
                            <a href="#small-dialog-5" class="popup-with-zoom-anim"><span class="icon-feather-thermometer" title="Irrigation License" data-tippy-placement="top"></span></a>
                            <a href="#small-dialog-5" class="popup-with-zoom-anim"><span class="icon-line-awesome-map-signs" title="Fencing License" data-tippy-placement="top"></span></a>
                            <a href="#small-dialog-5" class="popup-with-zoom-anim"><span class="icon-line-awesome-plug" title="Electrical License" data-tippy-placement="top"></span></a>
                        </div>--}}
                    </div>
                </div>
                <div class="row margin-top-20">
                    <div class="col-6">
                        <div class="modal-head">Main Specialty</div>
                        <div class="modal-head-">{{ $badge->user->get_specialties($badge->user->specialties) }}</div>
                    </div>
                    <div class="col-6">
                        <div class="modal-head">Previous Titles</div>
                        <div class="modal-head-">
                            @php
                                $previousTitles = ($badge->user->detail->previous_job_titles != null) ? \GuzzleHttp\json_decode($badge->user->detail->previous_job_titles) : []

                            @endphp
                            @forelse($previousTitles as $previousTitle)
                                <span>{{ $previousTitle }},</span>
                            @empty
                            @endforelse
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

    function openBadgeDetails(badgeId, popup_id) {
        $('.zoom-anim-dialog').prop('id', popup_id);
        // showModal(popup_id);

        var url = "{{ route('admin.badges.detail') }}";
        $.easyAjax({
            url: url,
            type: "GET",
            container: "#badgeConfirmation",
            data: {
                badgeId:badgeId,
            },
            success: function (response) {
                $('#'+popup_id).html(response.view);
            }
        });
    }

    function showConfirmationModal(badgeId){
        var url = "{{ route('admin.badges.confirmation') }}";
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
</script>
