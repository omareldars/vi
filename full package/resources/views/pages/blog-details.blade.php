@extends('layouts.default')
@section('title')
{{$l=='ar' ? $CP = $t->ar_title . " - " ."آخر الأخبار" : $CP = $t->title . " - " ."News blog" }}
@stop
@section('content')
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
<div class="inner-banner has-base-color-overlay text-center" style="background: url(/images/background/1.jpg);">
    <div class="container">
        <div class="box">
            <h3 style="font-size:2em;">{{$l=='ar'?$post->ar_title:$post->title}}</h3>
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
                    <a href="/blog">{{ __('Latest news') }}</a>
                </li>
				<li>
                    {{$l=='ar'?$post->ar_title:$post->title}}
                </li>
            </ul><!-- /.list-line -->
        </div><!-- /.pull-left -->

    </div><!-- /.container -->
</div>
<div class="sidebar-page-container sec-padd-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                 <section class="blog-section">
                    <div class="large-blog-news single-blog-post single-blog wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
                        <div class="img-box">
                            <img src="/images/blog/{{$post->image}}" alt="News">
                        </div>
                        <div class="lower-content">
                            <h4>{{$l=='ar'?$post->ar_title:$post->title}}</h4>
                            <div class="post-meta">{{date('M Y', strtotime($post->created_at))}}  </div>
                            <div class="text">
								{!!$l=='ar'?$post->ar_body:$post->body!!}
                            </div>
                        </div>
                    </div>
                    <div class="share-box clearfix">
                        <div class="social-box pull-right">
                        <span>{{ __('Share') }}  <i class="fa fa-share-alt"></i> </span>
                            <ul class="list-inline social">
                                <li>
                                    <div class="fb-share-button"
                                         data-href="{{url()->current()}}"
                                         data-layout="button_count" data-size="small">
                                    </div></li>
                                <li><a href="https://twitter.com/intent/tweet?text={{url()->current()}}"><i class="fa fa-twitter"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </section>
            </div>
		@include('includes.side')
        </div>
    </div>
</div>
@stop
