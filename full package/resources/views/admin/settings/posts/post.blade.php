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
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('settings.Postsettings')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active"> {{__('settings.EditSettings')}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<div class="invoice-create-btn mb-1">
						<a href="/admin/addpost" class="btn btn-primary glow">{{__('settings.AddNew')}}</a>
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
@if (count($getposts)>0)
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
														<th>{{__('settings.Image')}}</th>
                                                        <th style="width: 100px;">{{__('settings.EditDelete')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
					@foreach ($getposts as $post)
                                                    <tr style="font-weight:{{$post->published?'bold':'normal'}};">
                                                        <td>{{$n++}}</td>
                                                        <td>{{$post->ar_title}}</td>
                                                        <td>{{$post->title}}</td>
							<td>
								@if ($post->image)
									<a data-toggle="modal" data-target="#PhotoModal{{$post->id}}" href="javascript:void(0);">
									<img src="/images/blog/{{$post->image}}" height="30px">
									</a>

									<!-- Modal -->
              <div class="modal fade" id="PhotoModal{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="Photo" aria-hidden="true"><div class="modal-dialog modal-dialog-centered">
              <div data-dismiss="modal" class="modal-content">
			<img src="/images/blog/{{$post->image}}" width="600" /></div></div></div></div>
<!-- END: Modal-->

								@endif
							</td>
                                                        <td><a href="/admin/editpost/{{$post->id}}"><i class="bx bx-edit-alt"> </i></a> |
                                   <a onclick="return confirm('{{__('settings.SureDelete')}}');" href="{{URL::to('admin/deletepost/'.$post->id ?? null)}}"><i class="bx bx-trash"> </i></a>
                                                            |   @if($post->published)<a target="_blank" href="/blog/{{$post->id}}"><i class="bx bx-show-alt"> </i></a>
                                                            @else <i class="bx bx-hide"> </i>
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
    "sEmptyTable":     "???????? ???????? ???????????? ?????????? ???? ????????????",
	"sLoadingRecords": "???????? ??????????????...",
	"sProcessing":   "???????? ??????????????...",
	"sLengthMenu":   "???????? _MENU_ ????????????",
	"sZeroRecords":  "???? ???????? ?????? ?????? ??????????",
	"sInfo":         "?????????? _START_ ?????? _END_ ???? ?????? _TOTAL_ ????????",
	"sInfoEmpty":    "???????? 0 ?????? 0 ???? ?????? 0 ??????",
	"sInfoFiltered": "(???????????? ???? ?????????? _MAX_ ??????????)",
	"sInfoPostFix":  "",
	"sSearch":       "????????:",
	"sUrl":          "",
	"oPaginate": {
		"sFirst":    "??????????",
		"sPrevious": "????????????",
		"sNext":     "????????????",
		"sLast":     "????????????"
	},
	"oAria": {
		"sSortAscending":  ": ?????????? ???????????? ???????????? ????????????????",
		"sSortDescending": ": ?????????? ???????????? ???????????? ????????????????"
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
