<style>
    select.bs-select-hidden, select.selectpicker {
        display: block!important;
    }
</style>
<!-- Tab -->
<div class="popup-tab-content" id="tab">
    <!-- Welcome Text -->
    <div class="padding-bottom-0">

        <div class="row">
            <div class="col-12">
                <div class="modal-main">Send a Tip</div>
            </div>
        </div>
        <div class="row margin-top-10">
            <div class="col-12">
                <div class="modal-description">Send your freelancer a tip instantaneously for a job well done. Oh yeah, 100% goes to the freelancer.</div>
            </div>
        </div>
        <div class="row margin-top-20 submit-field">
            <div class="col-12">
                <div class="bidding-field">
                    <!-- Quantity Buttons -->
                    <div class="qtyButtons">
                        <div class="qtyDec"></div>
                        <input type="text" id="qtyInput" name="qtyInput" min="0" placeholder="20">
                        <div class="qtyInc"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row margin-top-30">
            <div class="col-4">
                <input class="margin-bottom-0" placeholder="Enter Code" title="Verify code sent by text message" data-tippy-placement="top" />
            </div>
            <div class="col-auto">
                <a href="#" class="button ripple-effect gray">Send</a>
            </div>
            <div class="col-auto">
                <a href="#" class="button ripple-effect">Verify</a>
            </div>
        </div>
        <div class="row margin-top-20">
            <div class="col-12">
                <a href="javascript:;" onclick="sendTip(); return false;" id="send-tip" class="popup-with-zoom-anim button button-sliding-icon ripple-effect">Send Tip <i class="icon-material-outline-arrow-right-alt"></i></a>
            </div>
        </div>
        <div class="row margin-top-10">
            <div class="col-6">
                <a href="javascript:;" onclick="showInvoice({{  $listing->id }})" class="popup-with-zoom-anim button-sliding-icon ripple-effect modal-button"><i class="icon-feather-arrow-left"></i> Return to Invoice</a>
            </div>
        </div>

    </div>
</div>
<script>
$(function(e) {
    var tabs = new Tabby('[data-tabs]');
    $('[data-tabs]').click(function(e) {
        var tabbyDiv = $(this).next();
        if(tabbyDiv.hasClass('modal-active')) {
            tabbyDiv.addClass('tabby-border');
        }
    });
})

    function sendTip() {
        var listingID = {{ $listing->id }};
        var amnt = $('#qtyInput').val();
        var url = "{{ route('listing.send-tip') }}";
        $.easyAjax({
            url: url,
            type: "POST",
            data: {'listing_id': listingID, 'amount':amnt },
            container: "#small-dialog-10",
            success: function (response) {
                showInvoice({{  $listing->id }});
            }
        });
    }

</script>
