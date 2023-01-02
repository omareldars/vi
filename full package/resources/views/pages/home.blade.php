@extends('layouts.default')

@section('title')
{{$l=='ar' ? $CP = $t->ar_title . " - " ."الصفحة الرئيسية" : $CP = $t->title . " - " ."Home Page" }}
@stop

@section('content')
<!--Start rev slider wrapper-->
<section class="rev_slider_wrapper">
    <div id="slider1" class="rev_slider" data-version="5.0">
		<ul>
@foreach(App\Slider::orderBy('slideorder','asc')->get() as $slide)
            <li data-transition="fade">
				<img src="images/slider/{{$slide->img_path}}" alt="" width="1920" height="400" data-bgposition="top center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="1" >
				<div class="tp-caption  tp-resizeme"
					data-x="{{$l=='ar'?'right':'left'}}" data-hoffset="10"
                    data-y="top" data-voffset="150"
                    data-transform_idle="o:1;"
                    data-transform_in="x:[{{$l=='ar'?'-175':'175'}}%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0.01;s:3000;e:Power3.easeOut;"
                    data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;"
                    data-mask_in="x:[100%];y:0;s:inherit;e:inherit;"
                    data-splitin="none"
                    data-splitout="none"
                    data-responsive_offset="on"
                    data-start="700">
                    <div class="slide-content-box">
                        <h1>{{$l=='ar' ? $slide->ar_title : $slide->title}}</h1>
                        @if ($slide->ar_img_desc)
						<p>{{$l=='ar' ? $slide->ar_img_desc : $slide->img_desc}}</p>
                    	@endif
						@if ($slide->img_url)
						<div class="button">
                            <a class="thm-btn our-solution" href="{{$slide->img_url}}">{{$l=='ar' ? $slide->ar_url_title : $slide->url_title}}</a>
                        </div>
						@endif
					</div>
                </div>
			</li>
@endforeach
     	</ul>
	</div>
</section>
<!--End rev slider wrapper-->
<section class="why-us service">
    <div class="container">
        <div class="section-title center">
            <h2>{{$l=='ar'?'مرحبا بك في '.$t->ar_title:'Welcome to '.$t->title}}</h2>
        </div>
   <div class="row clearfix">
   @foreach (App\settings::where('type','3')->get() as $wel)
            <!--Featured Service -->
            <div class="featured-service col-md-4 col-sm-6 col-xs-12">
                <div class="inner-box wow fadeIn animated" data-wow-delay="0ms" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeIn;">
                    <div class="image-box">
                        <figure class="image"><a href="{{$wel->url}}"><img src="images/resource/{{$wel->img_url}}" alt=""></a></figure>
                        <div class="caption-box">
                            <div class="icon"><span class="{{$wel->set2}}"></span></div>
                            <h4 class="title"><a href="{{$wel->url}}">{{$l=='ar'?$wel->ar_title:$wel->title}}</a></h4>
                        </div>
                        <!--Overlay-->
                        <div class="overlay-box">
                            <div class="icon_box"><span class="{{$wel->set2}}"></span></div>
                            <div class="overlay-inner">
                                <div class="overlay-content">
                                    <h4 class="title"><a href="{{$wel->url}}">{{$l=='ar'?$wel->ar_set1:$wel->set1}}</a></h4>
                                    <div class="text">{{$l=='ar'?$wel->ar_dsc:$wel->dsc}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      @endforeach
	  </div>
    </div>
</section>
<!--Fact Counter-->
<section class="fact-counter sec-padd">
    <div class="container">
        <div class="section-title center">
            <h2 style="color:#000;">{{$l=="ar"?"أهم الإنجازات":"Our impact"}}</h2>
        </div>
        <div class="row clearfix">
            <div class="counter-outer clearfix">
                @foreach(App\Settings::where('type','6')->whereNotNull('dsc')->get() as $counter)
                <article class="column counter-column col-md-3 col-sm-6 col-xs-12 wow fadeIn" data-wow-duration="0ms">
                    <div class="item">
                        <span class="icon-{{$counter->img_url}}" style="font-size: 60px;"></span>
                        <div class="count-outer"><span class="count-text" data-speed="3000 " data-stop="{{preg_replace('/[^0-9]/','',$counter->dsc)}}">0</span>{{preg_replace('/[0-9]+/', '',$counter->dsc)}}</div>
                        <h4 class="counter-title">{{$l=="ar"?$counter->ar_title:$counter->title}}</h4>
                    </div>

                </article>
                @endforeach
            </div>
        </div>
    </div>
</section>
<section class="blog-section sec-padd-top service">
    <div class="container">
        <div class="section-title center">
            <h2>{{__('Latest news')}}</h2>
        </div>
        <div class="row">

		@foreach (App\Posts::whereNotNull('published')->orderBy('created_at','DESC')->take(3)->get() as $post)
            <div class="col-md-4 col-sm-6 col-xs-12">
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
        </div>
    </div>
</section>

<div class="container"><div class="border-bottom"></div></div>

<section class="clients-section sec-padd">
    <div class="container">
        <div class="section-title">
            <h2>{{__('Our partners')}}</h2>
        </div>
        <div class="client-carousel owl-carousel owl-theme">
@foreach($partners=App\Partner::orderBy('order')->get() as $partner)
            <div class="item tool_tip" title="{{$l=='ar'?$partner->ar_title:$partner->en_title}}">
                @if ($partner->url) <a href="{{$partner->url}}" target="_blank"> @else <a href="#"> @endif
                <img style="max-height: 150px;max-width: 150px;" src="/191014/{{$partner->img_url}}" alt="{{$l=='ar'?$partner->ar_title:$partner->en_title}}">
                </a>
            </div>
@endforeach
        </div>
    </div>
</section>
@stop

@section('scripts')
	<!-- revolution slider js -->
	<script src="assets/revolution/js/jquery.themepunch.tools.min.js"></script>
	<script src="assets/revolution/js/jquery.themepunch.revolution.min.js"></script>
	<script src="assets/revolution/js/extensions/revolution.extension.actions.min.js"></script>
	<script src="assets/revolution/js/extensions/revolution.extension.carousel.min.js"></script>
	<script src="assets/revolution/js/extensions/revolution.extension.kenburn.min.js"></script>
	<script src="assets/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
	<script src="assets/revolution/js/extensions/revolution.extension.migration.min.js"></script>
	<script src="assets/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
	<script src="assets/revolution/js/extensions/revolution.extension.parallax.min.js"></script>
	<script src="assets/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
@stop
