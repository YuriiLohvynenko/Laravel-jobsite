<div class="popup-tab-content" id="tab">
    <!-- Welcome Text -->
    <div class="padding-bottom-0">

        <div class="row">
            <div class="col-12">
                <div class="modal-main">Counter Offer</div>
            </div>
        </div>
        <div class="row margin-top-20">
            <div class="col-12 submit-field">
                <div class="bidding-field ">
                    <!-- Quantity Buttons -->
                    <div class="qtyButtons">
                        <input type="text"  name="amount" id="amount" value="{{ $offer->amount }}" readonly>
                        <input type="hidden" name="offer_id" value="{{ $offer->id }}" id="offer_id">
                    </div>
                </div>
            </div>
        </div>
        <div class="row margin-top-20">
            <div class="col-6">
                <a href="javascript:;" onclick="declineOffer({{ $offer->id }})" id="send-tip" class="button  gray ripple-effect">Decline Offer</a>
            </div>
            <div class="col-6">
                <a href="javascript:;" onclick="acceptOffer({{ $offer->id }})" id="send-tip" class="button button-sliding-icon ripple-effect">Accept Offer <i class="icon-material-outline-arrow-right-alt"></i></a>
            </div>
        </div>
    </div>
</div>

<script>
    function acceptOffer(id){
        var url = "{{ route('listing.accept-offer',':id') }}";
        url = url.replace(':id', id);
        $.easyAjax({
            url: url,
            type: "GET",
            container: ".tabs-content",
            success: function (response) {
                // $('#listingRow'+id).remove();
                $.magnificPopup.close();
            }
        });
    }
    function declineOffer(id) {
        var url = "{{ route('listing.decline-offer',':id') }}";
        url = url.replace(':id', id);
        $.easyAjax({
            url: url,
            type: "POST",
            container: "#small-dialog-10",
            success: function (response) {
                $.magnificPopup.close();
            }
        });
    }
</script>
