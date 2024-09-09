<!-- Tab -->
<div class="popup-tab-content" id="tab">
    <!-- Welcome Text -->
    <div class="padding-bottom-0">
        <div class="row">
            <div class="col-12">
                <div class="modal-main">Resolution Center <i class="icon-feather-info" title="Freelancer responsible for any damages" data-tippy-placement="top"></i></div>
                <div class="modal-description">Let's solve this problem together.</div>
            </div>
        </div>
        <div class="row margin-top-20">
            <div class="col-6">
                <div class="modal-super">Freelancer</div>
                <div class="modal-super-">{{ $freelancer->user->first_name }} {{ $freelancer->user->last_name }}</div>
            </div>
            <div class="col-6">
                <div class="modal-super">Reason for Cancelling?</div>
                <div class="modal-super-">{{ $listing->dispute->reason }}</div>
            </div>
        </div>
        <div class="row margin-top-10">
            <div class="col-6">
                <div class="modal-super">Date Opened</div>
                <div class="modal-super-">{{ $listing->created_at->format('m.d.Y') }}</div>
            </div>
            <div class="col-6">
                <div class="modal-super">Cancellation Timer <i class="icon-feather-info" title="If freelancer is unresponsive in this time funds will be refunded" data-tippy-placement="top"></i></div>
                <div class="modal-super-">{{ $timer }}</div>
            </div>
        </div>
        <div class="row margin-top-20">
            <div class="col-12">
                <div class="modal-super">Comments</div>
            </div>
            <div class="col-12 margin-top-10 commentsqa" data-simplebar>
                @forelse($dispute->chat as $chat)
                    @if($chat->posted_by == 'client')
                        <div class="modal-super- clientqa">
                            <div class="nameqa">{{ $chat->user->first_name }} {{ $chat->user->last_name }} <span>- {{ $chat->created_at->format('m/d/Y H:m a' ) }}</span></div>
                            <div>{{ ucfirst($chat->comment) }}
                            @if($chat->image)
                                @php $images = json_decode($chat->image); @endphp
                                @forelse($images as $img)
                                    <div class="imguploads ">
                                        <img src="{{ asset('../storage/app/public/dispute-files/'.$img) }}" alt="">
                                    </div>
                                @empty
                                @endforelse
                            @endif
                            </div>
                        </div>
                    @else
                        <blockquote class="modal-super- freelancerqa">
                            <div class="nameqa"> {{ $chat->user->first_name }} {{ $chat->user->last_name }} <span>-{{ $chat->created_at->format('m/d/Y H:m a' ) }}</span></div>
                            <div>{{ ucfirst($chat->comment) }}
                                @if($chat->image)
                                    @php $images = json_decode($chat->image); @endphp
                                    @forelse($images as $img)
                                    <div class="imguploads">
                                        <img src="{{ asset('../storage/app/public/dispute-files/'.$img) }}" alt="">
                                    </div>
                                    @empty
                                    @endforelse
                                @endif
                            </div>
                        </blockquote>
                    @endif
                @empty
                @endforelse
            </div>
        </div>
        <div class="row margin-top-10">
            <div class="col-12">
                <div class="split-border"></div>
            </div>
        </div>
        <div class="margin-top-10">
            <form name="disputeDetailForm" id="disputeDetailForm">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-12 submit-field">
                        <input type="hidden" name="dispute_id" value="{{ $dispute->id }}">
                        <textarea name="text" cols="1" placeholder="Be specific and provide proof" class="with-border textareaqa"></textarea>
                    </div>
                </div>
                <div class="row margin-top-15 buttonsqa">
                    <div class="col-4">
                        <div class="uploadButton submit-field">
                            <input class="uploadButton-input" name="image[]" type="file" accept="image/*, application/pdf" id="upload" multiple/>
                            <label class="uploadButton-button ripple-effect modal-default-button" for="upload">Upload</label>
                        </div>
                    </div>
                    <div class="col-4">
                        <a href="" id="javascript:;" class="button gray ripple-effect modal-default-button" title="Once escalated final decision to be left to our team" data-tippy-placement="top">Dispute <i class="icon-feather-info modal-icon"></i></a>
                    </div>
                    <div class="col-4">
                        <a href="" id="javascript:;" onclick="submitComment(); return false;" class="button button-sliding-icon ripple-effect modal-default-button">Send <i class="icon-material-outline-arrow-right-alt"></i></a>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    function submitComment() {
        var url = "{{ route('listing.submit-bid-comment') }}";
        $.easyAjax({
            url: url,
            type: "POST",
            container: "#disputeDetailForm",
            file: true,
            success: function (response) {
                $.magnificPopup.close();
            }
        });
    }
</script>