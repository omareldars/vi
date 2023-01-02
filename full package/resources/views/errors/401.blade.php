@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message')
{{__('Unauthorized')}}, <a href="/">{{__('BACK TO HOME')}}</a></div>
@stop
