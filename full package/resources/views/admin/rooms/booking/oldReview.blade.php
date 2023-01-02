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
                                <a href="{{route('rooms.index')}}" class="btn btn-block btn-success">
                                    {{ __('Rooms')}}
                                </a>
                            </div>

                        <div class="card" style="clear: both;">
                            <div class="card-content">
                                <div class="card-body">
                                    <!-- datatable start -->
                                    <div class="table-responsive">
                                        <table id="users-list-datatable" class="table" style="text-align: center;">
                                            <thead>
                                            <tr>
                                                <th>{{__('Room')}}</th>
                                                <th>{{__('Client')}}</th>
                                                <th>{{__('From date (time)')}}</th>
                                                <th>{{__('TO date (time)')}}</th>
                                                <th>{{__('Status')}}</th>
                                                <th>{{__('Manager')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($booking_reviews as $booking_review)
                                            <tr>
                                                <td style="font-size: small;"><a href="{{route('rooms.edit', ['id' => $booking_review->room->id])}}"> {{$booking_review->room->{'name_'.$l} }}</a></td>
                                                <td style="font-size: small;">{{$booking_review->client->{'first_name_'.$l}.' '.$booking_review->client->{'last_name_'.$l} }}</td>
                                                <td style="font-size: small;">{{$booking_review->fromDate}}</td>
                                                <td style="font-size: small;">{{$booking_review->toDate}}</td>
                                                <td style="font-size: small;">{{$booking_review->approved }}</td>
                                                <td style="font-size: small;">{{($booking_review->User->{'first_name_'.$l} ?? null).' '.($booking_review->User->{'last_name_'.$l} ?? null)}}</td>

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

