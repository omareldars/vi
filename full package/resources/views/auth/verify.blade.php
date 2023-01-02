@extends('layouts.admin')
@section('vendorstyle')
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/charts/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/extensions/swiper.min.css">
@stop
@section('style')
    <link rel="stylesheet" type="text/css" href="/app-assets/css{{$l=='ar'?'-rtl':''}}/pages/dashboard-ecommerce.css">
@stop
@section('title', __('admin.Dashboard') )
@section('content')

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            @include('admin.includes.heading')
            <div class="content-header row">
            </div>
            <div class="content-body">



                <div class="col-xl-12 col-md-12 col-12 dashboard-greetings">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="greeting-text">{{ __('Verify Your Email Address') }}!</h3>
                        </div>
                        <div class="card-content">
                            <div class="card-body">

                                @if (session('resent'))
                                    <div class="alert alert-success" role="alert">
                                        {{ __('A fresh verification link has been sent to your email address.') }}
                                    </div>
                                @endif
                                <h5>
                                    {{ __('Before proceeding, please check your email for a verification link.') }}

                                </h5>
                                    <br>
                                    <p>
                                        {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                                    </p>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->
@stop
