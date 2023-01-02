@extends('layouts.admin')
@section('title', __('admin.press') )
@section('index_url', route('press.index') )
@section('subTitle', __('admin.Add new press'))
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
                                <h4 class="card-title">{{__('admin.Add new press')}}</h4>
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
                                    <form method="post" action="{{route('press.store')}}"  enctype="multipart/form-data">
                                        {!! csrf_field() !!}
                                        <div class="row">
                                            <div class="col-md-12">

                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{ __('admin.English Title')}}</label>
                                                    <input style="direction: ltr;" type="text" class="form-control" id="en_title" name='en_title'
                                                        required placeholder="{{__('admin.English Title')}}"
                                                        value="{{ old('en_title') }}">
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{__('admin.Arabic Title')}}</label>
                                                    <input style="direction: rtl;" type="text" class="form-control" id="ar_title" name='ar_title'
                                                        required placeholder="{{__('admin.Arabic Title')}}"
                                                        value="{{ old('ar_title') }}">
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{ __('admin.URL')}}</label>
                                                    <input style="direction: ltr;" type="text" class="form-control" id="url" name='url'
                                                            placeholder="{{__('admin.URL')}}"
                                                           value="{{ old('url') }}">
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{__('admin.Order')}}</label>
                                                    <input type="text" class="form-control" id="order" name='order'
                                                           required placeholder="{{__('admin.Order')}}"
                                                           value="{{ old('order') }}">
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
                                                                for="inputGroupFile01">Choose file</label>
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
