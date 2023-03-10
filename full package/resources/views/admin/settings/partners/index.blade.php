@extends('layouts.admin')
@section('style')
<link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/tables/datatable/datatables.min.css">
@stop
@section('title', __('admin.partners') )
@section('subTitle', __('admin.partner`s List'))
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
    @include('admin.includes.heading')
        <div class="invoice-create-btn mb-1">
            <a href="{{route('partners.create')}}" class="btn btn-primary glow">{{ __('admin.Add New')}}</a>
        </div>
        <div class="content-body">
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    @if(session()->has('msg'))
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="alert alert-success alert-dismissible mb-2" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <div class="d-flex align-items-center">
                                                        <i class="bx bx-like"></i>
                                                        <span>
                                                            {{ __('admin.'.session()->get('msg')) }}
                                                            {{ Session::forget('msg') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="table-responsive">
                                        <table class="table zero-configuration">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ __('admin.English Title')}}</th>
                                                    <th>{{ __('admin.Arabic Title')}}</th>
                                                    <th>{{ __('admin.Created At')}}</th>
                                                    <th>
                                                        @can('edit_partner')
                                                            {{ __('admin.Edit')}}
                                                        @endcan
 |
                                                        @can('delete_partner')
                                                            {{ __('admin.Delete')}}
                                                        @endcan
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($partners as $partner)
                                                    <tr>
                                                        <td>{{$partner->order}}</td>
                                                        <td>{{$partner->en_title}}</td>
                                                        <td>{{$partner->ar_title}}</td>
                                                        <td>{{$partner->created_at}}</td>
                                                        <td>
                                                            @can('edit_partner')
                                                                <a href="{{route('partners.edit', ['id' => $partner->id])}}" class="btn btn-outline-primary"><i class="bx bx-edit-alt"> </i></a>
                                                            @endcan

                                                            @can('delete_partner')
                                                                <button id='deleteAction' data-id='{{$partner->id}}' data-url="{{route('partners.destroy', ['id' => $partner->id])}}" type="button" class="btn btn-outline-primary"><i class="bx bx-trash"> </i></button>
                                                            @endcan
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
<script>
    $(document).on("click", "#deleteAction", function (e) {
        var url = $(this).data('url');
        var token = '{{ csrf_token() }}';
        Swal.fire({
            title: "{{__('admin.SureDelete')}}",
            text: "{{__('admin.Recover')}}",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "{{__('admin.DYes')}}",
            cancelButtonText: "{{__('admin.No')}}!",
        })
        .then((result) => {
            if (result.value) {

                $.post(url, {'_method':'DELETE' , '_token':token},
                    function(response){
                        Swal.fire(
                        '{{__('admin.Deleted')}}!',
                        '{{__('admin.FileDeleted')}}.',
                        'success'
                        );

                        location.reload();
                    }
                ).fail(
                    function(error) {
                        console.log(error);
                    }
                );
            }else{
                console.log('Canceled')
            }
        })
    });
</script>
@stop
