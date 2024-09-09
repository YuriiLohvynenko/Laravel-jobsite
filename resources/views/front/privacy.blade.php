@extends('front.layout.front-app')
@push('style')

@endpush
@section('content')

    <div class="single-page-header">
        <div class="container">
            <div class="">
                <h2>Privacy Policy <i class="icon-feather-life-buoy"></i></h2>
            </div>
        </div>
    </div>

    <!-- Page Content
    ================================================== -->
    <div class="container">
        <div class="row">
            <div class="col-xl-7">

                <section id="contact" class="margin-bottom-60">
                    <div class="article" id="content">
                        <div id="placeholders">

                            <h2>Privacy Policy for <span class="highlight preview_company_name">Company Name</span></h2>

                            <p>At <span class="highlight preview_website_name">Website Name</span>, accessible at <span class="highlight preview_website_url">Website.com</span>, one of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that is collected and recorded by <span class="highlight preview_website_name">Website Name</span> and how we use it.</p>

                            <p>If you have additional questions or require more information about our Privacy Policy, do not hesitate to contact us through email at <span class="highlight preview_email_address">Email@Website.com</span></p>

                            <p><strong>Log Files</strong></p>

                            <p><span class="highlight preview_website_name">Website Name</span> follows a standard procedure of using log files. These files log visitors when they visit websites. All hosting companies do this and a part of hosting services' analytics. The information collected by log files include internet protocol (IP) addresses, browser type, Internet Service Provider (ISP), date and time stamp, referring/exit pages, and possibly the number of clicks. These are not linked to any information that is personally identifiable. The purpose of the information is for analyzing trends, administering the site, tracking users' movement on the website, and gathering demographic information.</p>

                            <h3>Cookies and Web Beacons</h3>
                            <p>Like any other website, <span class="highlight preview_website_name">Website Name</span> uses ‘cookies'. These cookies are used to store information including visitors' preferences, and the pages on the website that the visitor accessed or visited. The information is used to optimize the users' experience by customizing our web page content based on visitors' browser type and/or other information.</p>

                            <h3>DoubleClick DART Cookie</h3>

                            <p>Google is one of a third-party vendor on our site. It also uses cookies, known as DART cookies, to serve ads to our site visitors based upon their visit to www.website.com and other sites on the internet. However, visitors may choose to decline the use of DART cookies by visiting the Google ad and content network Privacy Policy at the following URL – <a href="https://policies.google.com/technologies/ads" target="_blank">https://policies.google.com/technologies/ads</a>.</p>

                            <p>Some of advertisers on our site may use cookies and web beacons. Our advertising partners are listed below. Each of our advertising partners has their own Privacy Policy for their policies on user data. For easier access, we hyperlinked to their Privacy Policies below.</p>

                            <ul>
                                <li>
                                    <p>Google</p>
                                    <p><a href="https://policies.google.com/technologies/ads">https://policies.google.com/technologies/ads</a></p>
                                </li>
                            </ul>

                            <p><strong>Privacy Policies</strong></p>

                            <p>You may consult this list to find the Privacy Policy for each of the advertising partners of <span class="highlight preview_website_name">Website Name</span>.</p>

                            <p>Third-party ad servers or ad networks uses technologies like cookies, JavaScript, or Web Beacons that are used in their respective advertisements and links that appear on <span class="highlight preview_website_name">Website Name</span>, which are sent directly to users' browser. They automatically receive your IP address when this occurs. These technologies are used to measure the effectiveness of their advertising campaigns and/or to personalize the advertising content that you see on websites that you visit.</p>

                            <p>Note that <span class="highlight preview_website_name">Website Name</span> has no access to or control over these cookies that are used by third-party advertisers.</p>

                            <p><strong>Third Part Privacy Policies</strong></p>

                            <p><span class="highlight preview_website_name">Website Name</span>'s Privacy Policy does not apply to other advertisers or websites. Thus, we are advising you to consult the respective Privacy Policies of these third-party ad servers for more detailed information. It may include their practices and instructions about how to opt-out of certain options. You may find a complete list of these Privacy Policies and their links here: Privacy Policy Links.</p>

                            <p>You can choose to disable cookies through your individual browser options. To know more detailed information about cookie management with specific web browsers, it can be found at the browsers' respective websites. What Are Cookies?</p>

                            <p><strong>Children's Information</strong></p>

                            <p>Another part of our priority is adding protection for children while using the internet. We encourage parents and guardians to observe, participate in, and/or monitor and guide their online activity.</p>

                            <p><span class="highlight preview_website_name">Website Name</span> does not knowingly collect any Personal Identifiable Information from children under the age of 13. If you think that your child provided this kind of information on our website, we strongly encourage you to contact us immediately and we will do our best efforts to promptly remove such information from our records.</p>

                            <p><strong>Online Privacy Policy Only</strong></p>

                            <p>This privacy policy applies only to our online activities and is valid for visitors to our website with regards to the information that they shared and/or collect in <span class="highlight preview_website_name">Website Name</span>. This policy is not applicable to any information collected offline or via channels other than this website.</p>

                            <p><strong>Consent</strong></p>

                            <p>By using our website, you hereby consent to our Privacy Policy and agree to its Terms and Conditions.</p>


                        </div>
                    </div>
                </section>
            </div>

            <div class="col-xl-5">

                <div class="row">
                    <div class="col-12"></div>
                </div>

            </div>
        </div>
    </div>


    <!-- Spacer -->
    <div class="margin-top-70"></div>
    <!-- Spacer / End-->
@endsection

@section('footerjs')
<script>
    function contact(){
        $.easyAjax({
            url: "{{ route('front.contact.store') }}",
            type: "POST",
            data: $("#contactform").serialize(),
            container: "#contact",
            messagePosition: 'inline',
            success: function (response) {
                if(response.status == 'success') {
                    $(window).scrollTop( $("#contact").offset().top );
                   $('#contactform').remove();
                }
            }
        });
    }
	
	$.ajaxSetup({
	headers: {
	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
	});
	$('.mark-as-read').click(function () {
	console.log('test');
	var url = "{{ route('user.message.readAllUnread',[':id']) }}";
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
@endsection
