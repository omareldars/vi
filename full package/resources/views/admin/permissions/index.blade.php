@extends('layouts.admin')
@section('style')
<link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/tables/datatable/datatables.min.css">
@stop
@section('title', __('Users Permissions') )
@section('subTitle', __('Permissions list'))
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
    @include('admin.includes.heading')
        <div class="invoice-create-btn mb-1">
            <a href="{{route('permissions.create')}}" class="btn btn-primary glow">{{ __('admin.Add New')}}</a>
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
                                                    <th>{{ __('ID')}}</th>
                                                    <th>{{ __('Title')}}</th>
                                                    <th>{{ __('Edit/ Delete')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($permissions as $key => $permission)
                                                    <tr>
                                                        <td>
                                                            {{ $permission->id ?? '' }}
                                                        </td>
                                                        <td>
                                                            {{ $permission->name  ?? '' }}
                                                        </td>
                                                        <td>
                                                            <a href="{{route('permissions.edit', ['id' => $permission->id])}}" class="btn btn-outline-primary"><i class="bx bx-edit-alt"> </i></a>
                                                            <button id='deleteAction' data-id='{{$permission->id}}' data-url="{{route('permissions.destroy', ['id' => $permission->id])}}" type="button" class="btn btn-outline-primary"><i class="bx bx-trash"> </i></button>
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
