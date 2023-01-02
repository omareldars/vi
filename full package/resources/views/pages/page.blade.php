@extends('layouts.default')
@section('title')
{{$l=='ar' ? $CP = $t->ar_title . " - " .$page->ar_title : $CP = $t->title . " - " .$page->title }}
@stop
@section('content')
<div class="inner-banner has-base-color-overlay text-center" style="background: url(/images/background/1.jpg);">
    <div class="container">
        <div class="box">
            <h3 style="font-size:2em;">{{$l=='ar'?$page->ar_title:$page->title}}</h3>
        </div><!-- /.box -->
    </div><!-- /.container -->
</div>
<div class="breadcumb-wrapper">
    <div class="container">
        <div class="pull-left">
            <ul class="list-inline link-list">
                <li>
                    <a href="/">{{ __('Home ') }}</a>
                </li>
				<li>
                    {{$l=='ar'?$page->ar_title:$page->title}}
                </li>
            </ul><!-- /.list-line -->
        </div><!-- /.pull-left -->
    </div><!-- /.container -->
</div>
<section class="consultation sec-padd">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
                <div class="img-box" style="background: url(/images/resource/{{$page->image?$page->image:'consult.jpg'}});height: 400px;background-size: cover;">
                </div>
                <div class="default-form-area">
                    <div class="section-title center">
                        <h3>{{$l=='ar'?$page->ar_title:$page->title}}</h3>
                    </div>
				   {!!$l=='ar'?$page->ar_body:$page->body!!}
                </div>
            </div>
        </div>

    </div>
</section>
@stop
