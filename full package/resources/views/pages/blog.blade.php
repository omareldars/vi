@extends('layouts.default')
@section('title')
{{$l=='ar' ? $CP = $t->ar_title . " - " ."آخر الأخبار" : $CP = $t->title . " - " ."News blog" }}
@stop
@section('content')
<div class="inner-banner has-base-color-overlay text-center" style="background: url(images/background/1.jpg);">
    <div class="container">
        <div class="box">
            <h3>{{ __('Latest news') }}</h3>
        </div><!-- /.box -->
    </div><!-- /.container -->
</div>
<div class="breadcumb-wrapper">
    <div class="container">
        <div class="pull-left">
            <ul class="list-inline link-list">
                <li>
                    <a href="/">
                        {{__('Home ')}}
                    </a>
                </li>
                <li>
                    {{ __('Latest news') }}
                </li>
            </ul><!-- /.list-line -->
        </div><!-- /.pull-left -->
    </div><!-- /.container -->
</div>
<?php
$posts = App\Posts::whereNotNull('published')->orderBy('created_at','DESC')->Paginate(10);
?>
<div class="sidebar-page-container sec-padd-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <section class="blog-section">
                    <div class="row">
                    @if (count($posts)>0)
					@foreach ($posts as $post)
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="default-blog-news wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
                                <div class="img-box">
                                    <a href="blog/{{$post->id}}"><img src="images/blog/{{$post->image?$post->image:'1.jpg'}}" alt="News"></a>
                                </div>
                                <div class="lower-content">
                                    <div class="post-meta">{{date('M Y', strtotime($post->created_at))}}</div>
                                    <div class="text">
                                        <h4><a href="blog/{{$post->id}}">{{$l=='ar'?Illuminate\Support\Str::limit($post->ar_title,30):Illuminate\Support\Str::limit($post->title,30)}}</a></h4>
                                        <p>{{$l=='ar'?Illuminate\Support\Str::limit(strip_tags($post->ar_body),75):Illuminate\Support\Str::limit(strip_tags($post->body),75)}}</p>
                                    </div>

                                </div>
                            </div>
                        </div>
					@endforeach
                        @else
                            <div class="col-md-12"><h3>{{$l=='ar'?'لا يوجد أخبار لعرضها':'No news added yet'}}</h3></div>
                        @endif
                    </div>
                    @if($posts->hasPages())
                    <div class="border-bottom"></div>
                    <br>
                    <ul class="page_pagination center">
                        {{$posts->links()}}
                    </ul>
                    @endif
                </section>
            </div>
		@include('includes.side')
        </div>
    </div>
</div>
@stop
