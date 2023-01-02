@extends('layouts.admin')
<?php
$title=App\BuilderForm::findOrFail($id);
?>
@section('style')
<style>
    * {
        font-family: 'Rubik', Cairo, Arial, serif ;

    }
    .section {
        padding: 0 30px;
    }
</style>
@stop
@section('title', __('builder.Forms builder') )
@section('subTitle', __('builder.Preview'))
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <section>
                <div class="row">
            <div class="col-xl-12 col-md-12 col-sm-12">
                <div class="card">
                        <div class="card-header" style="padding-bottom: 0px;">
                            <h4 class="card-title"><b>{{__('builder.Form')}}: </b>{{$title->form_name}}, <b>{{__('builder.ID')}}: </b> {{$title->id}} <a href="/admin/show-builder/{{$id}}">({{__('builder.Edit')}})</a>.</h4>

                        </div>
                    <hr>
                    <div class="card-body">
                        @if(count($fields) > 0)
                            <form action="{{ route('submit.form') }}" method="post">
                                @csrf
                                <input type="hidden" name="builder_form_id" value="{{ $id }}" />
                                <input type="hidden" name="field_ids" value="{{ $field_ids }}" />

                                @foreach($fields as $field)
                                    @php
                                        $options = $field->pivot->options? json_decode($field->pivot->options) : null;
                                        $field_name = 'field_' . $field->pivot->id;
                                        $id_for = 'input-fld-'. $loop->iteration;
                                    @endphp

                                    <div class="form-group">
                                        @if($options->label)
                                            <label for="{{ $id_for }}">{{ $options->label }}</label>
                                        @endif

                                        @switch($field->field_type)
                                            @case("select")
                                            <select id="{{ $id_for }}" name={{ $field_name }} class="custom-select @error($field_name) is-invalid @enderror">
                                            <option value="">{{$l=='ar'?'اختر':'Choose'}}...</option>
                                            @foreach(explode(",", $options->values) as $value)
                                                <option value="{{ trim($value) }}" {{ old($field_name) == trim($value)? "selected" : "" }}>{{ trim($value) }}</option>
                                                @endforeach
                                                </select>
                                                @break

                                                @case("textarea")
                                                <textarea class="form-control @error($field_name) is-invalid @enderror" id="{{ $id_for }}" name={{ $field_name }} rows={{ $options->rows }}>{{ old($field_name) }}</textarea>
                                                @break

                                                @default
                                                <input type="{{ $options->type == "date" ? "text" : $options->type }}" class="form-control {{ $options->type == "date"? "datepicker" : "" }} @error($field_name) is-invalid @enderror" name={{ $field_name }} id="{{ $id_for }}" value="{{ old($field_name) }}" />
                                                @endswitch

                                                @error($field_name)
                                                <div class="invalid-feedback">
                                                    {{ $errors->first($field_name) }}
                                                </div>
                                                @enderror
                                    </div>
                                @endforeach
                                <div class="form-group">
                                    <button class="btn btn-primary">
                                        <i class="bx bx-paper-plane" aria-hidden="true"></i> {{$l=='ar'?'ارسال':'Submit'}}
                                    </button>
                                    <button class="btn btn-warning" type="button" onclick="location.href='/admin/show-builder/{{ $id }}';">
                                        <i class="bx bx-arrow-back" aria-hidden="true"></i> {{$l=='ar'?'تحرير':'Edit'}}
                                    </button>
                                </div>

                            </form>
                        @endif
                    </div>
                </div>
            </div>
                </div>
            </section>
        </div>
    </div>
</div>
@stop

