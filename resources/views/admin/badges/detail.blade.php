<div class="sign-in-form">
        <div class="popup-tabs-container">
            <!-- Tab -->
            <div class="popup-tab-content" id="tab">
                <!-- Welcome Text -->
                <div class="padding-bottom-0">
                    <div class="row margin-bottom-20">
                        <div class="col-12">
                            <div class="modal-main">Badge Verification</div>
                        </div>
                        <div class="col-12">
                            <div class="modal-head-">Verify submitted badge information</div>
                        </div>
                    </div>
                    <div class="row margin-bottom-10">
                        <div class="col-6">
                            <div class="modal-head">Name</div>
                            <div class="modal-head-">{{ $badge->user->full_name }}</div>
                        </div>
                        <div class="col-6">
                            <div class="modal-head">Submitted Badge</div>
                            <div class="modal-head-">{{ $badge->badge->name }}</div>
                        </div>
                    </div>
                    <div class="row margin-bottom-10">
                        <div class="col-12">
                            <div class="modal-head">Email</div>
                            <div class="modal-head-">{{ $badge->user->email }}</div>
                        </div>
                    </div>
                    <div class="row margin-bottom-20">
                        <div class="col-6">
                            <div class="modal-head">Job Title</div>
                            <div class="modal-head-">{{ $badge->job_title ? $badge->job_title : '-' }}</div>
                        </div>
                        <div class="col-6">
                            <div class="modal-head">Document Provided</div>
                            <div class="modal-head-">{{ $badge->document_type ? $badge->document_type : '-' }}</div>
                        </div>
                    </div>
                    @if(!is_null($badge->file))
                        <div class="row margin-bottom-10">
                            <div class="col-12">
                                <div class="modal-head margin-bottom-5">Submitted Documents <i class="icon-feather-info" title="This will also change on your profile" data-tippy-placement="top"></i></div>
                            </div>
                            <div class="col-12">
                                <div class="col-12 my-gallery" itemscope itemtype="{{ $badge->documentUrl() }}">
                                    <figure itemprop="associatedMedia" itemscope itemtype="{{ $badge->documentUrl() }}">
                                        <a href="{{ $badge->documentUrl() }}" target="_blank" itemprop="contentUrl" data-size="1024x1024">
                                            <div class="photoswipe-container"><img src="{{ $badge->documentUrl() }}" /></div>
                                        </a>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row margin-bottom-30">
                        <div class="col-12">
                            <div class="modal-head">License #</div>
                            <div class="modal-head-">{{ $badge->license_no ? $badge->license_no : '-' }}</div>
                        </div>
                        <div class="col-12">
                            <div class="modal-head">Additional License Info</div>
                            <div class="modal-head-">{{ $badge->description ? $badge->description : '-' }}</div>
                        </div>
                    </div>
                    <div class="row margin-bottom-10">
                        <div class="col-6">
                            <a href="javascript:;" onclick="reject();return false;" class="popup-with-zoom-anim button gray ripple-effect modal-button-nomargin">Deny</a>
                        </div>
                        <div class="col-6">
                            <a href="javascript:;" id="approve" onclick="approve();return false;" class="popup-with-zoom-anim button button-sliding-icon ripple-effect modal-button-nomargin">Approve <i class="icon-material-outline-arrow-right-alt"></i></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <a href="javascript:;" onclick="openModal('{{ $badge->user->id }}','{{ $badge->id }}', 'small-dialog-1')" class="popup-with-zoom-anim button-sliding-icon ripple-effect modal-button"><i class="icon-feather-arrow-left"></i> Return to job details</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    function approve()
    {
        var url = "{{ route('admin.badges.approve') }}";
        $.easyAjax({
            url: url,
            type: "POST",
            container: ".popup-tab-content",
            data: {
                badgeId:'{{ $badge->id }}',
            },
            success: function (response) {
                $('#small-dialog-1').html(response.view);
            }
        });
    }

    function reject()
    {
        var url = "{{ route('admin.badges.reject') }}";
        $.easyAjax({
            url: url,
            type: "POST",
            container: ".popup-tab-content",
            data: {
                badgeId:'{{ $badge->id }}',
            },
            success: function (response) {
                $('#small-dialog-1').html(response.view);
            }
        });
    }
</script>
