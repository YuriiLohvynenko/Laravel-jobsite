<script src="{{ asset('js/photoswipe.min.js') }}"></script>
<script src="{{ asset('js/photoswipe-ui-default.min.js') }}"></script>
<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/jquery-migrate-3.0.0.min.js') }}"></script>
<script src="{{ asset('js/mmenu.min.js') }}"></script>
<script src="{{ asset('js/tippy.all.min.js') }}"></script>
<script src="{{ asset('js/simplebar.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-slider.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/snackbar.js') }}"></script>
<script src="{{ asset('js/clipboard.min.js') }}"></script>
<script src="{{ asset('js/counterup.min.js') }}"></script>
<script src="{{ asset('js/magnific-popup.min.js') }}"></script>
<script src="{{ asset('js/slick.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{ asset('js/datepicker.min.js') }}"></script>
<script src="{{ asset('js/datepicker.en.js') }}"></script>
<script src="{{ asset('js/chart.min.js') }}"></script>
<script src="{{ asset('plugins/helper/helper.js') }}"></script>
<script src="{{ asset('js/share.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.mark-as-read').click(function () {
        var url = "{{ route('admin.messages.readAllUnread',[':id']) }}";
        url = url.replace(':id', {{ $user->id }});
        $.easyAjax({
            url: url,
            type: "GET",
            container: "#small-dialog-10",
            success: function (response) {
                $('span.unreadMessageCount').text(0);
            }
        });
    });
    $('.status-switch label.user-invisible').on('click', function(){
        var status = '0';
        var url = "{{ route('user.message.update-status',[':status']) }}";
        url = url.replace(':status', status);
        $.ajax({
            url: url,
            type: "GET",
            container: ".user-details",
        });
        $('.status-indicator').addClass('right');
        $('.status-switch label').removeClass('current-status');
        $('.user-invisible').addClass('current-status');
        $('.user-avatar').toggleClass('status-online');
    });

    $('.status-switch label.user-online').on('click', function(){
        var status = '1';
        var url = "{{ route('user.message.update-status',[':status']) }}";
        url = url.replace(':status', status);
        $.ajax({
            url: url,
            type: "GET",
            container: ".user-details",
        });
        $('.status-indicator').removeClass('right');
        $('.status-switch label').removeClass('current-status');
        $('.user-online').addClass('current-status');
        $('.user-avatar').toggleClass('status-online');
    });
</script>
@yield('footerjs')
