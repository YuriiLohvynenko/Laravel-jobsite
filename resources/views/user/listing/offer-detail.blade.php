<div class="popup-tab-content" id="tab">
    <!-- Welcome Text -->
    <div class="padding-bottom-0">

        <div class="row">
			<div class="col-12">
				<div class="modal-main">Review Offer</div>
			</div>
		</div>
		
		<div class="row margin-top-30">
			<div class="col-6">
				<div class="center margin-top-16">
					<span class="user-avatar user-avatar-60 status-online"><img src="images/user-avatar-small-03.jpg" alt=""></span>
				</div>
			</div>
			<div class="col-6">
				<div class="modal-head">
				<div>{{ $offer->user->full_name }}</div>
				<span class="star-rating margin-top-5" data-rating="5.0"></span>
				<span class="star-rating margin-top-5" data-rating="5.0"></span>
				<div>Cleveland, Ohio</div>
				</div>
			</div>
			<div class="col-12 margin-top-20 margin-bottom-20 center">
				<div class="bid-acceptance">${{ $offer->amount }}</div>
			</div>
			<div class="col-12">
				<div class="modal-head">Current badges</div>
				<div class="modal-head-">
					<div class="pure-menu pure-menu-horizontal pure-menu-scrollable">
						<ul class="pure-menu-list pure-space padding-left-0">
							@if($offer->user->badge->count() > 0)
								@badge(['badges' => $offer->user->badge]) @endbadge
							@else
							<div>No badges available</div>
							@endif
						</ul>
					</div>
				</div>
			</div>
			<div class="col-12">
				<div class="modal-head">Offer description</div>
				<div class="modal-head-">{{ $offer->description }}</div>
			</div>
		</div>
		
        <div class="margin-top-50">
		@if($offer->status == 'pending')
            <ul class="row modal-data-tabs" data-tabs>
				<li class="col-4">
                    <a href="#accept-offer" class="button button-sliding-icon ripple-effect modal-button">Accept</a>
                </li>
                <li class="col-4">
                    <a href="#decline-offer" class="button dark button-sliding-icon ripple-effect modal-button">Decline</a>
                </li>
                <li class="col-4">
                    <a href="#counter-offer" class="">go back</a>
                </li>
            </ul>
			
            <div class="modal-active"></div>
            <div class="row modal-data-content">
                <div class="col-12">
                    <div id="accept-offer" class="row">
                        <div class="col-12">Are you sure you want to accept this offer?</div>
                        <div class="col-2"><a id="offer-accepted" href="javascript:;" onclick="acceptOffer('{{ $offer->id }}')" class="popup-with-zoom-anim">Yes</a></div>
                        <div class="col-2"><a href="#small-dialog-10" class="popup-with-zoom-anim">No</a></div>
                    </div>
                </div>
                <div id="counter-offer" class="full-width">
                    <div class="col-12">
                        <div>
                            <div class="margin-bottom-10">Enter your counter offer below</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="bidding-field">
                            <!-- Quantity Buttons -->
                            <div class="qtyButtons">
                                <div class="qtyDec"></div>
                                <input type="text" name="qtyInput" value="1" id="counterAmount">
                                <div class="qtyInc"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 margin-top-10">
                        <a href="javascript:;" onclick="counterOffer('{{ $offer->listing_id }}', '{{ $offer->id }}');" id="send-counter" class="popup-with-zoom-anim button button-sliding-icon ripple-effect modal-button">Send Offer <i class="icon-material-outline-arrow-right-alt"></i></a>
                    </div>
                </div>
                <div class="col-12">
                    <div id="decline-offer" class="row">
                        <div class="col-12">Are you sure you want to decline this offer?</div>
                        <div class="col-2"><a id="offer-declined" onclick="declineOffer('{{ $offer->id }}')" href="javascript:;" class="popup-with-zoom-anim">Yes</a></div>
                        <div class="col-2"><a href="javascript:;" onclick="closeModel()" class="popup-with-zoom-anim">No</a></div> <!-- Reload page when "No" is selected -->
                    </div>
                </div>
            </div>
			@endif
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
});

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
    function declineOffer(id) {
    var url = "{{ route('listing.decline-offer',':id') }}";
    url = url.replace(':id', id);
    $.easyAjax({
        url: url,
        type: "GET",
        container: "#small-dialog-10",
        success: function (response) {
            window.location.reload();
        }
    });
}
function counterOffer(listingId, offerId){
    var amount = $('#counterAmount').val();
    $.easyAjax({
        url: "{!! route('list.count-offer') !!}",
        type: "POST",
        container: "#sendOfferForm",
        data: {'listingID' : listingId, 'offerID' : offerId, 'amount' : amount, 'description' : '', '_token': "{{ csrf_token() }}" },
        success: function (response) {
            if(response.status == 'success') {
                Snackbar.show({
                    text: 'Your bid has been placed!'
                });
                $.magnificPopup.close();
                window.location.reload();
            }
        }
    });
}
</script>
