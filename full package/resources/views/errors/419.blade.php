@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')

@section('message')
{{__('Page Expired')}}, <a href="/">{{__('BACK TO HOME')}}</a></div>
@stop