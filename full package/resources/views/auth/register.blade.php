<!DOCTYPE html>
<html class="loading" lang="{{$l}}" data-textdirection="rtl" style="direction: {{$l=='ar'?'rtl':'ltr'}};">
<!-- BEGIN: Head-->
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="VI V0.1">
    <meta name="keywords" content="VI V0.1">
    <meta name="author" content="ibrahim.suez@gmail.com">
    <title>Registration Page - VI portal</title>
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
    class="vertical-layout vertical-menu-modern semi-dark-layout 1-column  navbar-sticky footer-static bg-full-screen-image  blank-page blank-page"
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
                            @if (App\Settings::findOrFail(1)->set_order)
                            <div class="col-md-6 col-12 px-0">
                                <div
                                    class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                                    <div class="card-header pb-1">
                                        <div class="card-title">
                                            <h4 class="text-center mb-2">{{ __('auth.Create Free Account') }}</h4>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            @if (count($errors) > 0)
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <form method="POST" action="{{ route('register') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label class="text-bold-600"
                                                           for="first_name_en">{{ __('auth.English Name') }}</label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input value="{{ old('first_name_en') }}" name="first_name_en" type="text"
                                                                   class="form-control" id="first_name_en"
                                                                   placeholder="{{ __('auth.First English Name') }}" required
                                                                   autocomplete="first_name_en" autofocus />
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input value="{{ old('last_name_en') }}" name="last_name_en" type="text"
                                                                   class="form-control" id="last_name_en"
                                                                   placeholder="{{ __('auth.Last English Name') }}" required
                                                                   autocomplete="last_name_en" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <ul class="list-unstyled mb-0">
                                                        <li class="d-inline-block mr-2 mb-1">
                                                            <fieldset>
                                                                <div class="radio">
                                                                    <input type="radio" name="gender" value="Male" id="rad1" checked="">
                                                                    <label for="rad1">{{__('Male')}}</label>
                                                                </div>
                                                            </fieldset>
                                                        </li>
                                                        <li class="d-inline-block mr-2 mb-1">
                                                            <fieldset>
                                                                <div class="radio">
                                                                    <input type="radio" name="gender" value="Female" id="rad2">
                                                                    <label for="rad2">{{__('Female')}}</label>
                                                                </div>
                                                            </fieldset>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-bold-600"
                                                           for="exampleInputEmail1">{{ __('auth.E-Mail') }}</label>
                                                    <input value="{{ old('email') }}" name="email" type="email"
                                                           class="form-control" id="email"
                                                           placeholder="{{ __('auth.E-Mail') }}" required
                                                           autocomplete="email">
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-bold-600"
                                                           for="phone">{{ __('auth.Phone') }}</label>
                                                    <input type="text" class="form-control" id="phone"
                                                           placeholder="{{ __('auth.Phone') }}" value="{{ old('phone') }}" name="phone"
                                                           required autocomplete="new-phone">
                                                </div>
                                                <!--
                                                <div class="form-group">
                                                    <label for="basicInput">{{ __('auth.AccountType')}}</label>
                                                    <select class="form-control" required
                                                            id="UserType" name='UserType'>
                                                        <option value="">{{ __('auth.AccountType')}}</option>
                                                        <option value="Service Provider" {{old('UserType')=="Service Provider"?'selected':''}}>{{ __('admin.Service Provider')}}</option>
                                                        <option value="Service Seeker" {{old('UserType')=="Service Seeker"?'selected':''}}>{{ __('admin.Service Seeker')}}</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="basicInput">{{ __('auth.DoYouHaveCompany')}}</label>
                                                    <ul class="list-unstyled mb-0">
                                                        <li class="d-inline-block mr-2 mb-1">
                                                            <fieldset>
                                                                <div class="radio">
                                                                    <input type="radio" name="HaveCompany" value="1" id="h1" {{old('HaveCompany')?'checked=""':''}}>
                                                                    <label for="h1">{{__('Yes')}}</label>
                                                                </div>
                                                            </fieldset>
                                                        </li>
                                                        <li class="d-inline-block mr-2 mb-1">
                                                            <fieldset>
                                                                <div class="radio">
                                                                    <input type="radio" name="HaveCompany" value="" id="h2" {{old('HaveCompany')?'':'checked=""'}}>
                                                                    <label for="h2">{{__('No')}}</label>
                                                                </div>
                                                            </fieldset>
                                                        </li>
                                                    </ul>
                                                </div>
                                                -->
                                                <div class="form-group">
                                                    <label class="text-bold-600"
                                                           for="password">{{ __('auth.Password') }}</label>
                                                    <input type="password" class="form-control" id="password"
                                                           placeholder="{{ __('auth.Password') }}" name="password"
                                                           required autocomplete="new-password">
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-bold-600"
                                                           for="password-confirm">{{ __('auth.Confirm') }}</label>
                                                    <input type="password" class="form-control" id="password-confirm"
                                                           placeholder="{{ __('auth.Password') }}" name="password_confirmation"
                                                           required autocomplete="new-password">
                                                </div>
                                                <div class="form-group">
                                                    <small>{{__("By clicking on Register, you acknowledge the validity of the data you have registered, and you pledge not to misuse the services provided through this site in any way, and take legal responsibility in case you violate the terms of service")}}
                                                    </small>
                                                </div>
                                                <div class="form-group row mb-0">
                                                    <div class="col-md-6 offset-md-4">
                                                        <button type="submit" class="btn btn-primary">
                                                            {{ __('auth.Register') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                            <hr>
                                            <div class="text-center"><small class="mr-25">{{__('Already have account')}}: </small><a href="/login"><small> {{__('Login')}}</small></a>.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="col-md-6 col-12 px-0">
                                    <div
                                            class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                                        <div class="card-header pb-1">
                                            <div class="card-title">
                                                <h4 class="text-center mb-2">{{ __('auth.Registration Disabled') }}</h4>
                                            </div>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body">

                                                <form>

                                                    <div class="form-group">
                                                        <label class="text-bold-600"
                                                               for="first_name_en">{{ __('auth.English Name') }}</label>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input value="{{ old('first_name_en') }}" name="first_name_en" type="text"
                                                                       class="form-control" id="first_name_en"
                                                                       placeholder="{{ __('auth.First English Name') }}" disabled
                                                                       autocomplete="first_name_en" autofocus />
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input value="{{ old('last_name_en') }}" name="last_name_en" type="text"
                                                                       class="form-control" id="last_name_en"
                                                                       placeholder="{{ __('auth.Last English Name') }}" disabled
                                                                       autocomplete="last_name_en" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <ul class="list-unstyled mb-0">
                                                            <li class="d-inline-block mr-2 mb-1">
                                                                <fieldset>
                                                                    <div class="radio">
                                                                        <input type="radio" name="gender" value="Male" id="rad1" checked="" disabled>
                                                                        <label for="rad1">{{__('Male')}}</label>
                                                                    </div>
                                                                </fieldset>
                                                            </li>
                                                            <li class="d-inline-block mr-2 mb-1">
                                                                <fieldset>
                                                                    <div class="radio">
                                                                        <input type="radio" name="gender" value="Female" id="rad2" disabled>
                                                                        <label for="rad2">{{__('Female')}}</label>
                                                                    </div>
                                                                </fieldset>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="text-bold-600"
                                                               for="exampleInputEmail1">{{ __('auth.E-Mail') }}</label>
                                                        <input value="{{ old('email') }}" name="email" type="email"
                                                               class="form-control" id="email"
                                                               placeholder="{{ __('auth.E-Mail') }}" disabled
                                                               autocomplete="email">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="text-bold-600"
                                                               for="phone">{{ __('auth.Phone') }}</label>
                                                        <input type="text" class="form-control" id="phone"
                                                               placeholder="{{ __('auth.Phone') }}" value="{{ old('phone') }}" name="phone"
                                                               required autocomplete="new-phone" disabled>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="text-bold-600"
                                                               for="password">{{ __('auth.Password') }}</label>
                                                        <input type="password" class="form-control" id="password"
                                                               placeholder="{{ __('auth.Password') }}" name="password"
                                                               disabled autocomplete="new-password">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="text-bold-600"
                                                               for="password-confirm">{{ __('auth.Confirm') }}</label>
                                                        <input type="password" class="form-control" id="password-confirm"
                                                               placeholder="{{ __('auth.Password') }}" name="password_confirmation"
                                                               disabled autocomplete="new-password">
                                                    </div>
                                                    <div class="form-group">
                                                        <small style="color:#f2f4f4;">{{__("By clicking on Register, you acknowledge the validity of the data you have registered, and you pledge not to misuse the services provided through this site in any way, and take legal responsibility in case you violate the terms of service")}}
                                                        </small>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <div class="col-md-6 offset-md-4">
                                                            <button type="submit" class="btn btn-primary" disabled>
                                                                {{ __('auth.Register') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <hr>
                                                <div class="text-center"><small class="mr-25">{{__('Already have account')}}: </small><a href="/login"><small> {{__('Login')}}</small></a>.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
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
