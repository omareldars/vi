@extends('layouts.admin')
@section('style')
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/forms/spinner/jquery.bootstrap-touchspin.css">
@endsection
@section('title', __('admin.Screening') )
@section('subTitle', __('admin.Company'))
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            @include('admin.includes.heading')
            <div class="content-body">
                    <section id="basic-input">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                    <dl class="row">
                                        <dt class="col-sm-3">
                                            {{__('admin.Company')}}
                                        </dt>
                                        <dd class="col-sm-9">
                                            <a class="media-left mr-50" href="/admin/companyProfile/{{$company->id}}">
                                                <img src="/191014/{{$company->logo??'../app-assets/images/logo_placeholder.png'}}" alt="avatar" class="rounded-circle" height="40" width="40">
                                                <div class="media-body">
                                                    <h6 class="media-heading mb-0">{{$company->{'name_'.$l} }} </h6>
                                                    <span class="font-small-2">{{$company->{'title_'.$l} }}</span>
                                                </div>
                                            </a>
                                        </dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-sm-3">
                                           {{__('admin.Added by')}}
                                        </dt>
                                        <dd class="col-sm-9">
                                            <a class="media-left mr-50" href="/admin/companyProfile/{{$company->id}}">
                                                <img src="/191014/{{$company->user->img_url}}" alt="avatar" class="rounded-circle" height="40" width="40">

                                                <div class="media-body">
                                                    <h6 class="media-heading mb-0">{{$company->user->{'first_name_'.$l} }} {{$company->user->{'last_name_'.$l} }}</h6>
                                                    <span class="font-small-2">{{$company->user->{'title_'.$l} }}</span>
                                                </div></a>
                                        </dd>
                                    </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">{{__('admin.Review company inputs and screening')}}</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <br>
                                            @if(session()->has('msg'))
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="alert alert-{{Session::get('class')}} alert-dismissible  mb-2" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            <div class="d-flex align-items-center">
                                                                <i class="bx bx-{{Session::get('class')=='success'?'check-circle':'error'}}"></i>
                                                                <span>
                                                        {{ __('admin.'.session()->get('msg')) }}
                                                                    {{ Session::forget('msg') }}
                                                    </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                                @if(count($answers) > 0)
                                        <form method="post" action="/admin/screening/save" enctype="multipart/form-data">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="company_id" value="{{$answers->pluck(['company_id'])->first()}}" />
                                            <input type="hidden" name="form_id" value="{{$answers->pluck(['form_id'])->first()}}" />
                                            <div class="row">
                                                <div class="col-md-12">
                                                    @foreach($answers as $answer)
                                                        @php
                                                        $usr = Auth::id();
                                                        if (isset($answer->screening[$usr])) {
                                                        $screening = $answer->screening[$usr]??0;
                                                        $comment = $answer->comments[$usr]??null; } else {$screening=0;$comment=null;}
                                                        @endphp
                                                    <dl class="row">
                                                        <dt class="col-sm-3 text-bold-600">{{$answer->question}}
                                                            <small onclick="showcom({{$answer->field_id}})" class="float-right">{{__('admin.Add comment')}}</small><br>
                                                            <button onclick="showcom({{$answer->field_id}})" type="button" title="{{__('admin.Add comment')}}" class="btn btn-sm btn-success float-right"><i class="bx bx-comment"></i> </button>
                                                        </dt>
                                                        <dd class="col-sm-7">
                                                        @if(substr($answer->answer,0,4)=='http')
                                                        <a target="_blank" href="{{$answer->answer}}">{{__('admin.Download File')}}</a>
                                                        @else
                                                                {{$answer->answer}}
                                                        @endif
                                                            <fieldset class="form-group">
                                                                <br>
                                                                <input name="c{{$answer->field_id}}" id="com{{$answer->field_id}}" value="{{$comment}}" style="{{$comment?'':'display:none'}};" type="text" class="form-control" id="basicInput" placeholder="{{__('admin.Add your comments')}}">
                                                            </fieldset>
                                                        </dd>
                                                        <dd class="col-sm-2"> <input name="w{{$answer->field_id}}" type="number" class="touchspin-min-max" value="{{$screening??0}}"></dd>
                                                    </dl>
                                                    <hr>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-end">
                                                    <button type="submit"
                                                            class="btn btn-primary mr-1 mb-1">{{__('admin.submit')}}</button>
                                                    <a href="/admin"
                                                            class="btn btn-warning mr-1 mb-1">{{__('admin.Back')}}</a>
                                                </div>
                                            </div>
                                        </form>
                                                @else
                                                    {{__('admin.No Fields')}}
                                                @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@stop
@section('pagescripts')
    <script src="/app-assets/vendors/js/forms/spinner/jquery.bootstrap-touchspin.js"></script>
    <script>
        $(document).ready(function() {
            var touchspinValue = $(".touchspin-min-max"),
                counterMin = 0,
                counterMax = 10;
            if (touchspinValue.length > 0) {
                touchspinValue.TouchSpin({
                    min: counterMin,
                    max: counterMax,
                }).on('touchspin.on.startdownspin', function () {
                    var $this = $(this);
                    $('.bootstrap-touchspin-up').removeClass("disabled-max-min");
                    if ($this.val() == counterMin) {
                        $(this).siblings().find('.bootstrap-touchspin-down').addClass("disabled-max-min");
                    }
                }).on('touchspin.on.startupspin', function () {
                    var $this = $(this);
                    $('.bootstrap-touchspin-down').removeClass("disabled-max-min");
                    if ($this.val() == counterMax) {
                        $(this).siblings().find('.bootstrap-touchspin-up').addClass("disabled-max-min");
                    }
                });
            }
        });
        function showcom(com) {
            let obj= $('#com'+com);
            obj.toggle();
        }
    </script>
@stop
