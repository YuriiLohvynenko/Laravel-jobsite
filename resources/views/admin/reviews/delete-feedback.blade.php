<div class="popup-tab-content" id="tab">
    <!-- Welcome Text -->
    <div class="padding-bottom-0">
        <div class="row">
            <div class="col-12">
                <div class="modal-main">Confirm Review Removal</div>
            </div>
            <div class="col-12">
                <div class="modal-head-">Are you sure you want to remove this review?</div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="submit-field">
                    <select class="selectpicker" id="type" name="type" title="Select user" data-size="4">
                        <option selected value="client">Client</option>
                        <option value="freelancer">Freelancer</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row margin-top-40">
            <div class="col-6">
                <a href="" id="message-sent" onclick="deleteFeedback({{ $listingId }})" class="popup-with-zoom-anim button gray ripple-effect">Yes</a>
            </div>
            <div class="col-6">
                <a href="" id="message-sent" onclick="closeModel()" class="popup-with-zoom-anim button button-sliding-icon ripple-effect">No <i class="icon-material-outline-arrow-right-alt"></i></a>
            </div>
        </div>
    </div>
</div>
<script>
    $(".selectpicker").selectpicker();

    function deleteFeedback(listingId) {
        var type = $('#type').val();
        console.log(type);
        if(type == 'client' || type == 'freelancer'){
            var url = "{{ route('admin.reviews.delete-review', [':id', ':type']) }}";
            url = url.replace(':id', listingId);
            url = url.replace(':type', type);
            $.easyAjax({
                url: url,
                type: "GET",
                container: "#small-dialog-10",
                success: function (response) {
                    // console.log(response);
                    // $('#modalData').html(response.view);
                    closeModel();
                    document.location.reload();
                }
            });
        }
    }
    function closeModel(){
        $.magnificPopup.close();
    }
</script>
