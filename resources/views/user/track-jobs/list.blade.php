@forelse($listings as $listing)
<div class="col-6">
    <div class="crate">
        <div class="crate-inner add-radius add-shadow add-white crate-padding crate-hover">
            <div class="row margin-bottom-15">
                <div class="col-12">
                    <div class="modal-head ellipsis">{{ $listing->job_title }}</div>
                    <div class="modal-head- blue-icon"><i class="icon-feather-user"></i> {{ $listing->user->full_name }}</div>
                    <div class="modal-head- blue-icon ellipsis"><i class="icon-feather-map-pin"></i> 8:00pm - 12:30pm (10.25.2019)</div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <span class="blog-post-date full-width center"><i class="@if($type == 'onSite')icon-feather-map-pin @else icon-feather-globe @endif"></i> Active</span>
                </div>
                <div class="col-6">
                    <a href="javascript:;" onclick="sendMessage('{{ $listing->user_id }}', '{{ $listing->id }}', 'open')" class="popup-with-zoom-anim button gray ripple-effect modal-button full-width">Contact</a>
                </div>
            </div>
        </div>
    </div>
</div>
@empty
    <div class="col-12">
        <div class="center">
            No listing found!
        </div>
    </div>
@endforelse

<div class="col-12">
    <!-- Pagination -->
    <div class="clearfix"></div>

    <div class="remote" data-listing-type="@if($type == 'onSite')onSite @else remote @endif">
        {{ $listings->links() }}
    </div>

    <div class="clearfix"></div>
    <!-- Pagination / End -->
</div>

