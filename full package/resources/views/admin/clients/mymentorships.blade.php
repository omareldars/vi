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
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('admin.Mentorship requests')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active">{{__('admin.Show my requests')}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Zero configuration table -->
                <section id="basic-datatable">
                        <div class="row">
                            @if (count($sessions)>0)
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header"><br>
                                        <a href="/admin" class="btn btn-primary glow">{{__('admin.Back to Dashboard')}}</a>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body card-dashboard">
                                            <div class="table-responsive">
                                                <table class="table zero-configuration">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>{{__('admin.Mentor')}}</th>
                                                        <th>{{__('admin.Date')}}</th>
                                                        <th>{{__('admin.Notes')}}</th>
                                                        <th>{{__('admin.state')}}</th>
                                                        <th>{{__('admin.Rate')}}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($sessions as $n=>$session)
                                                        <tr>
                                                            <td>{{$n+1}}</td>
                                                            <td>
                                                                <div class="media align-items-center">
                                                                    <a class="media-left mr-50">
                                                                        <img src="/191014/{{$session->mentor->img_url??'../images/placeholder.jpg'}}" alt="avatar" class="rounded-circle" height="40" width="40">
                                                                    </a>
                                                                    <div class="media-body">
                                                                        <h6 class="media-heading mb-0">{{$session->mentor->{'first_name_'.$l} }} {{$session->mentor->{'last_name_'.$l} }}</h6>
                                                                        <span class="font-small-2">{{$session->mentor->{'title_'.$l} }}</span>
                                                                    </div>
                                                                </div>                                                            </td>
                                                            <td>{{$session->zoom_date}} ({{$session->period}}M)</td>
                                                            <td>{{$session->admin_comment??$session->comment}}</td>
                                                            @if ($session->approved=='Yes')
                                                            <td class="text-success py-1">
                                                                @if($session->join_url)
                                                                    <a href="{{$session->join_url}}" target="_blank">
                                                                        <button title="Join meeting" type="button" class="btn btn-icon rounded-circle btn-light-primary">
                                                                            <i class="bx bx-user"></i></button></a>
                                                                @endif
                                                            @elseif($session->approved=='No')
                                                            <td class="text-danger py-1">
                                                                NO
                                                                @else
                                                            <td class="text-warning py-1">
                                                                Wait
                                                            @endif
                                                            </td>

                                                            <td>
                                                                @if($session->rating)
                                                                    <span title="{{$session->rate_comment}}">
                                                                    {!! str_repeat('<i class="bx bxs-star" style="color: #fc960f;"></i>',$session->rating) !!}
                                                                    </span>
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
                             @else
                                 <div class="col-sm-12">
                                     <div class="card">
                                         <div class="card-header border-bottom">
                                             <h4 class="card-title">{{__('admin.No Requests')}}</h4>
                                        </div>
                                         <div class="card-body">
                                             <a href="/admin" class="btn btn-primary glow">{{__('admin.Back to Dashboard')}}</a>
                                         </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                </section>
            </div>
        </div>
    </div>

@stop
@section('scripts')
    @if($l=='ar')
        <script type="text/javascript">
            $(document).ready(function() {
                $('.zero-configuration').DataTable({
                    "language": {
                        "sEmptyTable":     "ليست هناك بيانات متاحة في الجدول",
                        "sLoadingRecords": "جارٍ التحميل...",
                        "sProcessing":   "جارٍ التحميل...",
                        "sLengthMenu":   "أظهر _MENU_ مدخلات",
                        "sZeroRecords":  "لم يعثر على أية سجلات",
                        "sInfo":         "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                        "sInfoEmpty":    "يعرض 0 إلى 0 من أصل 0 سجل",
                        "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                        "sInfoPostFix":  "",
                        "sSearch":       "ابحث:",
                        "sUrl":          "",
                        "oPaginate": {
                            "sFirst":    "الأول",
                            "sPrevious": "السابق",
                            "sNext":     "التالي",
                            "sLast":     "الأخير"
                        },
                        "oAria": {
                            "sSortAscending":  ": تفعيل لترتيب العمود تصاعدياً",
                            "sSortDescending": ": تفعيل لترتيب العمود تنازلياً"
                        }
                    }
                } );
            });
        </script>
    @endif
    <script src="/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="/app-assets/js/scripts/datatables/datatable.js"></script>
@stop
