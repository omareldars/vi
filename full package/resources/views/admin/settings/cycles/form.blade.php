@extends('layouts.admin')
@section('style')
    <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.min.css">
@stop
@section('title', __('cycles.Cycle') )
@section('subTitle', __('cycles.join Cycle'))
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
                                    <div class="card-header">
                                        <h4 class="card-title">{{$step->title}}</h4>
                                        <p>{{$step->description}}</p>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
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

                                                @if(count($fields) > 0)
                                        <form method="post" action="/admin/cycles/save" enctype="multipart/form-data">
                                            {!! csrf_field() !!}
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="hidden" name="cycle" value="{{$c}}" />
                                                    <input type="hidden" name="id" value="{{$step->id}}" />
                                                    <input type="hidden" name="field_ids" value="{{ $field_ids }}" />
                                                    @foreach($fields as $field)
                                                        @php
                                                            $options = $field->pivot->options? json_decode($field->pivot->options) : null;
                                                            $field_name = 'field_' . $field->pivot->id;
                                                            $id_for = 'input-fld-'. $loop->iteration;
                                                            $answer = $answers[$loop->iteration-1]??null;
                                                        @endphp
                                                    <fieldset class="form-group">
                                                        @if($options->label)
                                                        <label for="{{ $id_for }}">{{ $options->label }}</label>
                                                        @endif
                                                        @switch($field->field_type)
                                                                @case("select")
                                                                    <select class="form-control" required
                                                                            id="{{ $id_for }}" name='{{ $field_name }}'>
                                                                        <option value="">{{$l=='ar'?'اختر':'Choose'}}...</option>
                                                                        @foreach(explode(",", $options->values) as $value)
                                                                            <option value="{{ trim($value) }}" {{ old($field_name) == trim($value)? "selected" : "" }} {{trim($value)==$answer?'selected':''}}>{{ trim($value) }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                @break
                                                                @case("textarea")
                                                                <textarea  class="form-control @error($field_name) is-invalid @enderror" id="{{ $id_for }}" name={{ $field_name }}
                                                                        rows={{ $options->rows }}>{{ old($field_name) }}{{$answer}}</textarea>
                                                                @break
                                                                @case("file")
                                                                <div class="input-group">
                                                                    <input readonly style="direction: ltr" value="{{ old($field_name) }}{{$answer}}"
                                                                           name="{{ $field_name }}" type="text" class="form-control" placeholder="{{ __('admin.SelectFile')}}"
                                                                           aria-describedby="button-addon2"
                                                                           id="thumbnail"
                                                                           placeholder="{{ __('admin.CompanyLogo') }}"
                                                                           autocomplete="logo" />
                                                                    <div class="input-group-append" id="button-addon2">
                                                                        <button id="logo" data-input="thumbnail" data-preview="holder" class="btn btn-primary" type="button">{{ __('admin.SelectFile')}}</button>
                                                                    </div>
                                                                </div>
                                                                @break
                                                                @default
                                                                <input type="{{$options->type=="date"?"text":$options->type}}" class="form-control {{ $options->type == "date"? "datepicker" : "" }}
                                                                @error($field_name) is-invalid @enderror" id="{{$id_for}}" name={{ $field_name }} value="{{ old($field_name) }}{{$answer}}" />
                                                            @endswitch
                                                            @error($field_name)
                                                            <div class="invalid-feedback">
                                                                {{ $errors->first($field_name) }}
                                                            </div>
                                                            @enderror
                                                    </fieldset>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-end">
                                                    <button type="submit"
                                                            class="btn btn-primary mr-1 mb-1">{{__('admin.Update')}}</button>
                                                </div>
                                            </div>
                                        </form>
                                                @else
                                            {{__('cycles.No Fields')}}
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

    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="/js/jquery.datetimepicker.full.min.js"></script>
    <script>
        var route_prefix = "/filemanager";
        $('#logo').filemanager(['image','document']);
        $('.datepicker').datetimepicker({timepicker:false,format:'Y-m-d'});
    </script>
@stop
