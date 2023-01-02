@extends('layouts.default')
@section('title')
{{$l=='ar' ? $CP = $t->ar_title . " - " ."عنا" : $CP = $t->title . " - " ."About us" }}
@stop
@section('content')
<div class="inner-banner has-base-color-overlay text-center" style="background: url(images/background/about.jpg);">
    <div class="container">
        <div class="box">
            <h3>{{$l=='ar'?'عنا':'About us'}}
			</h3>
        </div><!-- /.box -->
    </div><!-- /.container -->
</div>
<div class="breadcumb-wrapper">
    <div class="container">
        <div class="pull-left">
            <ul class="list-inline link-list">
                <li>
                    <a href="/">{{ __('Home ') }}</a>
                </li><!-- comment for inline hack
                --><li>
                   {{__('About us')}}
                </li>
            </ul><!-- /.list-line -->
        </div><!-- /.pull-left -->
    </div><!-- /.container -->
</div>
<section class="about-faq sec-padd">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="about-info">
                    <h3>{{$l=='ar'?$about->ar_title:$about->title}}</h3>
                    <br>
                    <div class="text">
                        {!!$l=='ar'?$about->ar_dsc:$about->dsc!!}
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="img-box">
                            <img src="images/resource/7.jpg" alt="">
                        </div>
                        <br>
                        <h4>{{__('Mission')}} </h4>
                        <br>
                        <p>{!!$l=='ar'?$about->ar_set1:$about->set1!!}</p>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="img-box">
                            <img src="images/resource/8.jpg" alt="">
                        </div>
                        <br>
                        <h4>{{__('Vision')}}</h4>
                        <br>
                        <p>{!!$l=='ar'?$about->ar_set2:$about->set2!!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="subscribe center sec-padd" style="background-image: url(images/background/newsletter.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
                <h2>{{__('Subscribe For Newsletter')}}</h2>
                <p>
				{{__('Join our newsletter to get all portal news')}}
				</p>
                @if(session()->has('message'))
                 <p style="color:#ffe785">
                {{session()->get('message') == 'Done'?__('Thank your for your subscription.'):__('Something went wrong. Please try again later!')}}
                 <p>
                @endif
                <form class="subscribe-form" id="sendmail" name="sendmail" action= "{{URL::to('admin/message')}}" method="POST" enctype="multipart/form-data">
           					     {!! csrf_field() !!}
                    <input name ="email" type="email" placeholder="{{__('Email')}}" required><span class="fa fa-envelope"></span>
                    <button type="submit" class="thm-btn">{{__('Subscribe us')}}</button>
                </form>
            </div>
        </div>
    </div>
</section>
@if ($about->url)
<section class="two-column sec-padd">
    <div class="container">
        <div class="section-title center">
            <h2>{{__('Press Releases')}}
            </h2>
        </div>
        <div class="two-column-carousel">
@foreach($press=App\Press::orderBy('order')->get() as $item)
            <div class="item clearfix">
                <div class="img-box">
                <a href="{{$item->url}}" target="_blank">
                    <img src="/191014/{{$item->img_url}}" alt="" style="max-height:200px;object-fit: scale-down;"></a>
                </div>
                <div class="content">
                    <h4>{{$l=='ar'?$item->ar_title:$item->en_title}}</h4>
                    <br>
                    <a href="{{$item->url}}" target="_blank">
                    {{__('More details')}} ...
                    </a>
                </div>
            </div>
@endforeach
        </div>
    </div>
</section>
@endif
@stop
