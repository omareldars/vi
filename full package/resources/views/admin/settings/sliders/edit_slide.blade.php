@extends('layouts.admin')
@section('content')
<!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('settings.Slidersettings')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/admin/slides"><i class="bx bx-slider-alt"></i></a>
                                    </li>
									<li class="breadcrumb-item active">{{__('settings.Edit')}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<div class="content-body">
                <section id="multiple-column-form">
                    <div class="row match-height">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form" id="basicForm" action= "/admin/update_slide/{{$getslider->id}}" method="POST" enctype="multipart/form-data">
               							 {!! csrf_field() !!}
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input style="direction: rtl;" type="text" class="form-control" value="{{$getslider->ar_title}}" name="ar_title" required>
                                                            <label for="ar_title">{{__('settings.ARABICTITLE')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input style="direction: ltr;" type="text" class="form-control" value="{{$getslider->title}}" name="title" required>
                                                            <label for="title">{{__('settings.ENGLISHTITLE')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input style="direction: rtl;" type="text" class="form-control" value="{{$getslider->ar_img_desc}}" name="ar_img_desc">
                                                            <label for="ar_img_desc">{{__('settings.ARABICDESCRIPTION')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" style="direction: ltr;" class="form-control" value="{{$getslider->img_desc}}" name="img_desc">
                                                            <label for="img_desc">{{__('settings.ENGLISHDESCRIPTION')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" style="direction: ltr;" class="form-control" value="{{$getslider->img_url}}" name="img_url">
                                                            <label for="company-column">{{__('settings.URLOF')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" style="direction: rtl;" class="form-control" value="{{$getslider->ar_url_title}}" name="ar_url_title">
                                                            <label for="ar_url_title">{{__('settings.URLOF')}} - {{__('settings.ARABICTITLE')}}</label>
                                                        </div>
                                                    </div>
													<div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" style="direction: ltr;" class="form-control" value="{{$getslider->url_title}}" name="url_title">
                                                            <label for="url_title">{{__('settings.URLOF')}} - {{__('settings.ENGLISHTITLE')}}</label>
                                                        </div>
                                                    </div>
													<div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" class="form-control" value="{{$getslider->slideorder}}" name="slideorder" >
                                                            <label for="slideorder">{{__('settings.OrderNumber')}}</label>
                                                        </div>
                                                    </div>
													<div class="col-md-6 col-6">
                                                        <div class="form-group">
															<label>{{__('settings.Image')}}</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="form-control" name="image" id="image" accept='image/*'>
                                                                <label class="custom-file-label" for="image">{{__('settings.Browse')}}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if ($getslider->img_path)
                                                        <div class="col-md-3 col-3">
                                                            <img src="/images/slider/{{$getslider->img_path}}" height="100px">
                                                        </div>
                                                    @endif
                                                    <div class="col-12 d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1">{{__('settings.Submit')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic multiple Column BuilderForm section end -->
            </div>
        </div>
    </div>
    <!-- END: Content-->
@stop
