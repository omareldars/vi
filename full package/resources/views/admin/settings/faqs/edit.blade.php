@extends('layouts.admin')
@section('title', __('admin.Faqs') )
@section('index_url', route('faqs.index') )
@section('subTitle', __('admin.Edit question'))
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
                                <h4 class="card-title">{{__('admin.Edit Question')}}</h4>
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
                                    <form method="post" action="{{route('faqs.update', ['id' => $faq->id])}}">
                                        {!! csrf_field() !!}
                                        @method('patch')
                                        <div class="row">
                                            <div class="col-md-12">

                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{ __('admin.English Title')}}</label>
                                                    <input style="direction: ltr;" type="text" class="form-control" id="title_en" name='title_en'
                                                           required placeholder="{{__('admin.English Title')}}"
                                                           value="{{ $faq->title_en }}">
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{__('admin.Arabic title')}}</label>
                                                    <input style="direction: rtl;" type="text" class="form-control" id="title_ar" name='title_ar'
                                                           required placeholder="{{__('admin.Arabic title')}}"
                                                           value="{{ $faq->title_ar }}">
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{ __('admin.English Answer')}}</label>
                                                    <input style="direction: ltr;" type="text" class="form-control" id="answer_en" name='answer_en'
                                                           required placeholder="{{__('admin.English Answer')}}"
                                                           value="{{ $faq->answer_en }}">
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{__('admin.Arabic Answer')}}</label>
                                                    <input style="direction: rtl;" type="text" class="form-control" id="answer_ar" name='answer_ar'
                                                           required placeholder="{{__('admin.Arabic Answer')}}"
                                                           value="{{ $faq->answer_ar }}">
                                                </fieldset>
                                                <div class="col-md-12 col-12">
                                                    <div class="custom-control custom-switch custom-control-inline mb-1">
                                                        <span>{{__('settings.Published')}}</span>&nbsp;
                                                        <input value="1" name="published" type="checkbox" class="custom-control-input" id="customSwitch1" {{$faq->published?'checked="checked"':''}} >
                                                        <label class="custom-control-label mr-1" for="customSwitch1">
                                                        </label>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit"
                                                    class="btn btn-primary mr-1 mb-1">{{__('admin.Update')}}</button>
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

@stop
