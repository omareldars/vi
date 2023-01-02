@extends('layouts.default')
@section('title')
{{$l=='ar' ? $CP = $t->ar_title . " - " ."المنتجات" : $CP = $t->title . " - " ."Products" }}
@stop
@section('content')
<div class="inner-banner has-base-color-overlay text-center" style="background: url(images/background/1.jpg);">
    <div class="container">
        <div class="box">
            <h3>{{ __('Products') }}</h3>
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
                    <a href="/products"> {{ __('Products') }}</a>
                </li>
                @if (Request::get('user'))
                <li>
                    @php($usr=App\User::findorfail(Request::get('user')))
                    {{$l=='ar'?'منتجات '.$usr->first_name_ar.' '.$usr->last_name_ar:$usr->first_name_en.' '.$usr->last_name_en.' products'}}
                </li>
                @endif
            </ul><!-- /.list-line -->
        </div><!-- /.pull-left -->
    </div><!-- /.container -->
</div>

<div class="shop">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-12 col-xs-12">
                <div class="row">
                    @if(count($products)>0)
                    @foreach($products as $product)
                    <div class="col-md-4 col-sm-6 col-xs-12 hover-effect">
                        <div class="single-shop-item">
                            <div class="img-box">
                                <img height="202" src="{{$product->img}}" alt="Product Image">
                                <div class="default-overlay-outer">
                                    <div class="inner">
                                        <div class="content-layer">
                                            <a href="/product/{{$product->id}}" class="thm-btn thm-tran-bg">{{__('View')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.img-box -->
                            <div class="content-box">
                                <h4><a href="#">{{ $product->{'name_'.$l} }}</a></h4>
                                <div class="item-price">{{$product->price==0?" ".__('Free'):$product->price." ".__('EGP')}}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                        <div class="col-md-4 col-sm-6 col-xs-12 hover-effect">
                            <div class="single-shop-item">
                               {{__('No products, please try again')}}.
                            </div>
                        </div>
                    @endif
                </div>
                <div class="border-bottom"></div>
                <br>
                <div style="text-align: center;">
                    {!! $products->appends(request()->input())->links(); !!}
                </div>
            </div>
            @include('includes.products_side')
        </div>
    </div>
</div>
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
