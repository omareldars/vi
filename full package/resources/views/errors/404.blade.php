<!DOCTYPE html>
<html class="loading" lang="{{$l}}" data-textdirection="{{$l=='ar'?'rtl':'ltr'}}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{__('Error 404 - Page not found')}}</title>
    <link rel="apple-touch-icon" href="/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Cairo&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/vendors{{$l=='ar'?'-rtl':''}}.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css{{$l=='ar'?'-rtl':''}}/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css{{$l=='ar'?'-rtl':''}}/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css{{$l=='ar'?'-rtl':''}}/colors.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css{{$l=='ar'?'-rtl':''}}/components.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css{{$l=='ar'?'-rtl':''}}/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css{{$l=='ar'?'-rtl':''}}/themes/semi-dark-layout.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/style{{$l=='ar'?'-rtl':''}}.css">
</head>
<body class="vertical-layout vertical-menu-modern semi-dark-layout 1-column  navbar-sticky footer-static bg-full-screen-image  blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column" data-layout="semi-dark-layout">
 <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="row flexbox-container">
                    <div class="col-xl-6 col-md-7 col-9">
                        <div class="card bg-transparent shadow-none">
                            <div class="card-content">
                                <div class="card-body text-center">
                                    <h1 class="error-title">{{__('Page Not Found')}} :(</h1>
                                    <p class="pb-3">
                                       {{__("we couldn't find the page you are looking for")}}</p>
                                    <img class="img-fluid" src="/app-assets/images/pages/404.png" alt="404 error">
                                    <a href="/" class="btn btn-primary round glow mt-3">{{__('BACK TO HOME')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</body>
<!-- END: Body-->
</html>
