@extends('layouts.admin')
@section('style')
    <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.min.css">
@stop
@section('title', __('admin.Calendar') )
@section('index_url', '/admin/calendar' )
@section('subTitle', __('admin.Edit event'))
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
                                <h4 class="card-title">{{__('admin.Edit calendar')}}</h4>
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
                                    <form method="post" action="/admin/calendar/{{$cal->id}}/update">
                                        {!! csrf_field() !!}
                                        <div class="row">
                                            <div class="col-md-12">

                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{ __('admin.Title')}}</label>
                                                    <input type="text" class="form-control" id="title" name='title'
                                                           required placeholder="{{__('admin.English Title')}}"
                                                           value="{{ $cal->title }}">
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{__('admin.Body')}}</label>
                                                    <textarea type="text" class="form-control" id="body" name='body' rows="3"
                                                           required placeholder="{{__('admin.Body')}}">{{ $cal->body }}</textarea>
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{ __('admin.Start')}}</label>
                                                    <input type="text" class="form-control" id="start" name='start'
                                                           required placeholder="{{__('admin.Start')}}"
                                                           value="{{ $cal->start }}">
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{__('admin.End')}}</label>
                                                    <input type="text" class="form-control" id="end" name='end'
                                                           required placeholder="{{__('admin.End')}}"
                                                           value="{{ $cal->end }}">
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{__('admin.Color')}}</label>
                                                    <input type="color" id="color" name="color" value="{{ $cal->color }}">
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <div class="custom-control custom-switch custom-control-inline mb-1">
                                                        <span>{{__('admin.All Day')}}</span>&nbsp;
                                                        <input name="allDay" type="checkbox" class="custom-control-input" id="customSwitch1" {{$cal->allDay?'checked="checked"':''}}>
                                                        <label class="custom-control-label mr-1" for="customSwitch1">
                                                        </label>
                                                    </div>
                                                </fieldset>
                                                @can ('edit_calendar')
                                                <fieldset class="form-group">
                                                    <div class="custom-control custom-switch custom-control-inline mb-1">
                                                        <span>{{__('admin.Private')}}</span>&nbsp;
                                                        <input name="isPrivate" type="checkbox" class="custom-control-input" id="customSwitch2" {{$cal->isPrivate?'checked="checked"':''}}>
                                                        <label class="custom-control-label mr-1" for="customSwitch2">
                                                        </label>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <h6><b>{{__('admin.Last edited by')}}:</b> {{ $cal->user->first_name_en . " ". $cal->user->last_name_en }} </h6>
                                                </fieldset>
                                                @endcan
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit"
                                                    class="btn btn-primary mr-1 mb-1">{{__('admin.Update')}}</button>
                                                <a onclick="return confirm('{{__('admin.Sure del cal')}}');" href="{{URL::to('admin/calendar/'.$cal->id.'/delete')}}" >
                                                    <button type="button" class="btn btn-danger mr-1 mb-1">{{__('admin.Delete')}}</button> </a>
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
    <script src="/js/jquery.datetimepicker.full.min.js"></script>
    <script>
        $('#start,#end').datetimepicker({format:'Y-m-d H:i'});
    </script>
@stop
