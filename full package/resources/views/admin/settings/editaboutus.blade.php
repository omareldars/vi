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
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('settings.AboutSettings')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
									<li class="breadcrumb-item active">{{__('settings.EditSettings')}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<div class="content-body">
                <section id="multiple-column-form">
				@if(session()->has('message'))
				<div class="alert alert-success alert-dismissible mb-2" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <div class="d-flex align-items-center">
                                                <i class="bx bx-like"></i>
                                                <span>
                                                    {{ __('admin.'.session()->get('message')) }}
                                                </span>
                                            </div>
                  </div>
					@endif
					@if(session()->has('message2'))
					 <div class="alert alert-danger alert-dismissible mb-2" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <div class="d-flex align-items-center">
                                                <i class="bx bx-error"></i>
                                                <span>
                                                    {{ __('admin.'.session()->get('message2')) }}
                                                </span>
                                            </div>
                     </div>
					 @endif
                    <div class="row match-height">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form" id="basicForm" action= "{{URL::to('admin/updateaboutus')}}" method="POST" enctype="multipart/form-data">
               							 {!! csrf_field() !!}
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" style="direction: rtl;" class="form-control" value="{{$allabout->ar_title}}" name="ar_title" required>
                                                            <label for="ar_title">                                                        <th>{{__('settings.ARABICTITLE')}}</th>
</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" style="direction: ltr;" class="form-control" value="{{$allabout->title}}" name="title" required>
                                                            <label for="title">{{__('settings.ENGLISHTITLE')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <textarea style="direction: rtl;" class="form-control" id="basicTextarea" rows="6" name="ar_dsc" required>{{$allabout->ar_dsc}}</textarea>
                                                            <label for="ar_dsc">{{__('settings.ARABICDESCRIPTION')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
														<textarea style="direction: ltr;" class="form-control" id="basicTextarea" rows="6" name="dsc" required>{{$allabout->dsc}}</textarea>
                                                            <label for="dsc">{{__('settings.ENGLISHDESCRIPTION')}}</label>
                                                        </div>
                                                    </div>
													<div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input style="direction: rtl;" type="text" class="form-control" value="{{$allabout->ar_set1}}" name="ar_set1" required>
                                                            <label for="ar_set1">{{__('settings.Mission')}} {{__('settings.InArabic')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input style="direction: ltr;" type="text" class="form-control" value="{{$allabout->set1}}" name="set1" required>
                                                            <label for="set1">{{__('settings.Mission')}} {{__('settings.InEnglish')}}</label>
                                                        </div>
                                                    </div>
													<div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input style="direction: rtl;" type="text" class="form-control" value="{{$allabout->ar_set2}}" name="ar_set2" required>
                                                            <label for="ar_set2">{{__('settings.Vision')}} {{__('settings.InArabic')}} </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input style="direction: ltr;" type="text" class="form-control" value="{{$allabout->set2}}" name="set2" required>
                                                            <label for="set2">{{__('settings.Vision')}} {{__('settings.InEnglish')}}</label>
                                                        </div>
                                                    </div>
													<div class="col-md-12 col-12">
													<div class="custom-control custom-switch custom-control-inline mb-1">
														<span>{{__('settings.EnablePress')}}</span>&nbsp;
                                            			<input name="url" type="checkbox" class="custom-control-input" {{$allabout->url?'checked="checked"':''}} id="customSwitch1">
                                            			<label class="custom-control-label mr-1" for="customSwitch1">
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
