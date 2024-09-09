@if($type == 'start')
    <!-- Tab -->
    <div class="popup-tab-content" id="tab">
        <!-- Welcome Text -->
        <div class="padding-bottom-0">
            <div class="row">
                <div class="col-12">
                    <div class="modal-main">Confirm Shift Start <i class="icon-feather-info" title="Listings automatically move to completed when final job is done" data-tippy-placement="top"></i></div>
                </div>
                <div class="col-12 margin-bottom-10">
                    <div class="modal-head-">Are you sure you want to start your shift? Remember, you don't clock out for lunches or breaks.</div>
                </div>
                <div class="col-12">
                    <div class="modal-head-">Once shift is started your location will be continuosly shared until shift is over. Only appplies to jobs on locations.</div>
                </div>
            </div>
            <div class="row margin-top-40">
                <div class="col-6">
                    <a href="javascript:;" onclick="submitShift('start')" id="message-sent" class="popup-with-zoom-anim button gray ripple-effect">Yes</a>
                </div>
                <div class="col-6">
                    <a href="javascript:;" id="message-sent" class="popup-with-zoom-anim button button-sliding-icon ripple-effect">No <i class="icon-material-outline-arrow-right-alt"></i></a>
                </div>
            </div>
        </div>
    </div>
@else
    <!-- Tab -->
    <div class="popup-tab-content" id="tab">
        <!-- Welcome Text -->
        <div class="padding-bottom-0">
            <div class="row">
                <div class="col-12">
                    <div class="modal-main">Confirm Shift Complete <i class="icon-feather-info" title="Listings automatically move to completed when final job is done" data-tippy-placement="top"></i></div>
                </div>
                <div class="col-12">
                    <div class="modal-head-">Are you sure you want to end your shift? Remember, you don't clock out for lunches or breaks.</div>
                </div>
            </div>
            <div class="row margin-top-40">
                <div class="col-6">
                    <a href="javascript:;" onclick="submitShift('end')" id="message-sent" class="popup-with-zoom-anim button gray ripple-effect">Yes</a>
                </div>
                <div class="col-6">
                    <a href="javascript:;" id="message-sent" class="popup-with-zoom-anim button button-sliding-icon ripple-effect">No <i class="icon-material-outline-arrow-right-alt"></i></a>
                </div>
            </div>
        </div>
    </div>
@enif
<script>
    function submitShift(type) {
        var listingID = {{ $listging->id }};
        var url = "{{ route('listing.submit-shift') }}";
        $.easyAjax({
            url: url,
            type: "POST",
            container: "#disputeDetailForm",
            data: {'type' : type, 'listingID' : listingID, '_token': "{{ csrf_token() }}" },
            success: function (response) {
                $.magnificPopup.close();
            }
        });
    }
</script>