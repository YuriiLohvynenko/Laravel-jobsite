@extends('admin.layouts.admin-app')

@section('style')
@endsection

@section('content')
    <!-- Dashboard Headline -->
    <div class="dashboard-headline">
        <h3>Resolution Center</h3>

        <!-- Breadcrumbs -->
        <nav id="breadcrumbs" class="dark">
            <ul>
                <li><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
                <li>Resolution Center</li>
            </ul>
        </nav>
    </div>

    <div class="margin-bottom-30">
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <table class="basic-table">

                    <tr>
                        <th>Listing</th>
                        <th>Client</th>
                        <th>Freelancer</th>
                        <th>Reason</th>
                        <th>Actions</th>
                    </tr>

                    @forelse($messageList as $list)
                        <tr>
                            <td data-label="Listing">{{ $list['listing_id'] }}</td>
                            <td data-label="Client">{{ $list['client'] }}</td>
                            <td data-label="Freelancer">{{ $list['freelancer'] }}</td>
                            <td data-label="Reason">{{ $list['reson'] }}</td>
                            <td data-label="Actions">
                                <div class="tabs-jobs-buttons">
                                    <a href="javascript:;" onclick="viewThread({{ $list['thread_id'] }})" class="popup-with-zoom-anim button ripple-effect" title="View Profile" data-tippy-placement="top">View Thread <i class="icon-feather-download-cloud"></i></a>
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td style="text-align: center" colspan="4">No disputes found!</td>
                            </tr>
                    @endforelse


                </table>

                <!-- Pagination -->
                <div class="clearfix"></div>
{{--                {{ $reviews->links() }}--}}
                <div class="clearfix"></div>
                <!-- Pagination / End -->

            </div>
        </div>
    </div>


    <!-- Footer -->
    <div class="dashboard-footer-spacer"></div>
    <div class="small-footer margin-top-15">
        <div class="small-footer-copyrights">
            © 2019 <strong>Hireo</strong>. All Rights Reserved.
        </div>
        <ul class="footer-social-links">
            <li>
                <a href="#" title="Facebook" data-tippy-placement="top">
                    <i class="icon-brand-facebook-f"></i>
                </a>
            </li>
            <li>
                <a href="#" title="Twitter" data-tippy-placement="top">
                    <i class="icon-brand-twitter"></i>
                </a>
            </li>
            <li>
                <a href="#" title="Google Plus" data-tippy-placement="top">
                    <i class="icon-brand-google-plus-g"></i>
                </a>
            </li>
            <li>
                <a href="#" title="LinkedIn" data-tippy-placement="top">
                    <i class="icon-brand-linkedin-in"></i>
                </a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <!-- Footer / End -->
    <div id="small-dialog-10" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
        <!--Tabs -->
        <div class="sign-in-form">
            <div class="popup-tabs-container" id="modalData">
                <!-- Tab -->
            </div>
        </div>
    </div>
@endsection

@section('footerjs')
    <!-- Snackbar // documentation: https://www.polonel.com/snackbar/ -->

    <script>
        function viewThread(thread_id){
            var url = "{{ route('admin.dispute.showThread', ':thread_id') }}";
            url = url.replace(':thread_id', thread_id);
            $.easyAjax({
                url: url,
                type: "GET",
                container: "#small-dialog-10",
                success: function (response) {
                    $('#modalData').html(response.view);
                    openModal();
                }
            });
        }
        function openModal(){
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

    </script>
@endsection
