@extends('user.layouts.app')

@section('style')
@endsection

@section('content')
    <!-- Dashboard Headline -->
    <div class="dashboard-headline">
        <h3 data-tippy-placement="top" title="Licenses must be updated every year on Jan. 1. You are responsible for insuring a valid license upon hire.">Badges
        </h3>

        <!-- Breadcrumbs -->
        <nav id="breadcrumbs" class="dark">
            <ul>
                <li><a href="{{ route('front.home') }}">Home</a></li>
                <li><a href="{{ route('user.dashboard.index') }}">Dashboard</a></li>
                <li>Badges</li>
            </ul>
        </nav>
    </div>
    <!-- Row -->
    <div class="row">

        <!-- Dashboard Box -->
        <div class="col-xl-12">
            <!-- Tabs Container -->
            <div class="tabs">
                <div class="tabs-header tabs-white tabs-bottom-border tabs-single-border pure-menu pure-menu-horizontal pure-menu-scrollable">
                    <ul class="tabs-jobs-group tabs-jobs-icons pure-menu-list">
                        <li class="active ripple-effect-dark pure-menu-item"><a href="#" data-tab-id="1"><i class="icon-feather-book-open"></i> Verification Badges</a></li>
                        <li class="ripple-effect-dark pure-menu-item"><a href="#" data-tab-id="2"><i class="icon-feather-book-open"></i> Licensed Badges</a></li>
                    </ul>
                    <div class="tab-hover"></div>
                    <nav class="tabs-nav">
                        <div class="job-listing-icon-group">
                            <span class="crate-badge job-listing-badge" title="Flate rate commission for every job completed successfully" data-tippy-placement="left">Fee: 6%</span>
                            <span class="crate-badge job-listing-badge" title="Get cashback for every job completed successfully" data-tippy-placement="left">1% Cashback</span>
                        </div>
                    </nav>
                </div>
                <!-- Tab Content -->
                <div class="tabs-content">
                    <div class="tab active" data-tab-id="1">
                        <!-- Client Jobs Active (client-active) -->
                        <div class="row">
                            @foreach($verification as $badge)
                                <div class="col-md-4 col-sm-12 margin-bottom-30">
                                    <div class="row margin-bottom-10">
                                        <div class="col-8">
                                            <div class="modal-head blue-icon badge-border"><i class="{{$badge->icon}}"></i> {{$badge->name}}</div>
                                        </div>
                                        @if(!in_array($badge->id, $user->userBadge()))
                                            <div class="col-4">
                                                <a href="javascript:;" class="popup-with-zoom-anim button dark ripple-effect button-sliding-icon bc-add full-width no-padding" onclick="openModal('{{ $badge->id }}', '{{ $badge->pop_up_id }}'); return false;"> <i class="icon-feather-arrow-right"></i></a>
                                            </div>
                                        @else
                                            <div class="col-4">
                                                <a href="#small-dialog-2" class="popup-with-zoom-anim button ripple-effect button-sliding-icon bc-added full-width no-padding" onclick="showModal('small-dialog-2'); return false;"> <i class="icon-feather-arrow-right"></i></a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-12 modal-head-">{{ $badge->description }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab active" data-tab-id="2">
                        <!-- Client Jobs Active (client-active) -->
                        <div class="row">
                            @foreach($licensed as $badge)
                                <div class="col-md-4 col-sm-12 margin-bottom-30">
                                    <div class="row margin-bottom-10">
                                        <div class="col-8">
                                            <div class="modal-head blue-icon badge-border"><i class="{{$badge->icon}}"></i> {{$badge->name}}</div>
                                        </div>
                                        @if(!in_array($badge->id, $user->userBadge()))
                                            <div class="col-4">
                                                <a href="javascript:;" class="popup-with-zoom-anim button dark ripple-effect button-sliding-icon bc-add full-width no-padding" onclick="openModal('{{ $badge->id }}', '{{ $badge->pop_up_id }}'); return false;"> <i class="icon-feather-arrow-right"></i></a>
                                            </div>
                                        @else
                                            <div class="col-4">
                                                <a href="#small-dialog-2" class="popup-with-zoom-anim button ripple-effect button-sliding-icon bc-added full-width no-padding" onclick="showModal('small-dialog-2'); return false;"> <i class="icon-feather-arrow-right"></i></a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-12 modal-head-">{{ $badge->description }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>



    </div>
    <!-- Row / End -->
    <!-- Contact Freelancer -->
    <div id="small-dialog-1" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
        <!--Tabs -->

    </div>
    <!-- Contact Freelancer / End -->
    <!-- Badge Attained Popup-->
    <div id="small-dialog-2" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
        <!--Tabs -->
        <div class="sign-in-form">
            <div class="popup-tabs-container">
                <!-- Tab -->
                <div class="popup-tab-content" id="tab">
                    <!-- Welcome Text -->
                    <div class="welcome-text">
                        <div class="breathing-icon"><i class="icon-feather-check"></i></div>
                        <h3>Congrats! Your badge is verified.</h3>
                        <h4>Apply for additional badges at anytime!</h4>
                        <!-- Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footerjs')
    <script>
        function openModal(id, popup_id) {
            $('.zoom-anim-dialog').prop('id', popup_id);
            showModal(popup_id);

            var url = "{{ route('user.get-badges') }}";
            $.easyAjax({
                url: url,
                type: "GET",
                container: "#"+popup_id,
                data: {
                    id:id,
                    popup_id:popup_id,
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
    </script>
@endsection
