@extends('layouts.default')

@section('title')
{{$l=='ar' ? $CP = $t->ar_title . " - " ."الفعاليات" : $CP = $t->title . " - " ."Events" }}
@stop

@section('content')
<link rel="stylesheet" href="/css/jquery.countdown.css" />
<div class="inner-banner has-base-color-overlay text-center" style="background: url(/images/background/entrepreneur.jpg);">
    <div class="container">
        <div class="box">
            <h3 style="font-size: 30px;line-height: 35px">{{$event->{'title_'.$l} }} <br /> <span style="font-size: small">{{date('d-m-Y', strtotime($event->timerdate)) }}</span></h3>
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
                    <a href="/events">{{ __('Events') }}</a>
                </li>
                    {{$event->{'title_'.$l} }}
                </li>
            </ul><!-- /.list-line -->
        </div><!-- /.pull-left -->
    </div><!-- /.container -->
</div>
    <section class="consultation sec-padd">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
                    <div class="img-box">
                        @if(session()->has('message'))
                            <h3 style="text-align: center;margin-bottom: 35px;color: #b59822;">
@if(session()->get('message') == 'Done')
{{__('Registration successfully.')}}
@elseif(session()->get('message') == 'already')
Registration failed, Your Email already registered.
@else
{{__('Something went wrong. Please try again later!')}}
 @endif
                            </h3>
                        @endif
                        <img src="/images/resource/{{$event->image?$event->image:'consult.jpg'}}" alt="Event">
                    </div>
                    <div class="default-form-area">
                        {!!$event->{'body_'.$l} !!}
                       <br />
                        @if (now() <= $event->timerdate)
                        <div class="link_btn center">
                            <a href="#register" class="thm-btn">{{ __('Register now')}}</a>
                        </div>
                        <br />
                        @if($event->showtimer and $event->timerdate <= now()->addDays(98))
                        <div class="section-title">
                            <h4>{{ __('Time remining')}}</h4>
                        </div>
                        <div id="countdown" style="direction:ltr;"></div>
                        <br/>
                        @endif
                        @endif
                        @if($event->googlemap)
                    <div class="section-title">
                        <h4>{{__('Location')}}</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="home-google-map">
                                <div class="google-map">
                                    <iframe src="{!!$event->googlemap!!}" width="100%" height="430" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                        @endif
                        @if ($event->timerdate >= now())
                        <a id="register" data-hs-anchor="true"></a>
                        <br />
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="section-title">
                                    <h4>{{ __('Register now')}}</h4>
                                </div>
                                <br />
                                <div class="default-form-area">
                                    <form id="contact-form" name="sendmail" class="default-form" action= "{{URL::to('eventregister')}}" method="POST" enctype="multipart/form-data">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="eventid" value="{{$event->id}}">
                                        <div class="row clearfix">
                                            @if (auth()->user())
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <input type="text" name="Name" class="form-control" value="{{$l=='ar'?auth()->user()->first_name_ar.' '.auth()->user()->last_name_ar:auth()->user()->first_name_en.' '.auth()->user()->last_name_en}}" placeholder="{{ __('Your name')}} *" required="" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <input type="email" name="Email" class="form-control required email" value="{{auth()->user()->email}}" placeholder="{{ __('Your Mail')}} *" required="" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <input type="text" name="Phone" class="form-control" value="{{auth()->user()->phone}}" placeholder="{{ __('Your Phone')}} *" readonly>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <input type="text" name="Name" class="form-control" value="" placeholder="{{ __('Your Name')}} *" required="">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <input type="email" name="Email" class="form-control required email" value="" placeholder="{{ __('Your Mail')}} *" required="">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <input type="text" name="Phone" class="form-control" value="" placeholder="{{ __('Your Phone')}} *" required="">
                                                    </div>
                                                </div>
                                            @endif
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <input type="text" name="employer" class="form-control" placeholder="{{ __('Employer')}} *" required="">
                                                    </div>
                                                </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <input type="text" name="jobtitle" class="form-control"  placeholder="{{ __('Current job')}} *" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                                <div class="form-group">
                                                    <input id="form_botcheck" name="form_botcheck" class="form-control" type="hidden" value="">
                                                    <button class="thm-btn thm-color" type="submit" data-loading-text="{{ __('Wait')}}...">{{ __('Send')}}</button>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                                <br />
                            </div>
                        </div>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('scripts')
        <script src="/js/jquery.countdown.js"></script>
        <script>
            $(function(){
                var note = $('#note'),
                    ts = new Date("{{date('Y',strtotime($event->timerdate))}}-{{date('m',strtotime($event->timerdate))}}-{{date('d',strtotime($event->timerdate))}}T{{date('H',strtotime($event->timerdate))}}:{{date('i',strtotime($event->timerdate))}}:00"),
                    newYear = true
                if((new Date()) > ts){

                    ts = '';
                    newYear = false;
                }
                console.log(ts);
                $('#countdown').countdown({
                    timestamp	: ts,
                    callback	: function(days, hours, minutes, seconds){
                        var message = "";
                        message += days + " day" + ( days==1 ? '':'s' ) + ", ";
                        message += hours + " hour" + ( hours==1 ? '':'s' ) + ", ";
                        message += minutes + " minute" + ( minutes==1 ? '':'s' ) + " and ";
                        message += seconds + " second" + ( seconds==1 ? '':'s' ) + " <br />";

                        note.html(message);
                    }
                });
            });
        </script>
@stop
