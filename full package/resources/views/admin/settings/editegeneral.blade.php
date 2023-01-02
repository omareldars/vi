@extends('layouts.admin')
<style>
    .form-label-group {
        margin-top: 2rem !important;
    }
</style>
@section('content')
<!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('settings.HomeSettings')}}</h5>
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
                            <form class="form" id="basicForm" action= "{{URL::to('admin/update_settings')}}" method="POST" enctype="multipart/form-data">
                                {!! csrf_field() !!}
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"> {{__('settings.General Settings')}}</h3>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input style="direction: rtl;" type="text" class="form-control" value="{{$Title->ar_title}}" name="site_ar_title" required>
                                                            <label for="site_ar_title">{{__('settings.ARABICWEBSITETITLE')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input style="direction: ltr;" type="text" class="form-control" value="{{$Title->title}}" name="site_title" required>
                                                            <label for="site_title">{{__('settings.ENGLISHWEBSITETITLE')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input style="direction: ltr;" type="text" class="form-control" value="{{$Title->url}}" name="gtag" id="gtag" required>
                                                            <label for="gtag">{{__('settings.Google Analytics Code')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="custom-control custom-switch custom-control-inline mb-1">
                                                            <span>{{__('settings.Enable registration')}}</span>&nbsp;
                                                            <input name="autoact" type="checkbox" class="custom-control-input" id="auto" {{$Title->set_order?'checked="checked"':''}}>
                                                            <label class="custom-control-label mr-1" for="auto">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1">{{__('settings.Submit')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">{{__('settings.SocialMediaLinks')}}</h5>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body">
													@foreach ($Icons as $Icon)
 													<div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input style="direction: ltr;" type="text" class="form-control" value="{{$Icon->url}}" name="{{$Icon->img_url}}">
                                                            <label for="{{$Icon->img_url}}">{{__('settings.URLOF')}} - {{$l=='ar'?$Icon->ar_title:$Icon->title}}</label>
                                                        </div>
                                                    </div>
													@endforeach
                                                        <div class="col-12 d-flex justify-content-end">
                                                            <button type="submit" class="btn btn-primary mr-1 mb-1">{{__('settings.Submit')}}</button>
                                                        </div>
                                            </div>
                                        </div>
                                    </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">{{__('settings.HomeWelcomeImages')}}</h5>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
													<div class="col-md-12 col-12">
                                                        <div class="form-group">
															<label>{{__('settings.1STIMAGE')}}</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="form-control" name="img1" id="img1" accept='image/*'>
                                                                <label class="custom-file-label" for="img1">{{__('settings.Chooseimagefile',['id'=>'1'])}}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input style="direction: rtl;" type="text" class="form-control" value="{{$Img1->ar_title}}" name="ar_img1title" required>
                                                            <label for="ar_img1title">{{__('settings.Image')}} 1 - {{__('settings.ARABICTITLE')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input style="direction: ltr;" type="text" class="form-control" value="{{$Img1->title}}" name="img1title" required>
                                                            <label for="img1title">{{__('settings.Image')}} 1 - {{__('settings.ENGLISHTITLE')}}</label>
                                                        </div>
                                                    </div>
													<div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" style="direction: rtl;" class="form-control" value="{{$Img1->ar_set1}}" name="ar_img1title2" required>
                                                            <label for="ar_img1title2">{{__('settings.Image')}} 1 - {{__('settings.ARABICECONDTITLE')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" style="direction: ltr;" class="form-control" value="{{$Img1->set1}}" name="img1title2" required>
                                                            <label for="img1title2">{{__('settings.Image')}} 1 - {{__('settings.ENGLISHSECONDTITLE')}}</label>
                                                        </div>
                                                    </div>
													<div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" style="direction: rtl;" class="form-control" value="{{$Img1->ar_dsc}}" name="ar_img1dsc" required>
                                                            <label for="ar_img1dsc">{{__('settings.Image')}} 1 - {{__('settings.ARABICDESCRIPTION')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" style="direction: ltr;" class="form-control" value="{{$Img1->dsc}}" name="img1dsc" required>
                                                            <label for="img1dsc">{{__('settings.Image')}} 1 - {{__('settings.ENGLISHDESCRIPTION')}}</label>
                                                        </div>
                                                    </div>
													<div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" style="direction: ltr;" class="form-control" value="{{$Img1->url}}" name="img1url" required>
                                                            <label for="img1url">{{__('settings.Image')}} 1 - {{__('settings.URLOF')}}</label>
                                                        </div>
                                                    </div>
                                                   <div class="col-md-12 col-12">
                                                        <div class="form-group">
															<label>{{__('settings.2NDIMAGE')}}</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="form-control" name="img2" id="img2" accept='image/*'>
                                                                <label class="custom-file-label" for="img2">{{__('settings.Chooseimagefile',['id'=>'2'])}}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" style="direction: rtl;" class="form-control" value="{{$Img2->ar_title}}" id="ar_img2title" name="ar_img2title" required>
                                                            <label for="ar_img2title">{{__('settings.Image')}} 2 - {{__('settings.ARABICTITLE')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" style="direction: ltr;" class="form-control" value="{{$Img2->title}}" name="img2title" id="img2title" required>
                                                            <label for="img2title">{{__('settings.Image')}} 2 - {{__('settings.ENGLISHTITLE')}}</label>
                                                        </div>
                                                    </div>
													<div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" style="direction: rtl;" class="form-control" value="{{$Img2->ar_set1}}" name="ar_img2title2" id="ar_img2title2" required>
                                                            <label for="ar_img2title2">{{__('settings.Image')}} 2 - {{__('settings.ARABICECONDTITLE')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" style="direction: ltr;" class="form-control" value="{{$Img2->set1}}" name="img2title2" id="img2title2" required>
                                                            <label for="img2title2">{{__('settings.Image')}} 2 - {{__('settings.ENGLISHSECONDTITLE')}}</label>
                                                        </div>
                                                    </div>
													<div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" style="direction: rtl;" class="form-control" value="{{$Img2->ar_dsc}}" name="ar_img2dsc" id="ar_img2dsc" required>
                                                            <label for="ar_img2dsc">{{__('settings.Image')}} 2 - {{__('settings.ARABICDESCRIPTION')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" style="direction: ltr;" class="form-control" value="{{$Img2->dsc}}" name="img2dsc" id="img2dsc" required>
                                                            <label for="img2dsc">{{__('settings.Image')}} 2 - {{__('settings.ENGLISHDESCRIPTION')}}</label>
                                                        </div>
                                                    </div>
													<div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" style="direction: ltr;" class="form-control" value="{{$Img2->url}}" name="img2url" id="img2url" required>
                                                            <label for="img2url">{{__('settings.Image')}} 2 - {{__('settings.URLOF')}}</label>
                                                        </div>
                                                    </div>
													<div class="col-md-12 col-12">
                                                        <div class="form-group">
															<label>{{__('settings.3RDIMAGE')}}</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="form-control" name="img3" id="img3" accept='image/*'>
                                                                <label class="custom-file-label" for="img3">{{__('settings.Chooseimagefile',['id'=>'3'])}}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" style="direction: rtl;" class="form-control" value="{{$Img3->ar_title}}" name="ar_img3title" id="ar_img3title" required>
                                                            <label for="ar_img3title">{{__('settings.Image')}} 3 - {{__('settings.ARABICTITLE')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" style="direction: ltr;" class="form-control" value="{{$Img3->title}}" name="img3title" id="img3title" required>
                                                            <label for="img3title">{{__('settings.Image')}} 3 - {{__('settings.ENGLISHTITLE')}}</label>
                                                        </div>
                                                    </div>
													<div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" style="direction: rtl;" class="form-control" value="{{$Img3->ar_set1}}" name="ar_img3title2" id="ar_img3title2" required>
                                                            <label for="ar_img3title2">{{__('settings.Image')}} 3 - {{__('settings.ARABICECONDTITLE')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" class="form-control" style="direction: ltr;" value="{{$Img3->set1}}" name="img3title2" id="img3title2" required>
                                                            <label for="img3title2">{{__('settings.Image')}} 3 - {{__('settings.ENGLISHSECONDTITLE')}}</label>
                                                        </div>
                                                    </div>
													<div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" class="form-control" style="direction: rtl;" value="{{$Img3->ar_dsc}}" name="ar_img3dsc" id="ar_img3dsc" required>
                                                            <label for="ar_img3dsc">{{__('settings.Image')}} 3 - {{__('settings.ARABICDESCRIPTION')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" style="direction: ltr;" class="form-control" value="{{$Img3->dsc}}" name="img3dsc" id="img3dsc" required>
                                                            <label for="img3dsc">{{__('settings.Image')}} 3 - {{__('settings.ENGLISHDESCRIPTION')}}</label>
                                                        </div>
                                                    </div>
													<div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" style="direction: ltr;" class="form-control" value="{{$Img3->url}}" name="img3url" id="img3url" required>
                                                            <label for="img3url">{{__('settings.Image')}} 3 - {{__('settings.URLOF')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1">{{__('settings.Submit')}}</button>
                                                    </div>
                                                </div>
                                            </div>

                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">{{__('settings.Impact Icons')}}</h5>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            @foreach ($Counters as $num=>$Counter)
                                                <div class="col-md-3 col-3">
                                                    <label>{{__('settings.Select Icon')}}  {{$num+1}}</label>
                                                    <fieldset class="form-group">
                                                        <select class="form-control" id="basicSelect" name="ct{{$Counter->id}}icon" required>
                                                            <option value="{{$Counter->img_url}}" selected="">{{$Counter->img_url}}</option>
                                                            <option value="office">office</option>
                                                            <option value="man">man</option>
                                                            <option value="cup">cup</option>
                                                            <option value="professor">professor</option>
                                                            <option value="multimedia">multimedia </option>
                                                            <option value="people">people </option>
                                                            <option value="science">science</option>
                                                            <option value="technology">technology</option>
                                                            <option value="book">book</option>
                                                        </select>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-6 col-6">
                                                    <div class="form-label-group">
                                                        <input  type="text" class="form-control" value="{{$Counter->title}}" name="ct{{$Counter->id}}title">
                                                        <label for="ct{{$Counter->id}}title">{{__('settings.TITLEOF - ICON')}} {{$num+1}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-6">
                                                    <div class="form-label-group">
                                                        <input  type="text" class="form-control" value="{{$Counter->ar_title}}" name="ct{{$Counter->id}}titlear">
                                                        <label for="ct{{$Counter->id}}titlear">{{__('settings.ARTITLEOF - ICON')}}  {{$num+1}}</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-6">
                                                    <div class="form-label-group">
                                                        <input  type="text" class="form-control" value="{{$Counter->dsc}}" name="ct{{$Counter->id}}num">
                                                        <label for="ct{{$Counter->id}}num">{{__('settings.NUMBER - ICON')}} {{$num+1}}</label>
                                                    </div>
                                                </div>
                                                <hr style="padding: 5px;">
                                            @endforeach
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">{{__('settings.Submit')}}</button>
                                            </div>
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
