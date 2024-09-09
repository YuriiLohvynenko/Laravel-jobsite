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
            <div class="col-12 submit-field">
                <div class="bidding-field ">
                    <!-- Quantity Buttons -->
                    <div class="qtyButtons">
                        <div class="qtyDec"></div>
                        <input type="text"  name="amount" id="amount" value="{{ $offer->amount }}">
                        <input type="hidden" name="offer_id" value="{{ $offer->id }}" id="offer_id">
                        <div class="qtyInc"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row margin-top-20">
            <div class="col-6">
                <a href="javascript:;" onclick="withdrowOffer({{ $offer->listing_id }})" id="send-tip" class="button  gray ripple-effect">Withdraw Offer</a>
            </div>
            <div class="col-6">
                <a href="javascript:;" onclick="submitOffer()" id="send-tip" class="button button-sliding-icon ripple-effect">Send Offer <i class="icon-material-outline-arrow-right-alt"></i></a>
            </div>
        </div>
    </div>
</div>

<script>
    function withdrowOffer(id){
        var url = "{{ route('listing.withdraw-offer',':id') }}";
        url = url.replace(':id', id);
        $.easyAjax({
            url: url,
            type: "GET",
            container: ".tabs-content",
            success: function (response) {
                $('#listingRow'+id).remove();
                $.magnificPopup.close();
            }
        });
    }
    function submitOffer() {
        var amount = $('#amount').val();
        var offer_id = $('#offer_id').val();
        var url = "{{ route('listing.submit-offer') }}";
        $.easyAjax({
            url: url,
            type: "POST",
            container: "#small-dialog-10",
            data: {'amount' : amount, 'offer_id' : offer_id, '_token': "{{ csrf_token() }}" },
            success: function (response) {
                $.magnificPopup.close();
            }
        });
    }
</script>