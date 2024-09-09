@extends('user.layouts.admin-app')

@section('style')
@endsection

@section('content')
    <!-- Dashboard Headline -->
    <div class="dashboard-headline">
        <h3>Manage Badges</h3>

        <!-- Breadcrumbs -->
        <nav id="breadcrumbs" class="dark">
            <ul>
                <li><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
                <li>Badges</li>
            </ul>
        </nav>
    </div>

    <div class="margin-bottom-30">
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <table class="basic-table">

                    <tr>
                        <th>Username</th>
                        <th>Badge Request</th>
                        <th>Acquired Badges</th>
                        <th>Actions</th>
                    </tr>
                    @forelse($badges as $badge)
                        <tr>
                            <td data-label="Username"><a href="#">{{ $badge->first_name }} {{ $badge->last_name }}</a></td>
                            <td data-label="Badge Request"><i>{{ $badge->name }}</i></td>
                            <td data-label="Acquired Badges"><i>{{ $badge->count }}</i></td>
                            <td data-label="Actions">
                                <div class="tabs-jobs-buttons">
                                    <a href="javascript:;" class="popup-with-zoom-anim button ripple-effect" onclick="openModal('{{ $badge->userId }}','{{ $badge->badgeId }}', 'small-dialog-1')"> Verify Badge <i class="icon-feather-layers"></i></a>
                                    <a href="javascript:;" class="popup-with-zoom-anim button gray ripple-effect" title="Contact User" data-tippy-placement="top" onclick="contactUser({{ $badge->userId }})"><i class="icon-feather-message-square"></i></a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td style="text-align: center" colspan="4">No badges found!</td>
                        </tr>
                    @endforelse
                </table>

                <!-- Pagination -->
                <div class="clearfix"></div>
                {{ $badges->links() }}
                <div class="clearfix"></div>
                <!-- Pagination / End -->

            </div>
        </div>
    </div>
    <!-- Job Details - Assigned -->
    <div id="small-dialog-1" class="zoom-anim-dialog mfp-hide dialog-with-tabs">


    </div>
    <!-- Job Details - Assigned / END -->
    <!-- Contact Freelancer -->
    <div id="small-dialog-10" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
        <!--Tabs -->
        <div class="sign-in-form">
            <div class="popup-tabs-container" id="modalData">
                <!-- Tab -->
            </div>
        </div>
    </div>
    <!-- Contact Freelancer / End -->

    <div id="small-dialog-4" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

@endsection

@section('footerjs')
    <script>
        function openModal(userId, badgeId, popup_id) {
            $('.zoom-anim-dialog').prop('id', popup_id);
            showModal(popup_id);

            var url = "{{ route('admin.badges.verify') }}";
            $.easyAjax({
                url: url,
                type: "GET",
                container: ".basic-table",
                data: {
                    id:userId,
                    badgeId:badgeId,
                },
                success: function (response) {
                    $('#'+popup_id).html(response.view);
                }
            });
        }

        function showModal(popup_id){
            $.magnificPopup.open({
                type: 'inline',
                items: {
                    src: '#'+popup_id
                },
                fixedContentPos: false,
                fixedBgPos: true,

                overflowY: 'auto',

                closeBtnInside: true,
                preloader: false,

                midClick: true,
                removalDelay: 300,
                mainClass: 'my-mfp-zoom-in',
            });
        }
        function contactUser(user_id){
            var url = "{{ route('admin.badge.contact-user',':id') }}";
            url = url.replace(':id', user_id);
            $.easyAjax({
                url: url,
                type: "GET",
                container: "#small-dialog-10",
                success: function (response) {
                    console.log(response);
                    $('#modalData').html(response.view);
                    newOpenModal();
                }
            });
        }
        function newOpenModal(){
            $.magnificPopup.open({
                type: 'inline',
                items: {
                    src: '#small-dialog-10'
                },
                fixedContentPos: false,
                fixedBgPos: true,

                overflowY: 'auto',

                closeBtnInside: true,
                preloader: false,

                midClick: true,
                removalDelay: 300,
                mainClass: 'my-mfp-zoom-in',
            });
        }
        function closeModel(){
            $.magnificPopup.close();
        }

        // $('body').on('click', '.page-no-button', function(e) {
        //     e.preventDefault();
        //     var element = $(this).closest('.crate-lineup');
        //     var type = $(this).closest('.remote').data('listing-type');
        //
        //     var pageNo = $(this).data('page-no');
        //     paginationRequest(pageNo, element, type);
        // });


        {{--function paginationRequest(pageNo, element, type){--}}
        {{--    var formData = {};--}}
        {{--    $.easyAjax({--}}
        {{--        url: '{{ route('admin.badges.index') }}'+'?page='+pageNo,--}}
        {{--        type: "GET",--}}
        {{--        container: ".full-page-content-inner",--}}
        {{--        data:formData,--}}
        {{--        success: function (response) {--}}
        {{--            element.html(response.view);--}}
        {{--        }--}}
        {{--    });--}}
        {{--}--}}
    </script>
@endsection
