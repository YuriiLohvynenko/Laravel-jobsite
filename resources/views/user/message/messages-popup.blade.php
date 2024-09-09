<div class="popup-tab-content" id="tab">
    <!-- Welcome Text -->
    <div class="padding-bottom-0">
        <div class="row">
            <div class="col-12">
                <div class="modal-main">Send Direct Message</div>
            </div>
            <div class="col-12">
                <div class="modal-head-">{{ ucfirst($toUserName) }}</div>
            </div>
        </div>
        <div class="row margin-top-40">
            <div class="col-12">
                <textarea name="textarea" cols="9" id="directMessage" placeholder="Message" class="with-border"></textarea>
            </div>
            <div class="col-12">
                <a href="javascript:;" onclick="sendMessage('{{ $toUserId }}', '{{ $listingId }}', 'send')" id="message-sent" class="popup-with-zoom-anim button button-sliding-icon ripple-effect">Send Message <i class="icon-material-outline-arrow-right-alt"></i></a>
            </div>
        </div>
    </div>
</div>
