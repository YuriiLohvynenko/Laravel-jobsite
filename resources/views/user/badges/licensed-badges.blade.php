<div class="sign-in-form">
    <div class="popup-tabs-container">
        <!-- Tab -->
        <div class="popup-tab-content" id="tab">
            <!-- Welcome Text -->
            <div class="padding-bottom-0">
                <div class="row margin-bottom-20">
                    <div class="col-12">
                        <div class="modal-main">Get Your License</div>
                    </div>
                    <div class="col-12">
                        <div class="modal-head-">Show people you are certified in one or all areas of expertise.</div>
                    </div>
                </div>
                <form id="trueBadges">
                    {{ csrf_field() }}
                    <input type="hidden" value="{{ $id }}" name="badge_id">
                    <div class="row margin-top-40">
                        <div class="col-12">
                            <div class="input-with-icon-left" data-tippy-placement="bottom" data-tippy="" data-original-title="Name or Business Name">
                                <i class="icon-material-outline-account-circle"></i>
                                <input type="text" class="input-text with-border" name="name" id="name" placeholder="First and Last Name" value="{{ $user->full_name }}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-with-icon-left">
                                <i class="icon-material-outline-rate-review"></i>
                                <input type="text" class="input-text with-border" name="license_no" id="license_no" placeholder="License #" required="">
                            </div>
                        </div>
                        <div class="col-12">
                            <textarea name="description" cols="9" placeholder="Any additional information needed to verify license" class="with-border" style="height: 42px; overflow-y: hidden;"></textarea>
                        </div>
                        <div class="col-12">
                            <a href="" id="message-sent" class="popup-with-zoom-anim button button-sliding-icon ripple-effect" style="width: 30px;" onclick="submitBadge();return false;">Submit License <i class="icon-material-outline-arrow-right-alt"></i></a>
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
    var url = "{{ route('user.submit-licensed-badges') }}";
    $.easyAjax({
        url: url,
        type: "POST",
        container: "#trueBadges",
        data: $('#trueBadges').serialize(),
    });
}
</script>
