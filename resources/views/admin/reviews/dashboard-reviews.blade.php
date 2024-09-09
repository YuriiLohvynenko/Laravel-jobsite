@extends('admin.layouts.admin-app')

@section('style')
@endsection

@section('content')
    <!-- Dashboard Headline -->
    <div class="dashboard-headline">
        <h3>Manage Reviews</h3>

        <!-- Breadcrumbs -->
        <nav id="breadcrumbs" class="dark">
            <ul>
                <li><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
                <li>Reviews</li>
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
                        <th>Client Review</th>
                        <th>Freelancer Review</th>
                        <th>Actions</th>
                    </tr>
                    @forelse($reviews as $review)
                        <tr>
                            <td data-label="Listing"><a href="#">{{ $review['order_no'] }}</a></td>
                            <td data-label="Client Review"><i>{{ $review['client_feedback'] }} - <a href="#">{{ $review['client_name'] }}</a></i></td>
                            <td data-label="Freelancer Review"><i>{{ $review['freelancer_feedback'] }} - <a href="#">{{ $review['freelancer_name'] }}</a></i></td>
                            <td data-label="Actions">
                                <div class="tabs-jobs-buttons">
                                    <a href="javascript:;" onclick="deleteFeedback({{ $review['id'] }})" class="popup-with-zoom-anim button gray ripple-effect" title="Remove Review" data-tippy-placement="top"><i class="icon-feather-x-circle"></i></a>
                                    <a href="javascript:;" onclick="contactUser('{{ $review['client_id'] ? $review['client_id'] : 0 }}', '{{ $review['freelancer_id'] ? $review['freelancer_id'] : 0 }}')" class="popup-with-zoom-anim button gray ripple-effect" title="Contact User" data-tippy-placement="top"><i class="icon-feather-message-square"></i></a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td style="text-align: center" colspan="4">No reviews found!</td>
                        </tr>
                    @endforelse

                </table>

                <!-- Pagination -->
                <div class="clearfix"></div>
                {{ $reviews->links() }}
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
        function contactUser(client_id, freelancer_id){
            var url = "{{ route('admin.reviews.contact-user', [':client_id', ':freelancer_id']) }}";
            url = url.replace(':freelancer_id', freelancer_id);
            url = url.replace(':client_id', client_id);
            console.log(url);
            $.easyAjax({
                url: url,
                type: "GET",
                container: "#small-dialog-10",
                success: function (response) {
                    console.log(response);
                    $('#modalData').html(response.view);
                    openModal();
                }
            });
        }
        function deleteFeedback(listing_id){
            var url = "{{ route('admin.reviews.delete-feedback', ':listing_id') }}";
            url = url.replace(':listing_id', listing_id);
            $.easyAjax({
                url: url,
                type: "GET",
                container: "#small-dialog-10",
                success: function (response) {
                    console.log(response);
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
