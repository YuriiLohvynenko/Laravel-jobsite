<div class="sign-in-form">
    <div class="popup-tabs-container">
        <!-- Tab -->
        <div class="popup-tab-content" id="tab">
            <!-- Welcome Text -->
            <div class="padding-bottom-0">
                <div class="row margin-bottom-20">
                    <div class="col-12">
                        <div class="modal-main">Background Check Badge</div>
                    </div>
                    <div class="col-12">
                        <div class="modal-head-">When applying for this badge you will be prompted to provide a copy of your online background check</div>
                    </div>
                </div>
                <form id="trueBadges" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" value="{{ $id }}" name="badge_id">
                    <div class="row margin-bottom-10">
                        <div class="col-12">
                            <div class="modal-head margin-bottom-5">Confirm your name <i class="icon-feather-info" data-tippy-placement="top" data-tippy="" data-original-title="This will also change on your profile"></i></div>
                        </div>
                        <div class="col-12">
                            <div class="input-with-icon-left" data-tippy-placement="bottom" data-tippy="" data-original-title="Verify First Name">
                                <i class="icon-material-outline-account-circle"></i>
                                <input type="text" class="input-text with-border" name="first_name" id="first_name" value="{{ $user->first_name }}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-with-icon-left" data-tippy-placement="bottom" data-tippy="" data-original-title="Verify Last Name">
                                <i class="icon-material-outline-account-circle"></i>
                                <input type="text" class="input-text with-border" name="last_name" id="last_name" value="{{ $user->last_name }}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-with-icon-left" data-tippy-placement="bottom" data-tippy="" data-original-title="Verify Email Address">
                                <i class="icon-material-outline-account-circle"></i>
                                <input type="text" class="input-text with-border" name="email" id="email" value="{{ $user->email }}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-with-icon-left" data-tippy-placement="bottom" data-tippy="" data-original-title="*required">
                                <i class="icon-material-outline-account-circle"></i>
                                <input type="text" class="input-text with-border" name="job_title" id="job_title" placeholder="Current or former job title" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="modal-head">Background Check Package</div>
                            <div class="modal-note">Package includes $50 fee</div>
                        </div>
                        <div class="col-6">

                            <div class="modal-super- modal-radio">
                                <div class="radio">
                                    <input id="radio-1" name="package_check" type="radio" value="Background Check Plus">
                                    <label for="radio-1">
                                        <span class="radio-label"></span>
                                        Background Check Plus
                                        <i class="icon-feather-info" data-tippy-placement="top" data-tippy="" data-original-title="Show the front of your Driver's License"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row margin-top-20">
                        <div class="col-12">
                            <div class="modal-subhead">Instructions</div>
                        </div>
                        <div class="col-12">
                            <ul class="list-1 color modal-list">
                                <li>Fill out the form above</li>
                                <li>Within 24 hours you'll receive an email from Transunion</li>
                                <li>Select the package above and complete the form</li>
                                <li>Submit and wait for that button to turn blue!</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row margin-top-20">
                        <div class="col-6">
                            <a href="" id="" class="popup-with-zoom-anim button gray button-sliding-icon ripple-effect modal-button-nomargin" style="width: 30px;">Cancel <i class="icon-material-outline-arrow-right-alt"></i></a>
                        </div>
                        <div class="col-6">
                            <a href="" id="" class="popup-with-zoom-anim button button-sliding-icon ripple-effect modal-button-nomargin" style="width: 30px;" onclick="submitBadge(); return false;">Submit <i class="icon-material-outline-arrow-right-alt"></i></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <button title="Close (Esc)" type="button" class="mfp-close"></button>
</div>


<script>
function submitBadge() {
    var url = "{{ route('user.submit-badges') }}";
    $.easyAjax({
        url: url,
        type: "POST",
        container: "#trueBadges",
        file: true,
    });
}
</script>
