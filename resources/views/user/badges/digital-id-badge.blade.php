<div class="sign-in-form">
    <div class="popup-tabs-container">
        <!-- Tab -->
        <div class="popup-tab-content" id="tab">
            <!-- Welcome Text -->
            <div class="padding-bottom-0">
                <div class="row margin-bottom-20">
                    <div class="col-12">
                        <div class="modal-main">Digital ID Badge</div>
                    </div>
                    <div class="col-12">
                        <div class="modal-head-">When applying for this badge you will be prompted to provide a clear photo of your ID on a flat dark surface</div>
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
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="modal-head margin-bottom-5">Upload Documents</div>
                        </div>
                        <div class="col-6">
                            <div class="modal-super- modal-radio">
                                <div class="radio">
                                    <input id="radio-1" name="radio" type="radio" value="Driver's License" checked="">
                                    <label for="radio-1"><span class="radio-label"></span> Driver's License <i class="icon-feather-info" data-tippy-placement="top" data-tippy="" data-original-title="Show the front of your Driver's License"></i></label>
                                </div>
                                <div class="radio">
                                    <input id="radio-2" name="radio" type="radio" value="State ID">
                                    <label for="radio-2"><span class="radio-label"></span> State ID <i class="icon-feather-info" data-tippy-placement="top" data-tippy="" data-original-title="Show the front of your State ID"></i></label>
                                </div>
                                <div class="radio">
                                    <input id="radio-3" name="radio" type="radio" value="United States Passport">
                                    <label for="radio-3"><span class="radio-label"></span> United States Passport <i class="icon-feather-info" data-tippy-placement="top" data-tippy="" data-original-title="Show the front of your United States Passport with name, photo, and information"></i></label>
                                </div>
                                <div class="radio">
                                    <input id="radio-4" name="radio" type="radio" value="Green Card">
                                    <label for="radio-4"><span class="radio-label"></span> Green Card <i class="icon-feather-info" data-tippy-placement="top" data-tippy="" data-original-title="Show the front of your Green Card"></i></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <span class="universal-images trueyouimg"><img src="images/tc43qk4x5t7omqx.jpg" alt="" id="blah"></span>
                        </div>
                    </div>
                    <div class="row margin-top-20">
                        <div class="col-12">
                            <div class="modal-subhead">Document Guidelines</div>
                        </div>
                        <div class="col-12">
                            <ul class="list-3 color modal-list">
                                <li>Show all four corners of your ID</li>
                                <li>Must be in color</li>
                                <li>Avoid any glare</li>
                                <li>Must be a PNG, JPEG, or BMP file</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row margin-top-20">
                        <div class="col-6">
                            <div class="input-with-icon-left uploadButton modal-upload-button">
                                <input class="uploadButton-input" name="file" type="file" accept="image/*, application/pdf" id="upload" multiple="" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                                <label class="uploadButton-button ripple-effect modal-default-button" for="upload">Upload</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <a href="" id="message-sent" class="popup-with-zoom-anim button button-sliding-icon ripple-effect modal-button-nomargin" style="width: 30px;" onclick="submitBadge(); return false;">Submit <i class="icon-material-outline-arrow-right-alt"></i></a>
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
