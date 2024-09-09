<!-- Tab -->
<div class="popup-tab-content" id="tab">

    <!-- Welcome Text -->
    <div class="padding-bottom-0">

        <div class="row">
            <div class="col-12">
                <div class="modal-main">Payment Release <i class="icon-feather-info" title="Released payments can no longer be refunded." data-tippy-placement="top"></i></div>
            </div>
        </div>

        <div class="row margin-top-20">
            <div class="col-12">
                <div class="modal-description">Confirm below that you want to release this payment. This will immediately distribute the "Release Amount" to your accounts.</div>
            </div>
        </div>
        <div class="row margin-top-10">
            <div class="col-4">
                <div class="modal-head">Total Budget</div>
                <div class="modal-head-">${{ $total }}</div>
            </div>
            <div class="col-4">
                <div class="modal-head">Release Amount</div>
                <div class="modal-head- green">${{ $budgetDetail->budget }}</div>
            </div>
            <div class="col-4">
                <div class="modal-head">Cashback <i class="icon-feather-info" title="Includes budget plus budget increase" data-tippy-placement="top"></i></div>
                <div class="modal-head- green">${{ $budgetDetail->budget*1/100 }}</div>
            </div>
        </div>
        <div class="row margin-top-10">
            <!-- Button -->
            <a href="javascript:;" onclick="releasePayment({{ $budgetDetail->id }})" id="payment-release" class="popup-with-zoom-anim button button-sliding-icon ripple-effect">Release Payment <i class="icon-material-outline-arrow-right-alt"></i></a>
        </div>
        <div class="row margin-top-10">
            <div class="col-6">
                <a href="javascript:;" onclick="assignedJobDetail({{  $budgetDetail->listing_id }})" class="popup-with-zoom-anim button-sliding-icon ripple-effect modal-button"><i class="icon-feather-arrow-left"></i> Return to job details</a>
            </div>
        </div>

    </div>

</div>
<script>
    function releasePayment(budgetId) {
        var url = "{{ route('listing.release-payment',[':id']) }}";
        url = url.replace(':id', budgetId);
        $.easyAjax({
            url: url,
            type: "GET",
            container: "#small-dialog-10",
            success: function (response) {
                assignedJobDetail({{  $budgetDetail->listing_id }})
            }
        });
    }
</script>
