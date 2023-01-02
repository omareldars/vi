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
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('settings.Pagesettings')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/admin/pages"><i class="bx bx-briefcase"></i></a>
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
                <section id="multiple-column-form">
                    <div class="row match-height">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form" id="basicForm" action= "/admin/updatepage/{{$getpage->id}}" method="post" enctype="multipart/form-data">
               							 {!! csrf_field() !!}
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input style="direction: rtl;" type="text" class="form-control" value="{{$getpage->ar_title}}" name="ar_title" required>
                                                            <label for="ar_title">{{__('settings.ARABICTITLE')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input style="direction: ltr;" type="text" class="form-control" value="{{$getpage->title}}" name="title" required>
                                                            <label for="title">{{__('settings.ENGLISHTITLE')}}</label>
                                                        </div>
                                                    </div>
													<div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input style="direction: ltr;" type="text" class="form-control" value="{{$getpage->url}}" name="url" required>
                                                            <label for="url">{{__('settings.URL')}}</label>
                                                        </div>
                                                    </div>
                                                     <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <textarea class="form-control" id="basicTextarea" rows="8" name="ar_body" required>{{$getpage->ar_body}}</textarea>
                                                            <label for="ar_body">{{__('settings.Content')}} {{__('settings.InArabic')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <textarea class="form-control" id="basicTextarea" rows="8" name="body" required>{{$getpage->body}}</textarea>
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
                                                    <div class="col-md-12 col-12">
                                                    <fieldset class="form-group">
                                                        <h6>{{ __('admin.AssignUsers') }}</h6>
                                                        <div class="form-group">
                                                            <select name='users_ids[]'
                                                                    class="select2 form-control"
                                                                    multiple="multiple" >
                                                                        @php($uids = App\User::where('PageId',$getpage->id)->pluck('id')->toArray())
                                                                        @foreach(App\user::join('model_has_roles','id','model_id')->where('role_id',4)->get(['id','first_name_en','last_name_en']) as $user)
                                                                            <option value="{{$user->id}}" {{ in_array($user->id,$uids) ? 'selected':'' }} >
                                                                               {{$user->first_name_en." ".$user->last_name_en." id:".$user->id}}
                                                                            </option>
                                                                        @endforeach
                                                            </select>
                                                        </div>
                                                    </fieldset>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="custom-control custom-switch custom-control-inline mb-1">
                                                        <span>{{__('settings.Published')}}</span>&nbsp;
                                                        <input name="published" type="checkbox" class="custom-control-input" id="customSwitch1" {{$getpage->published?'checked="checked"':''}} >
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
@section('pagescripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/ckeditor/4.5.11/ckeditor.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/ckeditor/4.5.11/adapters/jquery.js"></script>
    <script>
        var route_prefix = "/filemanager";
    </script>
    <script>
        $('textarea[name=ar_body]').ckeditor({
            height: 250,
            filebrowserImageBrowseUrl: route_prefix + '?type=Images',
            filebrowserImageUploadUrl: route_prefix + '/upload?type=Images&_token={{csrf_token()}}',
            filebrowserBrowseUrl: route_prefix + '?type=Files',
            filebrowserUploadUrl: route_prefix + '/upload?type=Files&_token={{csrf_token()}}',
            language: 'ar'
        });
        $('textarea[name=body]').ckeditor({
            height: 250,
            filebrowserImageBrowseUrl: route_prefix + '?type=Images',
            filebrowserImageUploadUrl: route_prefix + '/upload?type=Images&_token={{csrf_token()}}',
            filebrowserBrowseUrl: route_prefix + '?type=Files',
            filebrowserUploadUrl: route_prefix + '/upload?type=Files&_token={{csrf_token()}}',
            language: 'en'
        });
    </script>
@stop
