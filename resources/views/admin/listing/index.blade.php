@extends('user.layouts.admin-app')

@section('style')
{{--    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">--}}
{{--    <style>--}}
{{--        input,select {--}}
{{--            max-width: unset !important;--}}
{{--            width: unset !important;--}}
{{--            display:inline-block!important;--}}
{{--        }--}}
{{--        .switch input {--}}
{{--            display: none !important;--}}
{{--        }--}}
{{--    </style>--}}
@endsection

@section('content')
    <!-- Dashboard Headline -->
    <div class="dashboard-headline">
        <h3>Manage Listings</h3>

        <!-- Breadcrumbs -->
        <nav id="breadcrumbs" class="dark">
            <ul>
                <li><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
                <li>Jobs</li>
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
                        <th>Poster</th>
                        <th>Budget</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    @forelse($jobs as $job)
                        <tr>
                            <td data-label="Listing"><a href="#">{{ $job->job_title }} <i>({{ $job->order_no }})</i> @if($job->immediate_assistance == 'required')<i class="icon-feather-radio red"></i>@endif</a></td>
                            <td data-label="Poster">{{ $job->user->full_name }}</td>
                            <td data-label="Budget">${{ $job->budgetDetails->sum('budget') }}</td>
                            <td data-label="Status">@if($job->dispute && $job->dispute->status == 'pending') In Dispute @elseif($job->status == 'accepted') Active @elseif($job->status == 'completed') Completed @else Pending @endif </td>
                            <td data-label="Actions">
                                <div class="tabs-jobs-buttons">
                                    <a href="javascript:;" onclick="openModal('{{ $job->id }}', 'small-dialog-1'); return false;" class="popup-with-zoom-anim button ripple-effect" title="Manage Listing" data-tippy-placement="top"><i class="icon-feather-folder-plus"></i></a>
                                    <a href="javascript:;" onclick="removeListing('{{ $job->id }}', 'small-dialog-6'); return false;" class="popup-with-zoom-anim button gray ripple-effect" title="Remove Listing" data-tippy-placement="top"><i class="icon-feather-x-circle"></i></a>
                                    <a href="javascript:;" onclick="contactUser('{{ $job->user->id }}')" class="popup-with-zoom-anim button gray ripple-effect" title="Contact User" data-tippy-placement="top"><i class="icon-feather-message-square"></i></a>
                                </div>
                            </td>
                        </tr>
                    @empty

                    @endforelse
                </table>

                <!-- Pagination -->
                <div class="clearfix"></div>
                <div class="pagination-container margin-top-40 margin-bottom-0">
                    {{ $jobs->links() }}
                </div>
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

    <div id="small-dialog-4" class="zoom-anim-dialog mfp-hide dialog-with-tabs"></div>


    <!-- Contact Freelancer -->
    <div id="small-dialog-6" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
        <!--Tabs -->
        <div class="sign-in-form">
            <div class="popup-tabs-container">
                <!-- Tab -->
                <div class="popup-tab-content" id="tab">
                    <!-- Welcome Text -->
                    <div class="padding-bottom-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="modal-main">Confirm Listing Removal</div>
                            </div>
                            <div class="col-12">
                                <div class="modal-head-">Are you sure you want to remove this listing?</div>
                            </div>
                        </div>
                        <input type="hidden" name="listing_id" id="listing_id" value="">
                        <div class="row margin-top-40">
                            <div class="col-6">
                                <a href="javascript:;" id="message-sent" class="popup-with-zoom-anim button gray ripple-effect" onclick="remove();return false;">Yes</a>
                            </div>
                            <div class="col-6">
                                <a href="javascript:;" id="message-sent" class="popup-with-zoom-anim button button-sliding-icon ripple-effect" onclick="closeModel(); return false;">No <i class="icon-material-outline-arrow-right-alt"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact Freelancer / End -->
@endsection

@section('footerjs')
{{--    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>--}}
    <script>
        function openModal(listing_id, popup_id) {
            $('.zoom-anim-dialog').prop('id', popup_id);
            showModal(popup_id);

            var url = "{{ route('admin.jobs.information') }}";
            $.easyAjax({
                url: url,
                type: "POST",
                container: ".basic-table",
                data: {
                    id:listing_id,
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

        function removeListing(listing_id, modal_id) {
            showModal(modal_id);
            $('#listing_id').val(listing_id);
        }

        function remove() {
            var listing = $('#listing_id').val();
            var url = "{{ route('admin.jobs.destroy', ':id') }}";
            url = url.replace(':id', listing);
            $.easyAjax({
                url: url,
                type: "DELETE",
                container: ".basic-table",
                success: function (response) {
                    window.location.reload();
                }
            });

        }

        {{--table = $('#users').DataTable({--}}
        {{--    destroy: true,--}}
        {{--    responsive: true,--}}
        {{--    processing: true,--}}
        {{--    serverSide: true,--}}
        {{--    ajax: '{!! route('admin.users.data') !!}',--}}
        {{--    "order": [[ 0, "desc" ]],--}}
        {{--    columns: [--}}
        {{--        { data: 'name', name: 'name'},--}}
        {{--        { data: 'username', name: 'username' },--}}
        {{--        { data: 'rating', name: 'rating', searchable:false, sortable:false },--}}
        {{--        { data: 'reports', name: 'reports', searchable:false, sortable:false },--}}
        {{--        { data: 'disputes', name: 'disputes', searchable:false, sortable:false },--}}
        {{--        { data: 'status', name: 'status', searchable:false, sortable:false},--}}
        {{--        { data: 'action', name: 'action', searchable:false, sortable:false }--}}
        {{--    ]--}}
        {{--});--}}
        function contactUser(user_id){
            var url = "{{ route('admin.jobs.contact-user',':id') }}";
            url = url.replace(':id', user_id);
            $.easyAjax({
                url: url,
                type: "GET",
                container: "#small-dialog-10",
                success: function (response) {
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

    </script>
@endsection
