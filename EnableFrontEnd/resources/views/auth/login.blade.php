<!DOCTYPE html>
<html class="loading" lang="{{$l}}" data-textdirection="{{$l=='ar'?'rtl':'ltr'}}" style="direction: {{$l=='ar'?'rtl':'ltr'}};">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="VI Login">
    <meta name="author" content="ibrahim.suez@gmail.com">
    <title>{{__('Login Page')}} - {{ App\Settings::findorfail(1)->first('title')->title }} - v1</title>
    <link rel="apple-touch-icon" href="/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/vendors{{$l=='ar'?'-rtl':''}}.min.css">
    <!-- END: Vendor CSS-->
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css{{$l=='ar'?'-rtl':''}}/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css{{$l=='ar'?'-rtl':''}}/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css{{$l=='ar'?'-rtl':''}}/colors.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css{{$l=='ar'?'-rtl':''}}/components.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css{{$l=='ar'?'-rtl':''}}/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css{{$l=='ar'?'-rtl':''}}/themes/semi-dark-layout.css">
    <!-- END: Theme CSS-->
    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"
          href="/app-assets/css{{$l=='ar'?'-rtl':''}}/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css{{$l=='ar'?'-rtl':''}}/pages/authentication.css">
    <!-- END: Page CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="/assets/css/style{{$l=='ar'?'-rtl':''}}.css">
    <!-- END: Custom CSS-->
</head>
<!-- END: Head-->
<!-- BEGIN: Body-->
<body
    class="vertical-layout vertical-menu-modern semi-dark-layout 1-column navbar-sticky footer-static bg-full-screen-image  blank-page blank-page"
    data-open="click" data-menu="vertical-menu-modern" data-col="1-column" data-layout="semi-dark-layout">
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- login page start -->
            <section id="auth-login" class="row flexbox-container">
                <div class="col-xl-8 col-11">
                    <div class="card bg-authentication mb-0">
                        <div class="row m-0">
                            <!-- left section-login -->
                            <div class="col-md-6 col-12 px-0">
                                <div
                                    class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                                    <div class="card-header pb-1">
                                        <div class="card-title">
                                            <h4 class="text-center mb-2">{{__('Welcome Back')}}</h4>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="d-flex flex-md-row flex-column justify-content-around">
                                                <a href="{{ url('/auth/redirect/google') }}"
                                                   class="btn btn-social btn-google btn-block font-small-3 mr-md-1 mb-md-0 mb-1">
                                                    <i class="bx bxl-google font-medium-3"></i><span
                                                        class="pl-50 d-block text-center">{{__('Google')}}</span></a>
                                                <a href="{{ url('/auth/redirect/facebook') }}"
                                                   class="btn btn-social btn-block mt-0 btn-facebook font-small-3">
                                                    <i class="bx bxl-facebook-square font-medium-3"></i><span
                                                        class="pl-50 d-block text-center">{{__('Facebook')}}</span></a>
                                            </div>
                                                             @if ($errors->has('social'))
                                                        <span class="help-block warning"><br>
                                                            {{__('You already have an account, Login with your email, or reset your account')}}!!
                                                        </span>
                                                    		@endif
                                            <div class="divider">
                                                <div class="divider-text text-uppercase text-muted"><small>
                                                        {{__('or login with email')}}</small>
                                                </div>
                                            </div>
                                            <form method="POST" action="{{ route('login') }}">
                                                @csrf
                                                <div class="form-group mb-50">
                                                    <label class="text-bold-600"
                                                           for="exampleInputEmail1">{{ __('auth.E-Mail') }}</label>
                                                    <input value="{{ old('email') }}" name="email" type="email"
                                                           class="form-control" id="email"
                                                           placeholder="{{ __('auth.E-Mail') }}" required
                                                           autocomplete="email" autofocus>

                                                             @if ($errors->has('email'))
                                                        <span class="help-block">
                                                            {{ $errors->first('email') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-bold-600"
                                                           for="exampleInputPassword1">{{ __('auth.Password') }}</label>
                                                    <input type="password" class="form-control" id="password"
                                                           placeholder="{{ __('auth.Password') }}" name="password"
                                                           required autocomplete="current-password">
                                                    @if ($errors->has('password'))
                                                        <span class="help-block">
                                                            {{ $errors->first('password') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div
                                                    class="form-group d-flex flex-md-row flex-column justify-content-between align-items-center">
                                                    <div class="text-left">
                                                        <div class="checkbox checkbox-sm">
                                                            <input type="checkbox" class="form-check-input"
                                                                   id="exampleCheck1"
                                                                {{ old('remember') ? 'checked' : '' }}>
                                                            <label class="checkboxsmall"
                                                                   for="exampleCheck1"><small>{{ __('auth.Remember') }}</small></label>
                                                        </div>
                                                    </div>
                                                    <div class="text-right"><a
                                                            href="{{ route('password.request') }}"
                                                            class="card-link"><small>{{__('Forgot Password?')}}</small></a>
                                                    </div>
                                                </div>
                                                <button type="submit"
                                                        class="btn btn-primary glow w-100 position-relative">
                                                    {{__('auth.Login')}}<i id="icon-arrow"
                                                                           class="bx bx-{{$l=='ar'?'left':'right'}}-arrow-alt"></i></button>
                                            </form>
                                            <hr>
                                            <div class="text-center"><small class="mr-25">{{__("Don't have an account")}}?</small><a href="/register"> <small> {{__('Sign up')}},</small> </a> <small class="mr-25"> {{__('or click')}} </small> <a href="/"><small> {{__('here')}} </small></a> <small class="mr-25">{{__('to go home')}}.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- right section image -->
                            <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                                <div class="card-content">
                                    <img class="img-fluid" src="/app-assets/images/pages/login.png"
                                         alt="branding logo">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- login page ends -->

        </div>
    </div>
</div>
<!-- END: Content-->


<!-- BEGIN: Vendor JS-->
<script src="/app-assets/vendors/js/vendors.min.js"></script>
<script src="/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js"></script>
<script src="/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js"></script>
<script src="/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="/app-assets/js/scripts/configs/vertical-menu-dark.js"></script>
<script src="/app-assets/js/core/app-menu.js"></script>
<script src="/app-assets/js/core/app.js"></script>
<script src="/app-assets/js/scripts/components.js"></script>
<script src="/app-assets/js/scripts/footer.js"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<!-- END: Page JS-->

</body>
<!-- END: Body-->

</html>
