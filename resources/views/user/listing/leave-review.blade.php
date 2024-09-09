<div class="popup-tab-content" id="tab">
    <!-- Welcome Text -->
    <form class="feedbackPost">
        <div class="padding-bottom-0">
        <div class="row">
            <div class="col-12">
                <div class="modal-main">Leave User Feedback</div>
            </div>
        </div>
        <div class="row margin-top-20">
            <div class="col-12">
                <strong class="modal-super">Freelancer</strong>
                <div class="userid modal-super-">
                    <span>{{ $freelancer }}</span>
                    <span><i class="icon-feather-star" title="Feedback" data-tippy-placement="top"></i> 98%</span>
                    <span><i class="icon-feather-link" title="Reliability" data-tippy-placement="top"></i> 89%</span>
                </div>
            </div>
        </div>
        <div class="row margin-top-20 ">
            <div class="col-12 submit-field">
                <div class="modal-super">Rate Your Freelancer</div>
                <div class="leave-rating modal-super-">
                    <input type="radio" name="rating" id="rating-radio-1" value="1" required>
                    <label for="rating-radio-1" class="icon-material-outline-star"></label>
                    <input type="radio" name="rating" id="rating-radio-2" value="2" required>
                    <label for="rating-radio-2" class="icon-material-outline-star"></label>
                    <input type="radio" name="rating" id="rating-radio-3" value="3" required>
                    <label for="rating-radio-3" class="icon-material-outline-star"></label>
                    <input type="radio" name="rating" id="rating-radio-4" value="4" required>
                    <label for="rating-radio-4" class="icon-material-outline-star"></label>
                    <input type="radio" name="rating" id="rating-radio-5" value="5" required>
                    <label for="rating-radio-5" class="icon-material-outline-star"></label>
                </div><div class="clearfix"></div>
            </div>
        </div>
        <div class="row margin-top-40">
            <div class="col-12 submit-field">
                <input type="hidden" name="listID"  value="{{ $listing->id }}"  id="listID">
                <textarea name="textarea" cols="9" placeholder="How was your experience? Keep it professional." class="with-border"></textarea>
            </div>
            <div class="col-12">
                <a href="javascript:;" onclick="submitFeedback()" id="feedback-left" class="popup-with-zoom-anim button button-sliding-icon ripple-effect">Leave Feedback <i class="icon-material-outline-arrow-right-alt"></i></a>
            </div>
        </div>
    </div>
    </form>
</div>

<script>
    // Update selector to match your button
    function submitFeedback() {
        $.easyAjax({
            url: "{!! route('listing.submit-review') !!}",
            type: "POST",
            container: ".feedbackPost",
            data: $(".feedbackPost").serialize(),
            success: function (response) {
                console.log(response);
                $('#feedbackSection'+{{ $listing->id }}).html(response.view);
                $.magnificPopup.close();
            }
        });
        return false;
    }
</script>
