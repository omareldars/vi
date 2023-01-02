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
                <!-- Columns section start -->
                <section id="columns">
                    <div class="row">
                        <div class="col-md-12">
                            @foreach ($rooms as $room)
                            <div class="col-md-4" style="display: inline-block !important;width: 32% !important;">
                                <div class="card">
                                    <?php $roomImage= App\Rooms_img::where('room_id',$room->id)->first();?>
                                    <img class="card-img-top img-fluid" src="/191014/{{$roomImage->img_url ?? "rooms/no_image.jpg"}}" alt="{{$room->{'name_'.$l} }}">
                                    <div class="card-header">
                                        <h4 class="card-title"><a href="{{route('rooms.edit', ['id' => $room->id])}}"> {{$room->{'name_'.$l} }}</a></h4>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">
                                            {{__($room->type_trans)}}
                                            {!! substr($room->{'desc_'.$l},0,50-1) !!}
                                        </p>
                                        <a style="float: left;"  href="{{route('rooms.edit', ['id' => $room->id])}}" type="submit"class="btn btn-outline-primary">المزيد</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>
                <!-- Columns section end -->


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

