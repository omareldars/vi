@extends('layouts.admin')
@section('style')
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/tables/datatable/datatables.min.css">
@stop
@section('content')
<!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('admin.Companies')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
									<li class="breadcrumb-item active">{{__('admin.Display all companies data')}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<div class="content-body">
                <section id="multiple-column-form">
				    @if(session()->has('message'))
				    <div class="alert alert-success alert-dismissible mb-2" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <div class="d-flex align-items-center">
                                                <i class="bx bx-like"></i>
                                                <span>
                                                    {{ __('admin.'.session()->get('message')) }}
                                                </span>
                                            </div>
                    </div>
					@endif
					@if(session()->has('message2'))
					 <div class="alert alert-danger alert-dismissible mb-2" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <div class="d-flex align-items-center">
                                                <i class="bx bx-error"></i>
                                                <span>
                                                    {{ __('admin.'.session()->get('message2')) }}
                                                </span>
                                            </div>
                     </div>
					 @endif

                </section>
    <section class="row">
        <div class="col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title primary">{{__('admin.Display all companies data')}}</h4>
                </div>
                <hr style="margin:-10px 0 5px 0;">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                            <tr class="table-light">
                                <th>#</th>
                                <th>{{__('cycles.Company')}}</th>
                                <th>{{__('admin.Phone')}}</th>
                                <th>{{__('admin.Sector')}}</th>
                                <th>{{__('admin.founder')}}</th>
                                <th>{{__('cycles.Created at')}}</th>
                                <th>{{__('admin.Cycle')}}</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($companies as $key=>$company)

                                <tr>
                                    <td>
                                        {{$key+1}}
                                    </td>
                                    <td>
                                        <div class="media align-items-center">
                                            <a class="media-left mr-50" href="/admin/companyProfile/{{$company->id}}">
                                                <img src="/191014/{{$company->logo??'../app-assets/images/logo_placeholder.png'}}" alt="avatar" class="rounded-circle" height="40" width="40">
                                            </a>
                                            <a href="/admin/companyProfile/{{$company->id}}">
                                                <div class="media align-items-center">
                                                    {{$company->{'name_'.$l} }}
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        {{$company->phone}}
                                    </td>
                                    <td>
                                        {{__($company->sector)}}
                                    </td>
                                    <td>
                                        {{$company->founder}}
                                    </td>
                                    <td>
                                        {{$company->created_at}}
                                    </td>
                                    <td>
                                        {{$company->cycledata->title??__('admin.No Cycle')}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
        <script type="text/javascript">
            $(document).ready(function() {
                $('.table').DataTable({
                    @if ($l=='ar')
                    "language": {
                        "sEmptyTable":     "ليست هناك بيانات متاحة في الجدول", "sLoadingRecords": "جارٍ التحميل...",
                        "sProcessing":   "جارٍ التحميل...", "sLengthMenu":   "أظهر _MENU_ مدخلات", "sZeroRecords":  "لم يعثر على أية سجلات",
                        "sInfo":         "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل", "sInfoEmpty":    "يعرض 0 إلى 0 من أصل 0 سجل",
                        "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)", "sInfoPostFix":  "", "sSearch":       "ابحث:", "sUrl":          "",
                        "oPaginate": {"sFirst":    "الأول", "sPrevious": "السابق", "sNext":     "التالي", "sLast":     "الأخير"},
                        "oAria": {"sSortAscending":  ": تفعيل لترتيب العمود تصاعدياً", "sSortDescending": ": تفعيل لترتيب العمود تنازلياً"}}
                    @endif
                });
            });
        </script>
    <script src="/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>
@stop
