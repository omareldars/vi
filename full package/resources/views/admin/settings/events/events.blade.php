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
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('settings.eventsettings')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active">{{__('settings.EditEvents')}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<div class="invoice-create-btn mb-1">
						<a href="/admin/addevent" class="btn btn-primary glow">{{__('settings.AddNew')}}</a>
                        <a href="/admin/calendar" class="btn btn-success glow">{{__('admin.Calendar')}}</a>
            </div>
            	<div class="content-body">
                <section id="basic-datatable">
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

@if (count($getevents)>0)
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>{{__('settings.Title')}}</th>
                                                        <th>{{__('settings.Registered')}}</th>
														<th>{{__('settings.URL')}}</th>
														<th>{{__('settings.DownEditDelete')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
					@foreach ($getevents as $event)
                                                    <tr style="font-weight:{{$event->published?'bold':'normal'}};">
                                                        <td>{{$event->id}}</td>
                                                        <td>{{$event->{'title_'.$l} }}</td>
														<td>{{App\EventsUser::where('event_id',$event->id)->count()}}</td>
							 							<td>{!!$event->published?'<a target="_blank" href="/event/'.$event->id.'">/event/'.$event->id.'</a>':__('admin.NotPublished') !!}</td>
                                                        <td>
												<a href="/reports/events/{{$event->id}}"><i class="bx bx-download"> </i></a> |
												<a href="/admin/editevent/{{$event->id}}"><i class="bx bx-edit-alt"> </i></a> |
                                   <a onclick="return confirm('{{__('admin.SureDelEvent')}}');" href="{{URL::to('admin/deleteevent/'.$event->id ?? null)}}"><i class="bx bx-trash"> </i></a></td>
                                                    </tr>
												@endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
@else
<h3>
{{__('settings.NoData')}}
 </h3>
@endif
		</div>
	    </section>
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
	<script src="/app-assets/js/scripts/modal/components-modal.js"></script>
@stop
