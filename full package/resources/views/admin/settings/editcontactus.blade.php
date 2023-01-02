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
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('settings.ContactSettings')}}</h5>
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
                                        <form class="form" id="basicForm" action= "{{URL::to('admin/updatecontactus')}}" method="POST" enctype="multipart/form-data">
               							 {!! csrf_field() !!}
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" class="form-control" style="direction:ltr;" value="{{$allcontact->title}}" name="title" required>
                                                            <label for="title">{{__('settings.MainEmail')}}</label>
                                                        </div>
                                                    </div>
													<div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" class="form-control" style="direction:ltr;" value="{{$allcontact->ar_title}}" name="ar_title" required>
                                                            <label for="ar_title">{{__('settings.MainPhone')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <textarea class="form-control" style="direction:rtl;" id="basicTextarea" rows="4" name="ar_dsc" required>{{$allcontact->ar_dsc}}</textarea>
                                                            <label for="ar_dsc">{{__('settings.Address')}} {{__('settings.InArabic')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
														<textarea class="form-control" style="direction:ltr;" id="basicTextarea" rows="4" name="dsc" required>{{$allcontact->dsc}}</textarea>
                                                            <label for="dsc">{{__('settings.Address')}} {{__('settings.InEnglish')}}</label>
                                                        </div>
                                                    </div>
													<div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <textarea class="form-control" style="direction:ltr;" id="basicTextarea" rows="4" name="set1" required>{{$allcontact->set1}}</textarea>
                                                            <label for="set1">{{__('settings.CallusNumbers')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <textarea class="form-control" style="direction:rtl;" id="basicTextarea" rows="4" name="ar_set2" required>{{$allcontact->ar_set2}}</textarea>
                                                            <label for="ar_set2">{{__('settings.OpeningTime')}}  {{__('settings.InArabic')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <textarea class="form-control" style="direction:ltr;" id="basicTextarea" rows="4" name="set2" required>{{$allcontact->set2}}</textarea>
                                                            <label for="set2">{{__('settings.OpeningTime')}}  {{__('settings.InEnglish')}}</label>
                                                        </div>
                                                    </div>
													<div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <textarea style="direction:ltr;" class="form-control" id="basicTextarea" rows="4" name="ar_set1" required>{{$allcontact->ar_set1}}</textarea>
                                                            <label for="ar_set1">{{__('settings.GoogleMapRef')}}</label>
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
