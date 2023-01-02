@extends('layouts.default')
@section('title')
{{$l=='ar' ? $CP = $t->ar_title . " - " ."الفعاليات" : $CP = $t->title . " - " ."Events" }}
@stop
@section('content')
@php
if ($CR == 'events')
    {
$events = App\Event::where('published',1)->orderBy('timerdate','DESC')->get();
    } else {
$events = App\Event::where('published',1)->whereNotNull('CSR')->orderBy('timerdate','DESC')->get();
    }
@endphp
<div class="inner-banner has-base-color-overlay text-center" style="background: url(images/background/1.jpg);">
    <div class="container">
        <div class="box">
            <h3>{{ $CR == 'events' ? __('Events') : __('CSR unit events') }}</h3>
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
                    {{ __('Events') }}
                </li>
            </ul><!-- /.list-line -->
        </div><!-- /.pull-left -->
    </div><!-- /.container -->
</div>
<div class="sidebar-page-container sec-padd">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <section class="blog-section">
					@foreach ($events as $event)
                        <div class="large-blog-news wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;{{$loop->last?'border-bottom:none;':''}}">
                            <div class="img-box">
                                <a href="/event/{{$event->id}}"><img style="max-height: 500px;" src="images/resource/{{$event->image?$event->image:'consult.jpg'}}" alt="Event"></a>
                            </div>
                            <div class="lower-content">
                                <h4><a href="/event/{{$event->id}}">{{$event->{'title_'.$l} }}</a></h4>
                                <div class="post-meta">{{date('d-m-Y', strtotime($event->timerdate))}}</div>
                                <div class="text">
                                    {!! Illuminate\Support\Str::limit($event->{'body_'.$l},250) !!}
                                </div>
                                <div class="link">
                                    <a href="/event/{{$event->id}}" class="thm-btn">{{__('More details')}}</a>
                                </div>
                            </div>
                        </div>
					@endforeach
                </section>
            </div>
        </div>
    </div>
</div>
@stop
