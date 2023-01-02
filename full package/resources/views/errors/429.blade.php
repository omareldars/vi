@extends('errors::minimal')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('message')
{{__('Too Many Requests')}}, <a href="/">{{__('BACK TO HOME')}}</a></div>
@stop

