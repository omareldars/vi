@extends('layouts.admin')
@section('style')
    <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.min.css">
@stop
@section('title', __('admin.Users') )
@section('index_url', route('users.index'))
@section('subTitle', __('Add new Book'))
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            @include('admin.includes.heading')
            <div class="content-body">
                <!-- BuilderForm start -->
                <section id="basic-input">

                    <div class="row match-height">
                        <!-- CrossFade Carousel Start -->
                        <div class="col-lg-8">
                            <div class="card" id="carousel-crossfade">
                                <div class="card-header">
                                    <h4 class="card-title">{{__('Room name').': '.$room->{'name_'.$l} }}</h4><hr>
                                </div>
                                <div class="card-body">
                                    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
                                        <div class="carousel-inner" style="max-height: 400px">
                                            <?php $count=0; ?>
                                            @foreach($roomImages AS $roomImage)
                                            <div class="carousel-item <?php if ($count<=0){echo 'active';} ?>">
                                                <img src="/191014/{{$roomImage->img_url}}" class="img-fluid d-block w-100" alt="cf-img-1">
                                            </div>
                                                    <?php $count++; ?>
                                            @endforeach
                                        </div>
                                        <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- CrossFade Carousel End -->
                        <div class="col-lg-4 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{__('More Information')}}</h4><hr>
                                </div>
                                <div class="card-body">
                                    <div class="list-group list-group-flush">
                                        <a href="javascript:void(0);" class="list-group-item list-group-item-action border-0 d-flex active">
                                            <div class="list-content">
                                                <h6 style="font-weight: bold;">{{__('Room Type')}}</h6><hr>
                                                <p class="mb-0">
                                                    {{__($room->type_trans)}}</p>
                                            </div>
                                        </a>
                                        <a href="javascript:void(0);" class="list-group-item list-group-item-action border-0 d-flex">
                                            <div class="list-content">
                                                <h6 style="font-weight:bold;">{{__('Inclusive')}} :</h6><hr />
                                                @foreach($roomInclusive as $roomInclusiveItem)
                                                <p class="mb-0" style="margin-bottom:10px !important;border-bottom: ridge 1px #d6e3fb;width: 100%">
                                                    <img style="width:30px;height:30px;margin-left:10px;" src="/191014/{{$roomInclusiveItem->inclusive->img_url}}"/>
                                                {{$roomInclusiveItem->inclusive->ar_title}}
                                                </p>
                                                @endforeach
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header" >
                                    <h4 class="card-title">{{__('Room Description')}}</h4><hr>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p>{!! $room->{'desc_'.$l} !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{__('Add new Book')}}</h4><hr>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        @if(session()->has('msg'))
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="alert alert-warning alert-success mb-2" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        <div class="d-flex align-items-center">
                                                            <i class="bx bx-error"></i>
                                                            <span>
                                                        {{ __('admin.'.session()->get('msg')) }}
                                                                {{ Session::forget('msg') }}
                                                    </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    <!-- Validation messages -->
                                        @if(count($errors) >0)
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach($errors->all() as $error)
                                                                <li>{{ $error }} </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <form method="post" action="{{route('booking.store')}}"
                                              enctype="multipart/form-data">
                                            {!! csrf_field() !!}

                                            <div class="col-md-12">
                                                <fieldset class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-label-group">

                                                                <input type="text" class="form-control" id="SelectDate" name="fromDate" >
                                                                <label for="timerdate">{{__('From date (time)')}}:</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-label-group">

                                                                <input type="text" class="form-control" id="SelectDate1" name="toDate" >
                                                                <input type="text" hidden="hidden"  name="room_id" value="{{$room->id}}" >
                                                                <label for="timerdate">{{__('TO date (time)')}}:</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-label-group">
                                                                <button type="submit"
                                                                        class="btn btn-primary mr-1 mb-1">{{__('Book')}}</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>

                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- BuilderForm end -->
            </div>
        </div>
    </div>
    <!-- END: Content-->
@stop
@section('pagescripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/ckeditor/4.5.11/ckeditor.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/ckeditor/4.5.11/adapters/jquery.js"></script>
    <script>
        var route_prefix = "/filemanager";
    </script>
    <script src="/js/jquery.datetimepicker.full.min.js"></script>
    <script>
        $('#SelectDate').datetimepicker({mask:'9999/19/39 29:59'});
        $('#SelectDate1').datetimepicker({mask:'9999/19/39 29:59'});
        $('textarea[name=body_ar]').ckeditor({
            height: 250,
            filebrowserImageBrowseUrl: route_prefix + '?type=Images',
            filebrowserImageUploadUrl: route_prefix + '/upload?type=Images&_token={{csrf_token()}}',
            filebrowserBrowseUrl: route_prefix + '?type=Files',
            filebrowserUploadUrl: route_prefix + '/upload?type=Files&_token={{csrf_token()}}',
            language: 'ar'
        });
        $('textarea[name=body_en]').ckeditor({
            height: 250,
            filebrowserImageBrowseUrl: route_prefix + '?type=Images',
            filebrowserImageUploadUrl: route_prefix + '/upload?type=Images&_token={{csrf_token()}}',
            filebrowserBrowseUrl: route_prefix + '?type=Files',
            filebrowserUploadUrl: route_prefix + '/upload?type=Files&_token={{csrf_token()}}',
            language: 'en'
        });
    </script>
@stop