<div class="modal-super- modal-badges">
    @foreach($badges as $key => $badge)
        <span class="{{ $badge->badge->icon }}" title="{{ $badge->badge->name }}" data-tippy-placement="top"></span>
    @endforeach
</div>
