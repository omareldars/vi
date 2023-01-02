@extends('layouts.default')

@section('title')
{{$l=='ar' ? $CP = $t->ar_title . " - " ."اتصل بنا" : $CP = $t->title . " - " ."Contact us" }}

@stop

@section('content')

<div class="inner-banner has-base-color-overlay text-center" style="background: url(images/background/entrepreneur.jpg);">
    <div class="container">
        <div class="box">
            <h3>{{ __('Contact us') }}</h3>
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
                    {{ __('Contact us') }}
                </li>
            </ul><!-- /.list-line -->
        </div><!-- /.pull-left -->
    </div><!-- /.container -->
</div>

<section class="contact_details sec-padd">
    <div class="container">
        @if(session()->has('message'))
            <h3 style="text-align: center;margin-bottom: 35px;color: #b59822;">
                {{session()->get('message') == 'Done'?__('Your message sent successfully, and we will contact you soon.'):__('Something went wrong. Please try again later!')}}</h3>
        @endif
        <div class="section-title">
            <h3>{{$l=='ar'?'بيانات الإتصال':'Contact details'}}</h3>
        </div>
        <div class="text">
            <p>{{ __('If you have a question, Please find below contact details and contact us form') }}.</p>
        </div>
        <br><br>
        <div class="row">
            <div class="col-md-4 col-sm-8 col-xs-12">
                <div class="default-cinfo">
                    <div class="accordion-box">
                        <!--Start single accordion box-->
                        <div class="accordion animated out" data-delay="0" data-animation="fadeInUp">
                            <div class="acc-btn active">
                                 {{ __('Main office') }}
                                <div class="toggle-icon">
                                    <i class="plus fa fa-angle-right"></i><i class="minus fa fa-angle-down"></i>
                                </div>
                            </div>
                            <div class="acc-content collapsed">
                                <ul class="contact-infos">
                                    <li>
                                        <div class="icon_box">
                                            <i class="fa fa-home"></i>
                                        </div><!-- /.icon-box -->
                                        <div class="text-box">
                                            <p><b>{{ __('Address') }}:</b><br>{!!$l=='ar'?$contact->ar_dsc:$contact->dsc!!}</p>
                                        </div><!-- /.text-box -->
                                    </li>
                                    <li>
                                        <div class="icon_box">
                                            <i class="fa fa-phone"></i>
                                        </div><!-- /.icon-box -->
                                        <div class="text-box">
                                            <p><b>{{ __('Call us') }}:</b> <br><p style="direction:ltr;">{!!$contact->set1!!}</p>
                                        </div><!-- /.text-box -->
                                    </li>
                                    <li>
                                        <div class="icon_box">
                                            <i class="fa fa-envelope"></i>
                                        </div><!-- /.icon-box -->
                                        <div class="text-box">
                                            <p><b>{{ __('Email') }}:</b> <br>{{$contact->title}}</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="icon_box">
                                            <i class="fa fa-clock-o"></i>
                                        </div><!-- /.icon-box -->
                                        <div class="text-box">
                                            <p><b>{{ __('Opening time') }}:</b> <br>{!!$l=='ar'?$contact->ar_set2:$contact->set2!!}</p>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </div>


                    </div>
                </div>

            </div>
            <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="home-google-map">
                    <div class="google-map">
					<iframe src="{{$contact->ar_set1}}" width="100%" height="460" frameborder="0" style="border:0;" allowfullscreen=""></iframe>

                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="border-bottom"></div>
</div>
@if(session()->get('message') <> 'Done')
<section class="contact_us sec-padd">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="section-title">
                    <h3>{{ __('Send your message')}}</h3>
                </div>
                <div class="default-form-area">
				<form id="contact-form" name="sendmail" class="default-form" action= "{{URL::to('sendmsg')}}" method="POST" enctype="multipart/form-data">
                       {!! csrf_field() !!}
					    <div class="row clearfix">

@if (auth()->user())
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <input type="text" name="Name" class="form-control" value="{{auth()->user()->{'first_name_'.$l}.' '.auth()->user()->{'last_name_'.$l} }}" required="" readonly>
                                        <input type="hidden" name="internal_id" value="{{Auth::id()}}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <input type="email" name="Email" class="form-control required email" value="{{auth()->user()->email}}" placeholder="{{ __('Your Mail')}} *" required="" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <input type="text" name="Phone" class="form-control" value="{{auth()->user()->phone}}" placeholder="{{ __('Your phone')}}" readonly>
                                    </div>
                                </div>

@else
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <input type="text" name="Name" class="form-control" value="" placeholder="{{ __('Your Name')}} *" required="">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <input type="email" name="Email" class="form-control required email" value="" placeholder="{{ __('Your Mail')}} *" required="">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <input type="text" name="Phone" class="form-control" value="" placeholder="{{ __('Your Phone')}}">
                                </div>
                            </div>
@endif
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <input type="text" name="Subject" class="form-control" value="" placeholder="{{ __('Subject')}}">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <textarea name="Comment" class="form-control textarea required" placeholder="{{ __('Your message')}} ..."></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input id="form_botcheck" name="form_botcheck" class="form-control" type="hidden" value="">
                                    <button class="thm-btn thm-color" type="submit" data-loading-text="{{ __('Wait')}}...">{{ __('Send')}}</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
    @endif
@stop

@section('scripts')

@stop
