<form class="feedbackPost">
    <div class="row">
        <div class="col-12">
            <div class="modal-main">Leave a Review</div>
            <div class="modal-description">Rate <a href="#">{{ $toUserName }}</a> for the project <a href="#">{{ $listing->job_title }}</a></div>
        </div>
    </div>
    <div class="row margin-top-20">
        <div class="col-12">
            <div class="modal-super">@if($type == 'freelancer') Freelancer @else @endif</div>
            <div class="modal-super-">{{ $freelancer }}</div>
        </div>
    </div>
    <div class="row margin-top-20">
        <div class="col-12 submit-field">
            <div class="modal-super">Rate Your Freelancer</div>
            <div class="leave-rating modal-super ">
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
    <div class="row margin-top-30">
        <div class="col-12 submit-field">
            <input type="hidden" name="type" value="{{ $type }}" id="feedbackType">
            <input type="hidden" name="listID"  value="{{ $listing->id }}"  id="listID">
            <textarea name="textarea" cols="9" placeholder="How was your experience? Keep it professional." class="with-border"></textarea>
        </div>
        <div class="col-12">
            <a href="javascript:;" onclick="submitForm()" id="feedback-left" class="popup-with-zoom-anim button button-sliding-icon ripple-effect">Leave Feedback <i class="icon-material-outline-arrow-right-alt"></i></a>
        </div>
    </div>
</form>
