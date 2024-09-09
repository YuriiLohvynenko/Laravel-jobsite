<div class="popup-tab-content" id="tab">
    <div class="padding-bottom-0">
            <div class="row">
                <div class="col-12">
                    <div class="modal-main">Confirm Listing Removal</div>
                </div>
                <div class="col-12">
                    <div class="modal-head-">Are you sure you want to remove this listing?</div>
                </div>
            </div>
            <div class="row margin-top-40">
                <div class="col-6">
                    <a href="javascript:;" id="" onclick="deleteList({{$listing->id}})" class="popup-with-zoom-anim button gray ripple-effect">Yes</a>
                </div>
                <div class="col-6">
                    <a href="javascript:;" onclick="$.magnificPopup.close();" class="popup-with-zoom-anim button button-sliding-icon ripple-effect">No <i class="icon-material-outline-arrow-right-alt"></i></a>
                </div>
            </div>
        </div>
</div>