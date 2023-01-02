@extends('layouts.admin')
@section('style')
<link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/tables/datatable/datatables.min.css">
@stop
@section('title', __('admin.Users') )
@section('subTitle', __('Rooms List'))
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('Rooms')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active">{{__('Rooms List')}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-header row">
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
                                        {{ __(''.session()->get('msg')) }}
                                        {{ Session::forget('msg') }}
                                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="content-body">
                <!-- users list start -->
                    <div class="users-list-table">

                        <div class="users-list-filter px-1" style="padding-right:0 !important;">
                            <div class="col-2 align-items-right" style="float: right;margin-bottom: 10px;padding-right: 0;">
                                <a href="{{route('rooms.create')}}" class="btn btn-block btn-success">
                                    {{ __('Add new')}}
                                </a>
                            </div>
                         <div class="col-2 align-items-right" style="float: right;margin-bottom: 10px;padding-right: 0;">
                                <a href="{{route('rooms.create')}}" class="btn btn-block btn-primary">
                                    {{ __('Bookings')}}
                                </a>
                            </div>
                        </div>

                        <div class="card" style="clear: both;">
                            <div class="card-content">
                                <div class="card-body">
                                    <!-- datatable start -->
                                    <div class="table-responsive">
                                        <table id="users-list-datatable" class="table" style="text-align: center;">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{__('Room')}}</th>
                                                <th>{{__('Type')}}</th>
                                                <th>{{__('Price')}}</th>
                                                <th>{{__('Discount')}}</th>
                                                <th>{{__('published')}}</th>
                                                <th>{{__('User added')}}</th>
                                                <th>{{__('Manage images')}}</th>
                                                <th>{{__('Delete')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $cont =1;?>
                                            @foreach ($rooms as $room)
                                            <tr>
                                                <td><a href="{{route('rooms.edit', ['id' => $room->id])}}">{{$room->id}}</a></td>
                                                <td style="font-size: small;"><a href="{{route('rooms.edit', ['id' => $room->id])}}"> {{$room->{'name_'.$l} }}</a></td>
                                                <td style="font-size: small;">{{$room->type_trans}}</td>
                                                <td style="font-size: small;">{{$room->price}}</td>
                                                <td style="font-size: small;">{{$room->discount}}</td>
                                                <td style="font-size: small;">{{ __(''.$room->published?'Yes':'No')}}</td>
                                                <td style="font-size: small;">{{$room->User->{'first_name_'.$l}.' '.$room->User->{'last_name_'.$l} }}</td>
                                                <td style="font-size: small;">
                                                    @can('delete_user')
                                                        <a  href="{{route('roomImages', ['id' => $room->id])}}" type="submit" class="btn btn-outline-warning btn-sm"><i class="bx bx-image"> </i></a>
                                                    @endcan
                                                </td>
                                                <?php $cont++;?>
                                                <td style="padding: 0px;font-size: small;">
                                                    @can('delete_user')
                                                         <button id='deleteAction' data-id='{{$room->id}}' data-url="{{route('rooms.destroy', ['id' => $room->id])}}" type="button" class="btn btn-outline-danger btn-sm"><i class="bx bx-trash"> </i></button>
                                                    @endcan
                                                </td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- datatable ends -->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- users list ends -->

                            </div>
                        </div>
                    </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->
@stop
@section('scripts')

<script src="/app-assets/js/scripts/pages/page-users.js"></script>
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

        <style>
            div.dataTables_wrapper div.dataTables_filter{text-align: left !important;}
        </style>

