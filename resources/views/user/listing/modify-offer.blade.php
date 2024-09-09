<div class="popup-tab-content" id="tab">
    <!-- Welcome Text -->
    <div class="padding-bottom-0">

        <div class="row">
            <div class="col-12">
                <div class="modal-main">Modify Offer</div>
            </div>
        </div>
        <div class="row margin-top-10">
            <div class="col-12">
                <div class="modal-description">Review and edit current offer below</div>
            </div>
        </div>
        <div class="row margin-top-20">
            <div class="col-12">
                <div class="bidding-field">
                    <!-- Quantity Buttons -->
                    <div class="qtyButtons">
                        <div class="qtyDec"></div>
                        <input type="text" name="qtyInput" value="528">
                        <div class="qtyInc"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row margin-top-20">
            <div class="col-6">
                <a href="" id="send-tip" class="button  gray ripple-effect">Withdraw Offer</i></a>
            </div>
            <div class="col-6">
                <a href="" id="send-tip" class="button button-sliding-icon ripple-effect">Send Offer <i class="icon-material-outline-arrow-right-alt"></i></a>
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

    function acceptOffer(id) {
        var url = "{{ route('listing.accept-offer',':id') }}";
        url = url.replace(':id', id);
        $.easyAjax({
            url: url,
            type: "GET",
            container: "#small-dialog-10",
            success: function (response) {
                viewOffer(listingId, totalListingOffer);
            }
        });
    }
</script>
