@extends('layouts.admin')
@section('title', __('admin.Rooms') )
@section('index_url', route('users.index'))
@section('subTitle', __('admin.Room images Managment'))
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            @include('admin.includes.heading')
            <div class="content-body">
                <!-- BuilderForm start -->
                <section id="basic-input">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{__('Room images Managment')}}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        @if(session()->has('msg'))
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="alert alert-warning alert-danger mb-2" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        <div class="d-flex align-items-center">
                                                            <i class="bx bx-error"></i>
                                                            <span>
                                                        {{ __('admin.'.session()->get('msg')) }}
                                                                {{ Session::forget('msg') }}
                                                    </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    <!-- Validation messages -->
                                        @if(count($errors) >0)
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach($errors->all() as $error)
                                                                <li>{{ $error }} </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                            <div class="modal-body">
                                                            <!-- Nav Justified Starts -->
                                                            <section id="nav-justified">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="card">
                                                                            <div class="card-header">
                                                                                <h4 class="card-title">{{__('Room images')}}</h4>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <p>
                                                                                    {{__('You can add more and /or delete images from here.')}}
                                                                                </p>
                                                                                <ul class="nav nav-tabs nav-justified" id="myTab2" role="tablist">
                                                                                    <li class="nav-item">
                                                                                        <a class="nav-link active" id="home-tab-justified" data-toggle="tab" href="#home-just" role="tab" aria-controls="home-just" aria-selected="true">
                                                                                            {{__('Delete images')}}
                                                                                        </a>
                                                                                    </li>
                                                                                    <li class="nav-item">
                                                                                        <a class="nav-link" id="profile-tab-justified" data-toggle="tab" href="#profile-just" role="tab" aria-controls="profile-just" aria-selected="true">
                                                                                            {{__('Add more images')}}
                                                                                        </a>
                                                                                    </li>

                                                                                </ul>
                                                                                <!-- Tab panes -->
                                                                                <div class="tab-content pt-1">
                                                                                    <div class="tab-pane active" id="home-just" role="tabpanel" aria-labelledby="home-tab-justified">
                                                                                        <div class="col-md-12">
                                                                                            <div class="row">
                                                                                           @foreach($roomImages AS $roomImage)
                                                                                            <div class="col-md-3">
                                                                                                <img class="round" src="/191014/{{$roomImage->img_url}}"
                                                                                                     height="150" width="100%"/>
                                                                                               <a style="display:block;text-align: center;margin-top: 10px;" href="{{route('deleteImages', ['id' => $roomImage->id])}}">Delete</a>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    </div>
                                                                                    </div>
                                                                                    </div>
                                                                                    <div class="tab-pane" id="profile-just" role="tabpanel" aria-labelledby="profile-tab-justified">

                                                                                        <form method="post" action="{{route('rooms.update', ['id' => $id])}}"
                                                                                              enctype="multipart/form-data">
                                                                                            {!! csrf_field() !!}
                                                                                            {{ method_field('PATCH') }}


                                                                                            <fieldset class="form-group">
                                                                                                <div class="col-md-6 col-6">
                                                                                                    <label class="text-bold-600">{{__('settings.Image')}}</label>
                                                                                                    <div class="custom-file">
                                                                                                        <input type="file" class="form-control" name="image[]" id="image" accept='image/*' multiple>
                                                                                                        <label class="text-bold-600" for="image">{{__('settings.Browse')}}</label>
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="row">
                                                                                                    <div class="col-12 d-flex justify-content-end">
                                                                                                        <button type="submit"
                                                                                                                class="btn btn-primary mr-1 mb-1">{{__('admin.Save')}}</button>
                                                                                                    </div>
                                                                                                </div>
                                                                                        </form>
                                                                                        </p>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </section>
                                                            <!-- Nav Justified Ends -->

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- BuilderForm end -->
            </div>
        </div>
    </div>
    <!-- END: Content-->
@stop
@section('pagescripts')
    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace('desc_ar', {
            language: 'ar'
        });
        CKEDITOR.replace('desc_en', {
            language: 'en'
        });

    </script>
@stop
