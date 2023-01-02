@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message')
{{__('Server Error')}}, <a href="/">{{__('BACK TO HOME')}}</a></div>
@stop
