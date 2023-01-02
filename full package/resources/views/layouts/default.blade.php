<!DOCTYPE html>
<html lang="{{$l}}">
<head>
    @php($gtag = \App\settings::findorfail(1)->first())
    @if ($gtag)
    <script async src="https://www.googletagmanager.com/gtag/js?id={!!$gtag->url!!}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{!!$gtag->url!!}');
    </script>
    @endif
    <meta charset="UTF-8">
<title>
	@yield('title', $gtag->title)
</title>
	<!-- mobile responsive meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" href="/css/style.css">
	<link rel="stylesheet" href="/css/responsive.css">
@if ($l=='ar') 	<link rel="stylesheet" href="/css/rtl.css"> @endif
	<link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" href="/images/favicon/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="/images/favicon/favicon-16x16.png" sizes="16x16">
    <meta property="og:url"           content="{{url()->current()}}" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="@yield('title', 'Virtual Incubator')" />
    <meta property="og:image"         content="{{url("/images/logo/logo-".$l.".png")}}" />
</head>
<body>

<div class="boxed_wrapper">
<header class="top-bar">
    <div class="container">
        <div class="clearfix">
            <ul class="top-bar-text float_left">
                <li><i class="icon-technology-1"></i>{{$contact->ar_title}}</li>
                <li><i class="icon-note"></i>{{$contact->title}}</li>
                <li>
				@if ($l=='ar')
				<a style="color:#fff;" href="/lang/en"><img style="width: 20px;" src="/images/icons/usa-flag.jpg" > English </a>
				@else
				<a style="color:#fff;" href="/lang/ar"><img style="width: 20px;" src="/images/icons/eg-flag.jpg" > عربي </a>
				@endif
				</li>
            </ul>
            <ul class="social float_right">
			@foreach ($SocialIcons as $icon)
			<li><a href="{{$icon->url}}"><i class="fa fa-{{$icon->img_url}}"></i></a></li>
            @endforeach
            </ul>
        </div>
    </div>
</header>
		@include('includes.menu')

		@yield('content')

		@include('includes.footer')
<!-- Scroll Top Button -->
<button class="scroll-top tran3s color2_bg">
	<span class="fa fa-angle-up"></span>
</button>
	<!-- pre loader  -->
	<div class="/preloader"></div>
	<!-- jQuery js -->
	<script src="/js/jquery.js"></script>
	<!-- bootstrap js -->
	<script src="/js/bootstrap.min.js"></script>
	<!-- jQuery ui js -->
	<script src="/js/jquery-ui.js"></script>
	<!-- owl carousel js -->
	<script src="/js/owl.carousel.min.js"></script>
	<!-- jQuery validation -->
	<script src="/js/jquery.validate.min.js"></script>
	<!-- mixit up -->
	<script src="/js/wow.js"></script>
	<script src="/js/jquery.mixitup.min.js"></script>
	<script src="/js/jquery.fitvids.js"></script>
    <script src="/js/bootstrap-select.min.js"></script>
	<script src="/js/menuzord.js"></script>
	<!-- Extraa JS like revolution slider js -->
		@yield('scripts')
	<!-- fancy box -->
	<script src="/js/jquery.fancybox.pack.js"></script>
	<script src="/js/jquery.polyglot.language.switcher.js"></script>
	<script src="/js/nouislider.js"></script>
	<script src="/js/jquery.bootstrap-touchspin.js"></script>
	<script src="/js/SmoothScroll.js"></script>
	<script src="/js/jquery.appear.js"></script>
	<script src="/js/jquery.countTo.js"></script>
	<script src="/js/jquery.flexslider.js"></script>
	<script src="/js/imagezoom.js"></script>
	<script src="/js/custom.js"></script>
</div>
</body>
</html>
