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
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('settings.Pagesettings')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active">{{__('settings.EditSettings')}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<div class="invoice-create-btn mb-1">
						<a href="/admin/addpage" class="btn btn-primary glow">{{__('settings.AddNew')}}</a>
                        <a href="/admin" class="btn btn-success glow">{{__('settings.BackHome')}}</a>
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
<?php $n=1; ?>
@if (count($getpages)>0)
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
                                                        <th>{{__('settings.ARABICTITLE')}}</th>
                                                        <th>{{__('settings.ENGLISHTITLE')}}</th>
														<th>{{__('settings.URLOF')}}</th>
														<th>{{__('settings.Image')}}</th>
                                                        <th>{{__('settings.EditDelete')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
					@foreach ($getpages as $page)
                                                    <tr style="font-weight:{{$page->published?'bold':'normal'}};">
                                                        <td>{{$n++}}</td>
                                                        <td>{{$page->ar_title}}</td>
                                                        <td>{{$page->title}}</td>
														<td>{{$page->url}}</td>
							<td>
								@if ($page->image)
									<a data-toggle="modal" data-target="#PhotoModal{{$page->id}}" href="javascript:void(0);">
									<img src="/images/resource/{{$page->image}}" height="30px">
									</a>

									<!-- Modal -->
              <div class="modal fade" id="PhotoModal{{$page->id}}" tabindex="-1" role="dialog" aria-labelledby="Photo" aria-hidden="true"><div class="modal-dialog modal-dialog-centered">
              <div data-dismiss="modal" class="modal-content">
			<img src="/images/resource/{{$page->image}}" width="600" /></div></div></div></div>
<!-- END: Modal-->

								@endif
							</td>
                                                        <td><a href="/admin/editpage/{{$page->id}}"><i class="bx bx-edit-alt"> </i></a> |
                                   <a onclick="return confirm('{{__('settings.SureDelete')}}');" href="{{URL::to('admin/deletepage/'.$page->id ?? null)}}"><i class="bx bx-trash"> </i></a>
                                                  |         @if($page->published) <a target="_blank" href="/page/{{$page->url}}"><i class="bx bx-show-alt"> </i></a>
                                                            @else <i class="bx bx-hide"> </i>@endif
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
