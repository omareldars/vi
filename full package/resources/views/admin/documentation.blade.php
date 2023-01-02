<!DOCTYPE html>
<html class="loading" lang="ar" data-textdirection="rtl">
<head>
    @include('admin.includes.head')
</head>
<body class="vertical-layout vertical-menu-modern {{session('layout')??'semi-dark'}}-layout 2-columns" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
<!-- fixed-top-->
@include('admin.includes.header')
<div class="main-menu menu-fixed menu-{{session('layout')=='light'?'light':'dark'}} menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="/admin">
                    <div class="brand-logo"></div>
                    <h2 class="brand-text mb-0">{{config('app.name')}}</h2>
                </a></li>
            <li class="nav-item d-none d-xl-block nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="toggle-icon bx bx-disc font-medium-4 primary" data-ticon="bx-disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            @foreach($menu as $item)
            <li class="{{$doc->id==$item->id?'active':''}}"><a href="/admin/documentation/view/{{$item->id}}">
                    <i class="bx {{$item->icon??'bx-bookmark'}}"></i><span class="menu-title" >{{ $item->{'menu_'.$l} }}</span></a>
            </li>
             @endforeach
        </ul>
    </div>
</div>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h5 class="content-header-title float-left pr-1 mb-0">{{ $doc->{'menu_'.$l} }}</h5>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item active"><a href="/admin/documentation/view">الرئيسية</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Overview -->
            <div class="card">
                <div class="card-header">
                    @if ($doc->id==1)
                    <a href="/admin">
                        <h2> <img src="/images/logo/admin-logo.png"> VI-Portal v1</h2></a>
                    <h4 id="basic-forms" class="card-title">{{$l=='ar'?'الإصدار الأول من برنامج الحاضنة الإفتراضية':'Virtual incubation portal version 1.0'}}
                    </h4>
                    @else
                        <h4 id="basic-forms" class="card-title">{{ $doc->{'menu_'.$l} }}</h4>
                    @endif
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="bx bx-chevron-down"></i></a></li>
                            <li><a data-action="expand"><i class="bx bx-fullscreen"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show" aria-expanded="true">
                    <div class="card-body">
                {!! $doc->{'content_'.$l} !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<footer class="footer footer-static footer-light">
    @include('admin.includes.footer')
</footer>
<script src="/app-assets/vendors/js/vendors.min.js"></script>
<script src="/app-assets/js/core/app-menu.js"></script>
<script src="/app-assets/js/core/app.js"></script>
<script src="/app-assets/js/scripts/documentation.js" type="text/javascript"></script>
<script src="/app-assets/vendors/js/ui/affix.js" type="text/javascript"></script>
</body>
</html>