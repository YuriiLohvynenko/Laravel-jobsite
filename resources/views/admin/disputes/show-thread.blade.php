<div class="popup-tab-content" id="tab">

    <!-- Welcome Text -->
    <div class="padding-bottom-0">

        <div class="row">
            <div class="col-12">
                <div class="modal-main">Disputes</div>
                <div class="modal-description">Visit the jobs page to release full or partial refunds if in favor of the freelancer</div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
            </div>
        </div>

        <div class="row margin-top-20">
            <div class="col-6">
                <div class="modal-head">Date Created <i class="icon-feather-info" title="View Timesheet and Milestones below" data-tippy-placement="top"></i></div>
                <div class="modal-head-">{{ $messages->first()->created_at->format('m-d-Y') }}</div>
            </div>
            <div class="col-6">
                <div class="modal-head"># of Reported Threads</div>
                <div class="modal-head- green">0</div>
            </div>
        </div>

        <div class="margin-top-10">
            <div class="row">
                <div class="col-6">
                    <div class="modal-head">Client</div>
                    <div class="modal-head-"><a href="{{ route('user.profile.show', $thread->listing->user->id) }}">{{ $thread->listing->user->first_name. ' ' .$thread->listing->user->last_name. ' ('. $thread->listing->user->username.')' }}</a></div>
                </div>
                <div class="col-6">
                    <div class="modal-head">Freelancer</div>
                    <div class="modal-head-"><a href="{{ route('user.profile.show', $thread->user_id == $thread->listing->user_id ? $thread->touser->id : $thread->fromuser->id) }}">{{ $thread->user_id == $thread->listing->user_id ? $thread->touser->first_name .' '. $thread->touser->last_name. ' ('. $thread->touser->username.')' : $thread->fromuser->first_name.' '.$thread->fromuser->last_name. ' ('. $thread->fromuser->username.')' }}</a></div>
                </div>
            </div>
        </div>

        <div class="margin-top-10">

            <div class="js-accordion">
                <div class="js-accordion-item">
                    <div class="accordion-custom-btn js-accordion-header">View All Messages <i class="icon-feather-plus"></i></div>

                    <div class="row-group accordion-body js-accordion-body">
                        <div class="margin-top-10 margin-bottom-40">
                            <div class="row margin-top-20">
                                <div class="col-12">
                                    <div class="modal-super">Messages</div>
                                </div>
                                <div class="col-12 margin-top-10 commentsqa" data-simplebar>
                                    @foreach($messages as $message)
                                        @if($message->user_id == $adminUser->id)
                                            <div class="modal-super- clientqa">
                                                <div class="nameqa">Customer Service <span>- {{ $message->created_at->format('m/d/Y h:i A') }}</span></div>
                                                <div>{!! $message->message !!}</div>
                                            </div>
                                        @elseif($message->user_id == $thread->listing->user_id)
                                            <div class="modal-super- clientqa">
                                                <div class="nameqa">{{ $thread->listing->user->first_name . ' ' . $thread->listing->user->last_name }} <span>- {{ $message->created_at->format('m/d/Y h:i A') }}</span></div>
                                                <div>{!! $message->message !!}</div>
                                            </div>
                                        @else
                                            <blockquote class="modal-super- freelancerqa">
                                                <div class="nameqa">{{ $message->fromuser->first_name . ' ' . $message->fromuser->last_name }} <span>- {{ $message->created_at->format('m/d/Y h:i A') }}</span></div>
                                                <div>{!! $message->message !!}</div>
                                            </blockquote>
                                        @endif
                                    @endforeach

{{--                                    <blockquote class="modal-super- freelancerqa">--}}
{{--                                        <div class="nameqa">David <span>- 6/19/2019 6:33am</span></div>--}}
{{--                                        <div>Here are several photos.--}}
{{--                                            <div class="imguploads">--}}
{{--                                                <img src="images/user-avatar-small-03.jpg" alt="">--}}
{{--                                                <img src="images/user-avatar-small-03.jpg" alt="">--}}
{{--                                                <img src="images/user-avatar-small-03.jpg" alt="">--}}
{{--                                                <img src="images/user-avatar-small-03.jpg" alt="">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </blockquote>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row margin-top-10">
                        <div class="col-12">
                            <div class="split-border"></div>
                        </div>
                    </div>
                    <div class="margin-top-10">
                        <div class="row">
                            <div class="col-12">
                                <textarea id="directMessage" name="textarea" cols="1" placeholder="Leave a message" class="with-border textareaqa"></textarea>
                            </div>
                        </div>
                        <div class="row margin-top-15 buttonsqa">
                            <div class="col-4">
                                <div class="uploadButton">
                                    <input class="uploadButton-input" type="file" accept="image/*, application/pdf" id="upload" multiple/>
                                    <label class="uploadButton-button ripple-effect modal-default-button" for="upload">Upload</label>
                                </div>
                            </div>
                            <div class="col-4">
                                @if($thread->chat_status == 'enable')
                                    <a href="javascript:;" onclick="disableChat({{ $thread->id }})" id="feedback-left" class="button gray ripple-effect modal-default-button" title="Disables chat" data-tippy-placement="top">Disable <i class="icon-feather-info modal-icon"></i></a>
                                @else
                                    <a href="javascript:;" onclick="enableChat({{ $thread->id }})" id="feedback-left" class="button gray ripple-effect modal-default-button" title="Enables chat" data-tippy-placement="top">Enable <i class="icon-feather-info modal-icon"></i></a>
                                @endif
                            </div>
                            <div class="col-4">
                                <a href="javascript:;" onclick="sendMessage({{ $thread->id }})" id="feedback-left" class="button button-sliding-icon ripple-effect modal-default-button">Send <i class="icon-material-outline-arrow-right-alt"></i></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>

<script>
    function disableChat(id){
        var url = "{{ route('admin.dispute.changeStatus', [':status', ':id']) }}";
        url = url.replace(':status', 'disable');
        url = url.replace(':id', id);
        $.easyAjax({
            url: url,
            type: "GET",
            container: "#small-dialog-10",
            success: function (response) {
                closeModel()
            }
        });
    }
    function enableChat(id) {
        var url = "{{ route('admin.dispute.changeStatus', [':status', ':id']) }}";
        url = url.replace(':status', 'enable');
        url = url.replace(':id', id);
        $.easyAjax({
            url: url,
            type: "GET",
            container: "#small-dialog-10",
            success: function (response) {
                closeModel()
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
    function sendMessage(id){
        var text = $('#directMessage').val();
        if (text){
            var withBRs = text.replace(/\n/g, "<br />");
            var message = '<p>' + withBRs + '</p>';
            var url = "{{ route('admin.messages.send-message',':id') }}";
            url = url.replace(':id', id);
            $.easyAjax({
                url: url,
                type: "GET",
                data: {'message' : message, 'oldThread': id, '_token': "{{ csrf_token() }}" },
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
