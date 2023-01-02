@extends('layouts.admin')
@section('title', __('admin.Users') )
@section('index_url', route('users.index') )
@section('subTitle', __('admin.Add new user'))
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
                                <h4 class="card-title">{{__('admin.Add new user')}}</h4>
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
                                    <form method="post" action="{{route('users.store')}}"
                                        enctype="multipart/form-data">
                                        {!! csrf_field() !!}
                                        <div class="row">
                                            <div class="col-md-12">

                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{ __('admin.English Name')}}</label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input  name="first_name_en" type="text"
                                                                class="form-control" id="first_name_en" value="{{old('first_name_en')}}"
                                                                placeholder="{{ __('admin.First Name') }}" required
                                                                autocomplete="first_name_en" autofocus />
                                                        </div>
                                                        <div class="col-md-6">

                                                            <input value="{{old('last_name_en')}}" name="last_name_en" type="text"
                                                                class="form-control" id="last_name_en"
                                                                placeholder="{{ __('admin.Last Name') }}" required
                                                                autocomplete="last_name_en" />
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{__('admin.Arabic Name')}}</label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input value="{{old('first_name_ar')}}" name="first_name_ar" type="text"
                                                                class="form-control" id="first_name_ar"
                                                                placeholder="{{ __('admin.First Name') }}" required
                                                                autocomplete="first_name_ar" autofocus />
                                                        </div>
                                                        <div class="col-md-6">

                                                            <input value="{{old('last_name_ar')}}" name="last_name_ar" type="text"
                                                                class="form-control" id="last_name_ar"
                                                                placeholder="{{ __('admin.Last Name') }}" required
                                                                autocomplete="last_name_ar" />
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <fieldset>
                                                        <ul class="list-unstyled mb-0">
                                                            <li class="d-inline-block mr-2 mb-1">
                                                                <fieldset>
                                                                    <div class="radio">
                                                                        <input type="radio" name="gender" value="Male" id="g1" {{ old('gender')=='Male' ? 'checked=""' :''}} >
                                                                        <label for="g1">{{__('Male')}}</label>
                                                                    </div>
                                                                </fieldset>
                                                            </li>
                                                            <li class="d-inline-block mr-2 mb-1">
                                                                <fieldset>
                                                                    <div class="radio">
                                                                        <input type="radio" name="gender" value="Female" id="g2" {{ old('gender')=='Female' ? 'checked=""' :''}}>
                                                                        <label for="g2">{{__('Female')}}</label>
                                                                    </div>
                                                                </fieldset>
                                                            </li>
                                                        </ul>
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label class="text-bold-600"
                                                        for="exampleInputEmail1">{{ __('admin.Email') }}</label>
                                                    <input value="{{old('email')}}" name="email" type="email" class="form-control"
                                                        id="email" placeholder="{{ __('admin.Email') }}" required
                                                        autocomplete="email">
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label class="text-bold-600"
                                                        for="phone">{{ __('admin.Phone') }}</label>
                                                    <input type="text" class="form-control" id="phone"
                                                        placeholder="{{ __('admin.Phone') }}" value="{{old('phone')}}" name="phone"
                                                        required autocomplete="new-phone">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{ __('admin.Role')}}</label>
                                                    <select class="select2 form-control" required
                                                        id="role" name='role'>
                                                        <option>{{ __('admin.Role')}}</option>
                                                        @foreach($roles as $role)
                                                        <option value="{{$role->name}}" {{old('role')==$role->name?'selected':''}}>{{ __('admin.'.$role->name) }}</option>
                                                        @endforeach
                                                    </select>
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label class="text-bold-600"
                                                        for="password">{{ __('admin.Password') }}</label>
                                                    <input type="password" class="form-control" id="password"
                                                        placeholder="{{ __('admin.Password') }}" name="password"
                                                        required autocomplete="new-password">
                                                </fieldset>

                                                <fieldset class="form-group">
                                                    <label class="text-bold-600"
                                                        for="password-confirm">{{ __('admin.Confirm') }}</label>
                                                    <input type="password" class="form-control" id="password-confirm"
                                                        placeholder="{{ __('admin.Password') }}" name="password_confirmation"
                                                        required autocomplete="new-password">
                                                </fieldset>

                                            </div>
                                        </div>
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
    CKEDITOR.replace('description_ar', {
        language: 'ar'
    });
    CKEDITOR.replace('description_en', {
        language: 'en'
    });

</script>
@stop
