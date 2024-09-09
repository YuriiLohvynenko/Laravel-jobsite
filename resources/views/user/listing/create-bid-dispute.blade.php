<!-- Tab -->
<div class="popup-tab-content" id="tab">

    <!-- Welcome Text -->
    <div class="padding-bottom-0">
        <form id="submitDispute">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-12">
                    <div class="modal-main">File a Dispute</div>
                    <div class="modal-description">Things not going as planned? We're here to help.</div>
                </div>
            </div>
            <div class="row margin-top-20">
                <div class="col-12">
                    <div class="modal-super">Freelancer</div>
                    <div class="modal-super-">{{ $freelancer->name }}</div>
                </div>
            </div>
            <div class="row margin-top-20">
                <div class="col-12 submit-field">
                    <div class="modal-super">Why are you cancelling?</div>
                    <div class="modal-super- modal-radio">
                        <div class="radio">
                            <input id="radio-1" name="reason" value="Freelancer Unresponsive" type="radio" checked>
                            <label for="radio-1"><span class="radio-label"></span> Freelancer Unresponsive</label>
                        </div>
                        <div class="radio">
                            <input id="radio-2" name="reason" value="Task Incorrectly Completed" type="radio">
                            <label for="radio-2"><span class="radio-label"></span> Task Incorrectly Completed</label>
                        </div>
                        <div class="radio">
                            <input id="radio-3" name="reason" value="Other - Tell Us Why Below" type="radio">
                            <label for="radio-3"><span class="radio-label"></span> Other - Tell Us Why Below</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row margin-top-30">
            <div class="col-12 submit-field">
                <input type="hidden" name="listing_id" value="{{ $listing->id }}">
                <input type="hidden" name="user_id" value="{{ $freelancer->id }}">
                <textarea name="text"  cols="9" placeholder="Provide detailed information as to why you are cancelling" class="with-border"></textarea>
            </div>
            <div class="col-12">
                <a href="javascript:;" onclick="submitDispute()" id="feedback-left" class="button button-sliding-icon ripple-effect">Open a Dispute <i class="icon-material-outline-arrow-right-alt"></i></a>
            </div>
        </div>
        </form>
    </div>

</div>

<script>
    function submitDispute() {
        var url = "{{ route('listing.dispute-bid-store') }}";
        $.easyAjax({
            url: url,
            type: "POST",
            data: $('#submitDispute').serialize(),
            container: "#small-dialog-10",
            success: function (response) {
                $('#disputeBidSection'+{{ $listing->id }}).html(response.view);
                $.magnificPopup.close();
            }
        });
    }
</script>