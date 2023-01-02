@extends('layouts.admin')
@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.2/skins/ui/oxide/content.min.css">
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
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('settings.View training content')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/admin/training/all/{{$content->training_id}}"><i class="bx bx-briefcase"></i></a>
                                    </li>
									<li class="breadcrumb-item active">{{__('settings.view')}}
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
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title"> {{$content->title}}
                                        <div class="float-right">
                                            <a title="Edit" href="/admin/training/editcontent/{{$content->id}}" class="btn btn-icon rounded-circle btn-light-success">
                                                <i class="bx bx-edit"></i></a>

                                            <a title="Back" href="/admin/training/all/{{$content->training_id}}" class="btn btn-icon rounded-circle btn-light-primary">
                                                <i class="bx bx-arrow-back"></i></a>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
{!! $content->content !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic multiple Column BuilderForm section end -->
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