<div class="popup-tab-content" id="tab">
    <!-- Welcome Text -->
    <div class="padding-bottom-0">

		<div class="row">
			<div class="col-12">
				<div class="modal-main">View All Offers</div>
			</div>
		</div>
		<div class="row margin-top-5">
			<div class="col-12 center">
				<mark class="color modal-description">All offers are managed here.</mark>
			</div>
		</div>
		<div class="row margin-top-20">
			<div class="col-12 margin-bottom-10">
				<div class="modal-head">Task</div>
				<div class="modal-head-">Hang up railing throughout my home</div>
			</div>
			<div class="col-6">
				<div class="modal-head">When</div>
				<div class="modal-head-">{{ $offerDetail->date_time->format('D - dS F') }}</div>
			</div>
			<div class="col-6">
				<div class="modal-head">Time</div>
				<div class="modal-head-">{{ $offerDetail->date_time->format('H:i a') }}</div>
			</div>
		</div>
		<div class="row margin-top-10 margin-bottom-10">
			<div class="col-12">
				<div class="add-border-bottom"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="modal-head">Current offers</div>
				<div class="modal-head-">
					<div class="pure-menu pure-menu-horizontal pure-menu-scrollable simplebar-horizontal">
						<ul class="pure-menu-list center margin-bottom-0 padding-left-0">
							@forelse($offerDetail->offer as $offer)
							<li class="pure-menu-item">
								<a href="javascript:;" onclick="openOfferModal('{{ $offer->listing_id }}', '{{ $offer->user_id }}'); return false;" class="popup-with-zoom-anim pure-menu-link pure-menu-add popup-with-zoom-anim">
									<span class="user-avatar status-online"><img src="{{ $offer->user->image() }}" alt=""></span>
									<div class="pure-offers">{{ ucwords($offer->user->first_name) }}</div>
									<mark class="gray">${{ $offer->amount }}</mark>
								</a>
							</li>
							@empty
							@endforelse
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="row margin-top-20">
			<div class="col-12 margin-bottom-10">
				<div class="modal-head">Where</div>
				<div class="modal-head-">{{$offerDetail->address}}, {{$offerDetail->city}}, {{$offerDetail->state}} {{$offerDetail->zip_code}}</div>
			</div>
		</div>
        <div class="padding-bottom-0 add-border-top">
            <div class="add-border-top-">
                <div class="row">
                    <div class="col-4">
                        <div class="modal-head">Offers</div>
                        <div class="modal-head- green">{{ count($offerDetail->offer) }}</div>
                    </div>
                    <div class="col-4">
                        <div class="modal-head">Cashback</div>
                        <div class="modal-head- green cashback">${{ $totalBudget*1/100 }}</div>
                    </div>
                    <div class="col-4">
                        <div class="modal-head">Total Budget <i class="icon-feather-info" title="Includes budget plus budget increase" data-tippy-placement="top"></i></div>
                        <div class="modal-head- green total">${{ $totalBudget }}</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function openOfferModal(listing, user){

        var url = "{{ route('listing.offer-detail',[':listing', ':user_id']) }}";
        url = url.replace(':listing', listing);
        url = url.replace(':user_id', user);
        $.easyAjax({
            url: url,
            type: "GET",
            container: "#small-dialog-10",
            success: function (response) {
                $('#modalData').html(response.view)
            }
        });
    }

    var accordion = (function(){

        var $accordion = $('.js-accordion');
        var $accordion_header = $accordion.find('.js-accordion-header');

        // default settings
        var settings = {
            // animation speed
            speed: 400,

            // close all other accordion items if true
            oneOpen: false
        };

        return {
            // pass configurable object literal
            init: function($settings) {
                $accordion_header.on('click', function() {
                    accordion.toggle($(this));
                });

                $.extend(settings, $settings);

                // ensure only one accordion is active if oneOpen is true
                if(settings.oneOpen && $('.js-accordion-item.active').length > 1) {
                    $('.js-accordion-item.active:not(:first)').removeClass('active');
                }

                // reveal the active accordion bodies
                $('.js-accordion-item.active').find('> .js-accordion-body').show();
            },
            toggle: function($this) {

                if(settings.oneOpen && $this[0] != $this.closest('.js-accordion').find('> .js-accordion-item.active > .js-accordion-header')[0]) {
                    $this.closest('.js-accordion')
                        .find('> .js-accordion-item')
                        .removeClass('active')
                        .find('.js-accordion-body')
                        .slideUp();
                }

                // show/hide the clicked accordion item
                $this.closest('.js-accordion-item').toggleClass('active');
                $this.next().stop().slideToggle(settings.speed);
            }
        };
    })();
    $(document).ready(function(){
        accordion.init({ speed: 300, oneOpen: true });
        });

</script>
