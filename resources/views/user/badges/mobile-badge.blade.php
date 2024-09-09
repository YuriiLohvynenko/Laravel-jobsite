<div class="sign-in-form">
    <div class="popup-tabs-container">
        <!-- Tab -->
        <div class="popup-tab-content" id="tab">
            <!-- Welcome Text -->
            <div class="padding-bottom-0">
                <div class="row margin-bottom-20">
                    <div class="col-12">
                        <div class="modal-main">Mobile Phone Badge</div>
                    </div>
                    <div class="col-12">
                        <div class="modal-head-">When applying for this badge you will be prompted to enter your mobile phone number where you'll receive a verification text.</div>
                    </div>
                </div>
                <form id="trueBadges" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" value="{{ $id }}" name="badge_id">
                    <div class="row margin-bottom-10">
                        <div class="col-12">
                            <div class="modal-head margin-bottom-5">Enter Mobile Number <i class="icon-feather-info" data-tippy-placement="top" data-tippy="" data-original-title="This will also change on your profile"></i></div>
                        </div>
                        <div class="col-12">
                            <div class="input-with-icon-left" data-tippy-placement="bottom" data-tippy="" data-original-title="Input Your Mobile Number">
                                <i class="icon-material-outline-account-circle"></i>
                                <input type="tel" class="input-text with-border" name="tel" id="tel" placeholder="(216) 123-9743">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="modal-head margin-bottom-5">Enter Verification Code</div>
                        </div>
                        <div class="col-4">
                            <input placeholder="32482N">
                        </div>
                        <div class="col-8">
                            <div class="modal-note">*Data rates may apply</div>
                        </div>
                    </div>
                    <div class="row margin-top-20">
                        <div class="col-12">
                            <div class="modal-subhead">Instructions</div>
                        </div>
                        <div class="col-12">
                            <ul class="list-1 color modal-list">
                                <li>Enter mobile phone number above and click "Send Code"</li>
                                <li>Within 2 minutes you will receive a text that includes a code</li>
                                <li>Enter that code into the verification below it</li>
                                <li>Verify and wait for that button to turn blue!</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row margin-top-20">
                        <div class="col-6">
                            <a href="" id="" class="popup-with-zoom-anim button gray ripple-effect modal-button-nomargin">Send Code</a>
                        </div>
                        <div class="col-6">
                            <a href="" id="" class="popup-with-zoom-anim button button-sliding-icon ripple-effect modal-button-nomargin" style="width: 30px;">Verify <i class="icon-material-outline-arrow-right-alt"></i></a>
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
