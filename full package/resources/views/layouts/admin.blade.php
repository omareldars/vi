<!DOCTYPE html>
<html lang="{{ $l }}">
<html class="loading" lang="{{ $l }}" data-textdirection="{{$l=="ar" ? 'rtl' : 'ltr'}}">
<head>
		@include('admin.includes.head')
</head>
<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern {{session('layout')??'semi-dark'}}-layout 2-columns @yield('bodyclass') navbar-sticky footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">
		@include('admin.includes.header')
    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-{{session('layout')=='light'?'light':'dark'}} menu-accordion menu-shadow" data-scroll-to-active="true">
		@include('admin.includes.menu')
    </div>
    <!-- END: Main Menu-->
	<!-- Start Content -->
		@yield('content')
	<!-- End Content -->
  	<!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
		@include('admin.includes.footer')
    </footer>
    <!-- END: Footer-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        @hasanyrole('Admin|Manager')
        <!-- Pusher scripts -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="//js.pusher.com/3.1/pusher.min.js"></script>
    <script type="text/javascript">
            var notificationsWrapper   = $('.dropdown-menu-media');
            var countWrapper = $('.dropdown-notification');
            var notificationsCountElem = notificationsWrapper.find('li[data-count]');
            var notificationsCount     = parseInt(notificationsCountElem.data('count'));
            var notifications          = notificationsWrapper.find('li.scrollable-container');
            // Enable pusher logging - don't include this in production 
            Pusher.logToConsole = false;
            var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
                cluster: 'eu'
            });
            // Subscribe to the channel we specified in our Laravel Event
            var channel = pusher.subscribe('Web-Message');
            // Bind a function to a Event (the full Laravel class)
            channel.bind('App\\Events\\WebMessage', function(data) {
                var existingNotifications = notifications.html();
                if (data.type === 'mymsg') {
                    var mylink = 'admin/mymsg';
                    var mymessage = '{{__('admin.New Contact us message from')}}' + ' ' + data.username;
                } else if (data.type === 'NewUser') {
                    var mylink = 'admin/users';
                    var mymessage =  data.username + ' ' + '{{__('admin.Register new account')}}';
                } else if (data.type === 'NewComp') {
                    var mylink = 'admin/companies';
                    var mymessage =  data.username + ' ' + '{{__('admin.Create a new Company')}}';
                } else if (data.type === 'UpdateComp') {
                    var mylink = 'admin/companies';
                    var mymessage =  data.username + ' ' + '{{__('admin.Update Company profile')}}';
                } else if (data.type === 'NewMsg') {
                    var mylink = 'admin/messages';
                    var mymessage =  '{{__('admin.New Message from')}}' + ' ' + data.username  ;
                } else if (data.type === 'NewServ') {
                    var mylink = 'admin/requests/all';
                    var mymessage =  '{{__('admin.New Service request from')}}' + ' ' + data.username  ;
                } else if (data.type === 'NewMent') {
                    var mylink = 'admin/mentorship/sessions';
                    var mymessage =  '{{__('admin.New mentorship request from')}}' + ' ' + data.username  ;
                }
                var newNotificationHtml = `
    <a class="d-flex justify-content-between" href="/`+mylink+`">
                                        <div class="media d-flex align-items-center">
                                            <div class="media-left pr-0">
                                                <div class="avatar mr-1 m-0"><img src="/app-assets/images/portrait/small/avatar.jpg" alt="avatar" height="39" width="39"></div>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading">`+mymessage+`.</h6>
                                            </div>
                                        </div>
                                    </a>`;
                notifications.html(newNotificationHtml + existingNotifications);
                notificationsCount += 1;
                var nplus = 1;
                nplus += parseInt(notificationsWrapper.find('.notif-count').text());
                notificationsWrapper.find('#notif-plus-count').text(nplus);
                notificationsCountElem.attr('data-count', nplus);
                countWrapper.find('.notif-count').text(nplus);
                notificationsWrapper.find('.notif-count').text(nplus);
                notificationsWrapper.show();
                notificationsWrapper.css('display', '');
            });
    </script>
    <!-- End of Pusher -->
    @endhasanyrole
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
    <script src="/app-assets/js/scripts/forms/select/form-select2.js"></script>
    <script src="/app-assets/js/scripts/extensions/sweet-alerts.js"></script>
    <script src="/app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <!-- BEGIN: Vendor JS-->
    <script src="/app-assets/vendors/js/vendors.min.js"></script>
    <script src="/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js"></script>
    <script src="/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js"></script>
    <script src="/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script>
    <!-- BEGIN Vendor JS-->
	@yield('scripts')
    <!-- BEGIN: Theme JS-->
    <script src="/app-assets/js/scripts/configs/vertical-menu-dark.js"></script>
    <script src="/app-assets/js/core/app-menu.js"></script>
	<script src="/app-assets/js/core/app.js"></script>
    <script src="/app-assets/js/scripts/components.js"></script>
	<script src="/app-assets/js/scripts/footer.js"></script>
    <!-- END: Theme JS-->
	@yield('pagescripts')
</body>
<!-- END: Body-->
</html>