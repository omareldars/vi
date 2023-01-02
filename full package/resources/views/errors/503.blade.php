@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message')
{{__($exception->getMessage() ?: 'Service Unavailable')}}, <a href="/">{{__('BACK TO HOME')}}</a></div>
@stop

