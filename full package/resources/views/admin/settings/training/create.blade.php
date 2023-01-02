@extends('layouts.admin')
@section('title', __('admin.Services') )
@section('index_url', route('services.index') )
@section('subTitle', __('admin.Add new service'))
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
                                <h4 class="card-title">{{__('admin.Add new service')}}</h4>
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
                                    <form method="post" action="{{route('services.store')}}"  enctype="multipart/form-data">
                                        {!! csrf_field() !!}
                                        <div class="row">
                                            <div class="col-md-12">

                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{ __('admin.English Name')}}</label>
                                                    <input style="direction: ltr;" type="text" class="form-control col-md-6 col-sm-12" id="name_en" name='name_en'
                                                        required placeholder="{{__('admin.English Name')}}"
                                                        value="{{ old('name_en') }}">
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{__('admin.Arabic Name')}}</label>
                                                    <input style="direction: rtl;" type="text" class="form-control col-md-6 col-sm-12" id="name_ar" name='name_ar'
                                                        required placeholder="{{__('admin.Arabic Name')}}"
                                                        value="{{ old('name_ar') }}">
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{__('admin.Price')}}</label>
                                                    <input style="direction: ltr;" type="text" class="form-control col-md-3 col-sm-12" id="price" name='price'
                                                           required placeholder="{{__('admin.Price in EGP')}}"
                                                           value="{{ old('price') }}">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{ __('admin.English Description')}}</label>
                                                    <textarea class="form-control" id="basicTextarea" name='description_en'
                                                        required placeholder="{{__('admin.English Description')}}"
                                                        value="{{ old('description_en') }}"></textarea>
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{__('admin.Arabic Description')}}</label>
                                                    <textarea class="form-control" id="description_ar" name='description_ar'
                                                        required placeholder="{{__('admin.Arabic Description')}}"
                                                        value="{{ old('description_ar') }}"></textarea>
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{ __('admin.Services Categories')}}</label>
                                                    <select class="select2 form-control" required
                                                        id="service_category_id" name='service_category_id'>
                                                        <option value="">{{ __('admin.Services Categories')}}</option>
                                                        @foreach($serviceCategories as $category)
                                                        <option value="{{$category->id}}"
                                                            {{ (old('service_category_id') == $category->id ? "selected":"") }}>
                                                            {{$category->{'name_'.$l} }}</option>
                                                        @endforeach
                                                    </select>
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{ __('admin.Image')}}</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"
                                                                id="inputGroupFileAddon01">Upload</span>
                                                        </div>
                                                        <div class="custom-file">
                                                            <input type="file" required class="custom-file-input"
                                                                id="img_url" name="img_url" accept="image/*"
                                                                aria-describedby="inputGroupFileAddon01">
                                                            <label class="custom-file-label"
                                                                for="inputGroupFile01">{{__('admin.SelectFile')}}</label>
                                                        </div>
                                                    </div>

                                                </fieldset>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit"
                                                    class="btn btn-primary mr-1 mb-1">{{__('admin.Save')}}</button>
                                            </div>
                                        </div>
                                </div>
                                </form>
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
    CKEDITOR.replace( 'description_ar',{language: 'ar'} );
    CKEDITOR.replace( 'description_en',{language: 'en'});
</script>
@stop
