@extends('layouts.admin')
@section('style')
<link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/tables/datatable/datatables.min.css">
@stop
@section('title', __('audit.Portal Log') )
@section('subTitle', __('audit.Log record'))
@section('index_url', '/admin/audit-logs')
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
    @include('admin.includes.heading')
        <div class="content-body">
            <div class="row">
                <!-- invoice view page -->
                <div class="col-xl-12 col-md-12 col-12">
                    <div class="card">
                        <div class="card-body pb-0 mx-25">
                            <!-- header section -->
                            <div class="row">
                                <div class="col-lg-4 col-md-12">
                                    <h3 class="mr-50">{{__('audit.log')}} # {{ $auditLog->id }}</h3>
                                </div>
                                <div class="col-lg-8 col-md-12">
                                    <div class="d-flex align-items-center justify-content-lg-end flex-wrap">
                                        <div>
                                            <small class="text-muted">{{__('audit.created_at')}}</small>
                                            <span> {{ $auditLog->created_at }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- product details table-->
                        <div class="invoice-product-details table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                <tr>
                                    <th>
                                        {{ __('audit.description') }}
                                    </th>
                                    <td>
                                        {{ $auditLog->description }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ __('audit.subject_id') }}
                                    </th>
                                    <td>
                                        {{ $auditLog->subject_id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ __('audit.subject_type') }}
                                    </th>
                                    <td>
                                        {{ $auditLog->subject_type }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ __('audit.user_id') }}
                                    </th>
                                    <td>
                                        {{ $auditLog->user_id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ __('audit.properties') }}
                                    </th>
                                    <td id="encode">
                                        <a href="#" onclick="myJSEscape('{{$auditLog->properties}}')">
                                        {{ $auditLog->properties }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ __('audit.host') }}
                                    </th>
                                    <td>
                                        {{ $auditLog->host }}
                                    </td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <td>
                                    <div class="card-footer p-0">
                        <span class=" float-sm-right d-flex flex-sm-row flex-column justify-content-end">
                       <a href="/admin/audit-logs"> <button class="btn btn-primary">{{__('audit.Back')}}</button></a>
                                </span>
                                    </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>



                        </div>
                    </div>
                </div>
            </div>
    </div>
    </div>
</div>
@stop
@section('scripts')
    <script>
        function myJSEscape(str)
        {
            var txt = document.getElementById('encode');
            str = str.replace(new RegExp("'", 'g'),"\\'");
            txt.innerText=str;
        }
    </script>
@stop