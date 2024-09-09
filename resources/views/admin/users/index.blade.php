@extends('user.layouts.admin-app')

@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <style>
        input,select {
            max-width: unset !important;
            width: unset !important;
            display:inline-block!important;
        }
        .switch input {
            display: none !important;
        }
    </style>
@endsection

@section('content')
    <!-- Dashboard Headline -->
    <div class="dashboard-headline">
        <h3>Manage Users</h3>

        <!-- Breadcrumbs -->
        <nav id="breadcrumbs" class="dark">
            <ul>
                <li><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
                <li>Users</li>
            </ul>
        </nav>
    </div>

    <div class="margin-bottom-30">
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <table class="basic-table" id="users" style="width:100%">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Rating</th>
                        <th>Reports</th>
                        <th>Disputes</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>

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

@endsection

@section('footerjs')
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
        function openModal(userId, popup_id) {
            $('.zoom-anim-dialog').prop('id', popup_id);
            showModal(popup_id);

            var url = "{{ route('admin.users.information') }}";
            $.easyAjax({
                url: url,
                type: "POST",
                container: ".basic-table",
                data: {
                    id:userId,
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

        table = $('#users').DataTable({
            destroy: true,
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: '{!! route('admin.users.data') !!}',
            "order": [[ 0, "desc" ]],
            columns: [
                { data: 'name', name: 'name'},
                { data: 'username', name: 'username' },
                { data: 'rating', name: 'rating', searchable:false, sortable:false },
                { data: 'reports', name: 'reports', searchable:false, sortable:false },
                { data: 'disputes', name: 'disputes', searchable:false, sortable:false },
                { data: 'status', name: 'status', searchable:false, sortable:false},
                { data: 'action', name: 'action', searchable:false, sortable:false }
            ]
        });
        function contactUser(user_id){
            var url = "{{ route('admin.users.contact-user',':id') }}";
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
