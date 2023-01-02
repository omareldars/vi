@extends('layouts.admin')
@section('title', __('admin.Dashboard') )
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        @include('admin.includes.heading')
        <div class="content-header row">
        </div>
        <div class="content-body">
		<div class="col-xl-12 col-md-12 col-12 dashboard-greetings">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="greeting-text">{{__('admin.Manage your files')}}!</h3>
                                    <h6>{{__('admin.FileManagerRules')}}.</h6>
                                </div>
                                <div class="card-content" style="margin-top: 0;">
                                    <div class="card-body">
                                         <iframe src="/filemanager" style="height:700px;width:100%;border:none;"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
        </div>
    </div>
</div>
<!-- END: Content-->
@stop