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
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('cycles.Services')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active">{{__('cycles.Show old records')}}
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
                            @if (count($received)>0)
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header"><br>
                                        <a href="/admin/requests/all" class="btn btn-primary glow">{{__('cycles.Back')}}</a>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body card-dashboard">
                                            <div class="table-responsive">
                                                <table class="table zero-configuration">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>{{__('cycles.SenderName')}}</th>
                                                        <th>{{__('cycles.Service')}}</th>
                                                        <th>{{__('cycles.Review comment')}}</th>
                                                        <th>{{__('cycles.Rate')}}</th>
                                                        <th>{{__('cycles.Done')}}</th>
                                                        <th>{{__('cycles.Approved')}}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($received as $n=>$rec)
                                                        <tr>
                                                            <td>{{$n+1}}</td>
                                                            <td>
                                                                <div class="media align-items-center">
                                                                    <a class="media-left mr-50" href="/admin/companyProfile/{{$rec->user->company->id}}">
                                                                        <img src="/191014/{{$rec->user->img_url??'../images/placeholder.jpg'}}" alt="avatar" class="rounded-circle" height="40" width="40">
                                                                    </a>
                                                                    <a href="/admin/companyProfile/{{$rec->user->company->id}}">
                                                                        <div class="media-body">
                                                                            <h6 class="media-heading mb-0">{{ $user = $rec->user->{'first_name_'.$l}.' '.$rec->user->{'last_name_'.$l} }}</h6>
                                                                            <span class="font-small-2">{{$rec->user->{'title_'.$l} }}
                                                                                @if($rec->user->company)
                                                                                    - {{$rec->user->company->{'name_'.$l} }}
                                                                                @endif
                                                                                </span>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                          	</td>
                                                            <td>{{ $rec->service->{'name_'.$l} }}</td>
                                                            <td>{{$rec->rate_comment??'-'}}</td>
                                                            <td>{!! str_repeat('<i class="bx bxs-star" style="color: #fc960f;"></i>',$rec->rate) !!}</td>
                                                            <td>{{$rec->done?__('Yes'):__('No')}}</td>
                                                            @if ($rec->approved=='Yes')
                                                                <td class="text-success py-1">
                                                            @else
                                                                <td class="text-danger py-1">
                                                            @endif
                                                                    {{$rec->approved}}
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
                                        <div class="card-header">
                                            <h4 class="card-title">{{__('cycles.No Old Requests')}}</h4>
                                            <br>
                                            <a href="/admin/requests/all" class="btn btn-primary glow">{{__('cycles.Back')}}</a>
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
