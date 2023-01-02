@extends('layouts.admin')
@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.2/skins/ui/oxide/content.min.css">
@stop
@section('content')
@php($con = \App\Training::where('id',$contents->pluck('training_id')[0])->first())
<!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('settings.View training content')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
									<li class="breadcrumb-item active">{{$ccontent->title}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<div class="content-body">
                <section id="multiple-column-form">
                    <div class="row match-height">
                        <div class="col-md-3 col-sm-12">
                            <div class="card ">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <br>
                                        <img width="250px" src="/191014/{{$con->image}}">
                                        <br><br>
                                        <h1>{{ $con->title  }}</h1>
                                        <br>
                                        {{ $con->dsc  }}
                                    </h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <ul class="widget-timeline mb-0">
                                            @foreach($contents as $key=>$content)
                                                <li class="timeline-items timeline-icon-{{$ccontent->id==$content->id?'primary':'secondary' }} active">
                                                    <a href="/admin/training/my/{{$content->training_id}}?c={{$content->id}}">
                                                        <div class="timeline-time">
                                                            @if ($content->done())
                                                                <i title="Completed {{$content->done()}}" class="bx bxs-check-circle primary"></i>
                                                            @endif
                                                        </div>
                                                    <h6 class="timeline-title {{$ccontent->id==$content->id?'text-bold-600 primary':''}}">{{$key+1}} - {{$content->title}}</h6>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9 col-sm-12">
                            <div class="card ">
                                <div class="card-header">
                                    <h4 class="card-title">

                                    </h4>
                                </div>
                                <div class="card-content p-75">
                                    {!! $ccontent->content !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@stop
@section('pagescripts')
    <script>
        document.body.classList.add("menu-collapsed");
    </script>
@stop
