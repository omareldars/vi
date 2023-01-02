<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<html class="loading" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-textdirection="{{app()->getLocale()=="ar" ? 'rtl' : 'ltr'}}">
<head>
		@include('admin.includes.head')
</head>
<!-- BEGIN: Body-->
<body class="vertical-layout navbar-sticky footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">
		@include('admin.includes.header')
	<!-- Start Content -->
		@yield('content')
	<!-- End Content -->
  	<!-- BEGIN: Footer-->
        <footer class="footer footer-static footer-light">
            @include('admin.includes.footer')
        </footer>
    <!-- END: Footer-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <!-- BEGIN: Vendor JS-->
        <script src="/app-assets/vendors/js/vendors.min.js"></script>
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
