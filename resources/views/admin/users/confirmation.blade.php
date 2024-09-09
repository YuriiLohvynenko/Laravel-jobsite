<div class="sign-in-form">
    <div class="popup-tabs-container">
        <!-- Tab -->
        <div class="popup-tab-content" id="tab">
            <!-- Welcome Text -->
            <div class="padding-bottom-0">
                <div class="row">
                    <div class="col-12">
                        <div class="modal-main">Badge Removal Confirmation <i class="icon-feather-info" title="Listings automatically move to completed when final job is done" data-tippy-placement="top"></i></div>
                    </div>
                    <div class="col-12 margin-bottom-10">
                        <div class="modal-head-">Are you sure you want to remove this badge? Once removed, users must reapply to receive another</div>
                    </div>
                </div>
                <div class="row margin-top-40">
                    <div class="col-6">
                        <a href="javascript:;" id="" class="popup-with-zoom-anim button gray ripple-effect"  onclick="openModal('{{$badge->user->id}}', 'small-dialog-1');return false;">Cancel</a>
                    </div>

                    <div class="col-6">
                        <a href="javascript:;" id="message-sent"  onclick="badgeRemove('{{$badge->user->id}}');return false;" class="popup-with-zoom-anim button button-sliding-icon ripple-effect">Confirm Removal <i class="icon-material-outline-arrow-right-alt"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function badgeRemove()
{
    var url = "{{ route('admin.badges.remove') }}";
    $.easyAjax({
        url: url,
        type: "POST",
        container: ".popup-tab-content",
        data: {
            badgeId:'{{$badge->id}}',
        },
        success: function (response) {
            $.magnificPopup.close();
        }
    });
}
</script>
