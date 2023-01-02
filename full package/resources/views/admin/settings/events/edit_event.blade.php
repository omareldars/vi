@extends('layouts.admin')
@section('style')
    <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.min.css">
@stop
@section('content')
<!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('settings.eventsettings')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/admin/allevents"><i class="bx bx-briefcase"></i></a>
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
                                        <form class="form" id="basicForm" action= "/admin/updateevent/{{$getevents->id}}" method="post" enctype="multipart/form-data">
               							 {!! csrf_field() !!}
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input style="direction: rtl;" type="text" class="form-control" value="{{$getevents->title_ar}}" name="title_ar" required>
                                                            <label for="title_ar">{{__('settings.ARABICTITLE')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input style="direction: ltr;" type="text" class="form-control" value="{{$getevents->title_en}}" name="title_en" required>
                                                            <label for="title_en">{{__('settings.ENGLISHTITLE')}}</label>
                                                        </div>
                                                    </div>
                                                     <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <textarea class="form-control" id="body_ar" rows="8" name="body_ar" required>{{$getevents->body_ar}}</textarea>
                                                            <label for="ar_body">{{__('settings.Content')}} {{__('settings.InArabic')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <textarea class="form-control" id="body_en" rows="8" name="body_en" required>{{$getevents->body_en}}</textarea>
                                                            <label for="body">{{__('settings.Content')}} {{__('settings.InEnglish')}}</label>
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
													<div class="col-12">&nbsp;</div>
													 <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input id="SelectDate" type="text" class="form-control" value="{{$getevents->timerdate}}" name="timerdate" >
                                                            <label for="timerdate">{{__('settings.EventDT')}}: 2022/01/15 13:30:00</label>
                                                        </div>
                                                    </div>
													 <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <textarea style="direction: ltr;" class="form-control" id="googlemap" rows="3" name="googlemap" >{{$getevents->googlemap}}</textarea>
                                                            <label for="googlemap">{{__('settings.GoogleMapRef')}}</label>
                                                        </div>
                                                    </div>
													<div class="col-md-12 col-12">
													<div class="custom-control custom-switch custom-control-inline mb-1">
														<span>{{__('settings.EnableTimer')}}</span>&nbsp;
                                            			<input name="showtimer" type="checkbox" class="custom-control-input" id="customSwitch1" {{$getevents->showtimer?'checked="checked"':''}}>
                                            			<label class="custom-control-label mr-1" for="customSwitch1">
                                            			</label>
                                        			</div>
													</div>
													<div class="col-md-12 col-12">
													<div class="custom-control custom-switch custom-control-inline mb-1">
														<span>{{__('settings.Published')}}</span>&nbsp;
                                            			<input name="published" type="checkbox" class="custom-control-input" id="customSwitch3" {{$getevents->published?'checked="checked"':''}}>
                                            			<label class="custom-control-label mr-1" for="customSwitch3">
                                            			</label>
                                        			</div>
													</div>
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
@section('pagescripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/ckeditor/4.5.11/ckeditor.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/ckeditor/4.5.11/adapters/jquery.js"></script>
    <script>
        var route_prefix = "/filemanager";
    </script>
    <script src="/js/jquery.datetimepicker.full.min.js"></script>
    <script>
        $('#SelectDate').datetimepicker({mask:'9999/19/39 29:59',value:'{{$getevents->timerdate}}' });
        $('textarea[name=body_ar]').ckeditor({
            height: 250,
            filebrowserImageBrowseUrl: route_prefix + '?type=Images',
            filebrowserImageUploadUrl: route_prefix + '/upload?type=Images&_token={{csrf_token()}}',
            filebrowserBrowseUrl: route_prefix + '?type=Files',
            filebrowserUploadUrl: route_prefix + '/upload?type=Files&_token={{csrf_token()}}',
            language: 'ar'
        });
        $('textarea[name=body_en]').ckeditor({
            height: 250,
            filebrowserImageBrowseUrl: route_prefix + '?type=Images',
            filebrowserImageUploadUrl: route_prefix + '/upload?type=Images&_token={{csrf_token()}}',
            filebrowserBrowseUrl: route_prefix + '?type=Files',
            filebrowserUploadUrl: route_prefix + '/upload?type=Files&_token={{csrf_token()}}',
            language: 'en'
        });
    </script>
@stop
