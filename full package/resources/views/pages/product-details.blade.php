@extends('layouts.default')
@section('title')
{{$l=='ar' ? $CP = $t->ar_title . " - " ."منتجات الأعضاء" : $CP = $t->title . " - " ."Members Products" }}
@stop
@section('content')
<div class="inner-banner has-base-color-overlay text-center" style="background: url(/images/background/1.jpg);">
    <div class="container">
        <div class="box">
            <h3>{{$product->{'name_'.$l} }}</h3>
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
                    <a href="/products">{{ __('Products') }}</a>
                </li>
                <li>
                    {{$product->{'name_'.$l} }}
                </li>
            </ul><!-- /.list-line -->
        </div><!-- /.pull-left -->
    </div><!-- /.container -->
</div>


<section class="shop-single-area">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-12 col-xs-12">
                <div class="single-products-details">
                    <div class="product-content-box">
                        <div class="row">
                            <div class="col-md-6 img-box">
                                <div class="flexslider">
                                    <ul class="slides">
                                        <li data-thumb="{{$product->img}}">
                                            <div class="thumb-image">
                                                <img src="{{$product->img}}" alt="" data-imagezoom="true" class="img-responsive">
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="content-box">
                                    <h3>{{$product->{'name_'.$l} }}</h3>
                                    @php($cat=App\ProductCategory::where('id',$product->cat_id)->first(['id','name_'.$l]))
                                    <span class="price" style="color: #000000;">{{__('Category')}}: <a style="color: #337ab7;" href="/products?cat={{$cat->id}}">{{$cat->{'name_'.$l} }}</a></span>
                                    <br /><br />
                                    <span class="price">{{$product->price>0?$product->price.' '.__('EGP'):__('Free')}}</span>
                                    <div class="text">
                                        {!! $product->{'dsc_'.$l} !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="product-tab-box">
                        <ul class="nav nav-tabs tab-menu">
                            <li class="active"><a aria-expanded="true">{{__('Seller details')}}</a></li>
                        </ul>
@php($usr=App\User::findorfail($product->user_id))

                        <div class="tab-content">
                            <div class="tab-pane active" >
                                <div class="product-details-content">
                                    <div class="desc-content-box">
                                        <div class="tab-title-h4">
                                            <h4>{{ $usr->{'first_name_'.$l}.' '.$usr->{'last_name_'.$l} }}
                                                {{$usr->company?'('.$usr->company->{'name_'.$l}.')':''}}
                                            </h4>
                                        </div>

                                        <div class="single-review-box">
                                            <div class="img-holder">
                                                <img src="/191014/{{$usr->img_url}}" width="64" alt="Awesome Image">
                                            </div>
                                            <div class="text-holder">
                                                <div class="top">
                                                    <div class="pull-left">
                                                        <h4><i class="fa fa-phone"> </i> &nbsp;{{$usr->phone}}</h4>
                                                        <br />
                                                        <h4><i class="fa fa-envelope"> </i> &nbsp;{{$usr->email}}</h4>
                                                        <br />
                                                        <h4>
                                                            @if ($usr->company->facebook)
                                                                <a href="{{$usr->company->facebook}}"> <i class="fa fa-facebook"> </i> </a>&nbsp;&nbsp;&nbsp;
                                                            @endif
                                                            @if ($usr->company->twitter)
                                                                 <a href="{{$usr->company->twitter}}"> <i class="fa fa-twitter"> </i> </a>&nbsp;&nbsp;&nbsp;
                                                            @endif
                                                            @if ($usr->company->linkedin)
                                                                 <a href="{{$usr->company->linkedin}}"> <i class="fa fa-linkedin"> </i> </a>&nbsp;&nbsp;&nbsp;
                                                            @endif
                                                                @if ($usr->company->youtube)
                                                                    <a href="{{$usr->company->youtube}}"> <i class="fa fa-youtube"> </i> </a>&nbsp;&nbsp;&nbsp;
                                                                @endif
                                                                @if ($usr->company->website)
                                                                    <a href="{{$usr->company->website}}"> <i class="fa fa-home"> </i> </a>
                                                                @endif
                                                        </h4>
                                                    </div>
                                                    <a href="/products?user={{$usr->id}}" class="thm-btn pull-right">{{__('Show all products')}}</a>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Start related product -->
                    <div class="related-product">
                        <div class="section-title">
                            <h3>{{__('Related products')}}</h3>
                        </div>
                        <div class="row">
                            <div class="related-product-items">
                                @foreach(App\Product::where('id','<>',$product->id)->where('cat_id',$product->cat_id)->take(3)->get() as $related)
                                <div class="col-md-4 col-sm-6 col-xs-12 hover-effect">
                                    <div class="single-shop-item">
                                        <div class="img-box">
                                            <img height="200" src="{{$related->img}}" alt="Product Image">
                                            <div class="default-overlay-outer">
                                                <div class="inner">
                                                    <div class="content-layer">
                                                        <a href="/product/{{$related->id}}" class="thm-btn thm-tran-bg">View</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.img-box -->
                                        <div class="content-box">
                                            <h4><a href="/product/{{$related->id}}">{{$related->{'name_'.$l} }}</a></h4>
                                            <div class="item-price"> {{$related->price?$related->price.__('EGP'):__('free') }}</div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!--End related product -->
                </div>
            </div>
            @include('includes.products_side')
        </div>
    </div>
</section>

@stop
@section('scripts')
    <script>
        function priceFilter() {
            if ($('.price-ranger').length) {
                var dbmax={{$pto=App\Product::where('approvedby','>','0')->max('price')}}
                var pfrom={{Request::get('from')?Request::get('from'):'0'}}
                var pto={{Request::get('to') != null?Request::get('to'):$pto}}
                    $('.price-ranger #slider-range').slider({
                        range: true,
                        min: 0,
                        max: dbmax,
                        values: [pfrom, pto],
                        slide: function(event, ui) {
                            $('.price-ranger .ranger-min-max-block .min').val(ui.values[0]);
                            $('.price-ranger .ranger-min-max-block .max').val(ui.values[1]);
                        }
                    });
                $('.price-ranger .ranger-min-max-block .min').val($('.price-ranger #slider-range').slider('values', 0));
                $('.price-ranger .ranger-min-max-block .max').val($('.price-ranger #slider-range').slider('values', 1));
            };
        }

        jQuery(document).on('ready', function () {
            (function ($) {
                priceFilter();
            })(jQuery);
        });

    </script>
@stop
