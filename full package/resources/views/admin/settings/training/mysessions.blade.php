@extends('layouts.admin')
@section('style')
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.min.css">
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
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('cycles.My training courses & sessions')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
									<li class="breadcrumb-item active">{{__('cycles.view all')}}
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
            <div class="alert alert-{{session()->get('class')}} alert-dismissible mb-2" role="alert">
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
    </section>
    @if (count($sessions)>0)
    <section class="row">
    <div class="col-xl-12 col-md-12 col-sm-12">
    <div class="card">
        <div class="card-header">
        </div>
            <div class="card-body">
            <div class="card-text">
                <div class="table-responsive">
                    <table class="table mb-0" id="trainingtable">
                        <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>{{__('cycles.Type')}}</th>
                            <th>{{__('cycles.Title')}}</th>
                            <th>{{__('cycles.Start')}}</th>
                            <th>{{__('cycles.End')}}</th>
                            <th>{{__('cycles.details')}}</th>
                        </tr>
                        </thead>
                        <tbody>
@foreach($sessions as $key=>$session)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{__('cycles.'.$session->type)}}</td>
                                <td>{!! $session->dsc?'<a title="Click to show details" href="" onclick="ShowDetails('.$session->id.');return false;">'.$session->title.'</a>':$session->title!!}</td>
                                <td>{{$session->datetime}}</td>
                                <td>{{$session->enddatetime??'-'}}</td>
                                <td>
                                    @if ($session->type=='sessions')
                                    {{__('cycles.Duration')}}:  {{$session->duration}} {{__('cycles.Minutes')}} :
                                <a title="Click to join" href="{{$session->join_url}}" target="_blank">
                                        <button title="Join only" type="button" class="btn btn-icon rounded-circle btn-light-primary">
                                            <i class="bx bx-user"></i></button></a>
                                    @elseif ($session->type=='offline')
                                        <b>{{__('cycles.trainer name')}}:</b> {{$session->trainer_name}}<br><b>{{__('cycles.training location')}}:</b> {{$session->location}} <br>
                                    @else
                                        <a title="Show course contents" href="/admin/training/my/{{$session->location}}">{{__('cycles.Display course contents')}} </a>
                                    @endif
                                </td>
                            </tr>
@endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
    </section>
    @else
        <section class="row">
        <div class="col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">{{ __('cycles.Error') }}</h4>
                </div>

                <div class="card-body">
                    {{__('cycles.No training sessions added yet') }}, <a href="/admin">{{__('cycles.Back')}}</a>.
                </div>
            </div>
        </div>
        </section>
    @endif
            </div>
        </div>
    </div>
    <!-- END: Content-->
<div class="modal fade text-left" id="dscModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="dsctitle"> </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <p id="dsc">

                </p>
            </div>
        </div>
    </div>
</div>
@stop
@section('pagescripts')
    <script src="/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#trainingtable').DataTable({
                "responsive": true, "searching": true, "lengthChange": true, "paging": true, "bInfo": true,
                @if ($l=='ar')
                "language": {
                    "sEmptyTable":     "ليست هناك بيانات متاحة في الجدول",
                    "sLoadingRecords": "جارٍ التحميل...", "sProcessing":   "جارٍ التحميل...",
                    "sLengthMenu":   "أظهر _MENU_ مدخلات", "sZeroRecords":  "لم يعثر على أية سجلات",
                    "sInfo":         "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                    "sInfoEmpty":    "يعرض 0 إلى 0 من أصل 0 سجل", "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                    "sInfoPostFix":  "", "sSearch":       "ابحث:", "sUrl":          "",
                    "oPaginate": {"sFirst":    "الأول", "sPrevious": "السابق", "sNext":     "التالي", "sLast":     "الأخير"},
                    "oAria": {"sSortAscending":  ": تفعيل لترتيب العمود تصاعدياً", "sSortDescending": ": تفعيل لترتيب العمود تنازلياً"}}
                @endif
            });
        });
        function ShowDetails(training) {
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                type: "POST", url: "/admin/trainings/getdsc/"+training,
                success: function (response) {
                    $('#dsctitle').html(response.title);
                    $('#dsc').html(response.dsc);
                    $('#dscModal').modal('show');
                },
                error: function (error) {
                    console.log(error);
                    alert("Error Occurred, Try again!");
                }
            });
        }
    </script>
@stop