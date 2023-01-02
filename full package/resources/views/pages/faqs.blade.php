@extends('layouts.default')

@section('title')
{{$l=='ar' ? $CP = $t->ar_title . " - " ."الأسئلة المتكررة" : $CP = $t->title . " - " ."FAQs" }}

@stop

@section('content')

<div class="inner-banner has-base-color-overlay text-center" style="background: url(images/background/entrepreneur.jpg);">
    <div class="container">
        <div class="box">
            <h3>{{ __('FAQs') }}</h3>
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
                    {{ __('FAQs') }}
                </li>
            </ul><!-- /.list-line -->
        </div><!-- /.pull-left -->
    </div><!-- /.container -->
</div>


<section class="about-faq">
    <div class="container">
        <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="sec-padd">
                    <div class="accordion-box style-2">
                        @if (count($faqs)>0)
@foreach ($faqs as $n=>$faq)
                        <!--Start single accordion box-->
                        <div class="accordion animated out" data-delay="0" data-animation="fadeInUp">
                            <div class="acc-btn">
                                <p class="title">{{$n+1}}- {{$l=="ar"?$faq->title_ar:$faq->title_en}}</p>
                                <div class="toggle-icon">
                                    <span class="plus fa fa-angle-right"></span><span class="minus fa fa-angle-down"></span>
                                </div>
                            </div>
                            <div class="acc-content">
                                <div class="text"><p>
                                        {{$l=="ar"?$faq->answer_ar:$faq->answer_en}}.
                                    </p></div>
                            </div>
                        </div>
@endforeach
                        @else
                        <br />
                            <h1 style="text-align: center;">
                                Under construction
                            </h1>
                        <br />
                        @endif



                    </div>
                </div>

            </div>

        </div>
    </div>
</section>


@stop

@section('scripts')

@stop
