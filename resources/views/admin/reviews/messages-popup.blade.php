<div class="popup-tab-content" id="tab">
    <!-- Welcome Text -->
    <div class="padding-bottom-0">
        <div class="row">
            <div class="col-12">
                <div class="modal-main">Send Direct Message</div>
            </div>
        </div>
        <div class="row margin-top-20">
            <div class="col-12">
                <div class="submit-field">
                    <select class="selectpicker" id="userType" name="userType" title="Select user" data-size="4">
                        @if($client != 0)
                            <option value="{{ $client }}">Client Review</option>
                        @endif
                        @if($freelancer != 0)
                            <option value="{{ $freelancer }}">Freelancer Review</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <textarea name="textarea" cols="9" id="directMessage" placeholder="Message" class="with-border"></textarea>
            </div>
            <div class="col-12">
                <a href="javascript:;" id="message-sent" onclick="sendMessage()" class="popup-with-zoom-anim button button-sliding-icon ripple-effect">Send Message <i class="icon-material-outline-arrow-right-alt"></i></a>
            </div>
        </div>
    </div>
</div>
<script>
    $(".selectpicker").selectpicker();
    function sendMessage(){
        var user_id = $('#userType').val();
        var text = $('#directMessage').val();
        if (text && user_id){
            var withBRs = text.replace(/\n/g, "<br />");
            var message = '<p>' + withBRs + '</p>';
            var url = "{{ route('admin.reviews.send-message',':id') }}";
            url = url.replace(':id', user_id);
            $.easyAjax({
                url: url,
                type: "GET",
                data: {'message' : message, '_token': "{{ csrf_token() }}" },
                container: "#small-dialog-10",
                success: function (response) {
                    closeModel();
                }
            });
        }
        else{
            Snackbar.show({
                text: 'Please enter message and select user',
                pos: 'bottom-center',
                showAction: false,
                actionText: "Dismiss",
                duration: 3000,
                textColor: '#fff',
                backgroundColor: 'red'
            });
        }
    }
</script>
