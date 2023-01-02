@extends('layouts.admin')
@section('title', __('admin.Users') )
@section('index_url', route('users.index'))
@section('subTitle', __('Add new room'))
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
                                    <h4 class="card-title">{{__('Add new room')}}</h4>
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
                                        <form method="post" action="{{route('rooms.store')}}"
                                              enctype="multipart/form-data">
                                            {!! csrf_field() !!}
                                            <div class="col-md-12">
                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{ __('admin.English Name')}}</label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input value="" name="name_en" type="text"
                                                                   class="form-control" id="name_en"
                                                                   placeholder="{{ __('admin.Room Name English') }}" required
                                                                   autocomplete="room_name_en" autofocus />
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input value="" name="name_ar" type="text"
                                                                   class="form-control" id="name_ar"
                                                                   placeholder="{{ __('admin.Room Name Arabic') }}" required
                                                                   autocomplete="name_ar" />
                                                        </div>
                                                    </div>
                                                </fieldset>

                                                        <fieldset class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <input value="" name="price" type="text"
                                                                           class="form-control" id="price"
                                                                           placeholder="{{ __('admin.Price') }}" required
                                                                           autocomplete="price" autofocus />
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input value="" name="discount" type="text"
                                                                           class="form-control" id="discount"
                                                                           placeholder="{{ __('admin.Discount') }}"
                                                                           autocomplete="discount" />
                                                                </div>
                                                            </div>
                                                        </fieldset>


                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{ __('admin.Room Type')}}</label>
                                                    <select class="select2 form-control" required
                                                            id="type_trans" name='type_trans'>
                                                        <option value="{{ __('admin.Meeting')}}">{{ __('admin.Meeting')}}</option>
                                                        <option value="{{ __('admin.One to One')}}">{{ __('admin.One to One')}}</option>
                                                        <option value="{{ __('admin.Class Room')}}">{{ __('admin.Class Room')}}</option>
                                                    </select>
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label  for="inclusives">{{ __('inclusive') }}</label>

                                                    <select class="form-control select2"
                                                            name="inclusives[]" id="inclusives" multiple >
                                                        <option value=""></option>
                                                        @foreach($inclusives as $inclusive)
                                                            <option value="{{$inclusive->id}}">{{$inclusive->ar_title}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('$inclusives'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('$inclusives') }}
                                                        </div>
                                                    @endif

                                                </fieldset>

                                                    <fieldset class="form-group">
                                                        <label class="text-bold-600"
                                                               for="video_link">{{ __('admin.Video URL') }}</label>
                                                        <input type="text" class="form-control" id="video_link"
                                                               placeholder="{{ __('admin.Video URL') }}" name="video_link"
                                                               required autocomplete="new-Video URL">
                                                    </fieldset>

                                                <fieldset class="form-group">
                                                    <label class="text-bold-600"
                                                           for="desc_en">{{ __('admin.English Description') }}</label>
                                                        <textarea class="form-control" id="basicTextarea" rows="8" name="desc_en" required></textarea>
                                                </fieldset>
                                                    <fieldset class="form-group">
                                                        <label class="text-bold-600"
                                                               for="desc_ar">{{ __('admin.Araic Description') }}</label>
                                                        <textarea class="form-control" id="basicTextarea" rows="8" name="desc_ar" required></textarea>
                                                    </fieldset>

                                                        <fieldset class="form-group">
                                                <div class="col-md-6 col-6">
                                                        <label class="text-bold-600">{{__('settings.Image')}}</label>
                                                        <div class="custom-file">
                                                            <input type="file" class="form-control" name="image" id="image[]" accept='image/*' multiple required>
                                                            <label class="text-bold-600" for="image">{{__('settings.Browse')}}</label>
                                                        </div>
                                                </div>
                                                        </fieldset>
                                                            <fieldset class="form-group">
                                                    <div class="custom-control custom-switch custom-control-inline mb-1">
                                                        <span class="text-bold-600">{{__('settings.Published')}}</span>&nbsp;
                                                        <input name="published" type="checkbox" class="custom-control-input" id="customSwitch1">
                                                        <label class="custom-control-label mr-1" for="customSwitch1">
                                                        </label>

                                            </div>
                                             </fieldset>
                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-end">
                                                    <button type="submit"
                                                            class="btn btn-primary mr-1 mb-1">{{__('admin.Save')}}</button>
                                                </div>
                                            </div>
                                        </form>
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
