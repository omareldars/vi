<div class="col-md-3 col-sm-12 col-xs-12 sidebar_styleTwo">
                <div class="wrapper">
				    <form method="get" action="/products">
                    <div class="sidebar_search">
                            <input type="text" name="search" value="{{Request::input('search')}}" placeholder="{{__('Search')}} ...">
                            <button class="tran3s color1_bg"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div> <!-- End of .sidebar_styleOne -->
                    <div class="sidebar_categories">
                        <div class="theme_inner_title">
                            <h4>{{__('Categories')}}</h4>
                        </div>
                        <ul class="list">
                            <li>
                                <input id="cat" name="cat" value="" type="radio" class="cat_left" {{Request::input('cat')?'':'checked=""'}}>
                                <label for="cat">{{__('All categories')}}</label></li>
                            @foreach(App\ProductCategory::get() as $cat)
                            <li><input id="cat{{$cat->id}}" name="cat" value="{{$cat->id}}" type="radio" class="cat_left"
                                    {{Request::input('cat')==$cat->id?'checked=""':''}}>
                                <label for="cat{{$cat->id}}">{{$cat->{'name_'.$l} }}</label></li>
                            @endforeach
                        </ul>
                    </div> <!-- End of .sidebar_categories -->

                    <div class="price_filter wow fadeInUp">
                        <div class="theme_inner_title">
                            <h4>{{__('Price')}}</h4>
                        </div>
                        <div class="single-sidebar price-ranger">
                            <div id="slider-range"></div>
                            <div class="ranger-min-max-block">
                                <input type="submit" value="{{__('Search')}}">
                                <span>{{__('Price')}}</span>
                                <input name="from" type="text" readonly class="min">
                                <span>-</span>
                                <input name="to"  type="text" readonly class="max">

                            </div>
                        </div> <!-- /price-ranger -->
                    </div> <!-- /price_filter -->
                    </form>
                    <div class="best_sellers clear_fix wow fadeInUp">
                        <div class="theme_inner_title">
                            <h4>{{__('Latest products')}}</h4>
                        </div>
                        <div class="best-selling-area">
                            @foreach(App\Product::where('approvedby','>','0')->orderBy('approveddate','DESC')->take(5)->get() as $latest)
                            <div class="best_selling_item clear_fix border">
                                <div class="img_holder float_left">
                                    <a href="/product/{{$latest->id}}">
                                    <img src="{{$latest->img}}" alt="image" height="70">
                                    </a>
                                </div> <!-- End of .img_holder -->
                                <div class="text float_left">
                                    <a href="/product/{{$latest->id}}"><h6>{{ $latest->{'name_'.$l} }}</h6></a>
                                    <span>{{ $latest->price>0 ? $latest->price . " ".__('EGP'):" ".__('Free') }}</span>
                                </div> <!-- End of .text -->
                            </div> <!-- End of .best_selling_item -->
                            @endforeach
                        </div>
                    </div> <!-- End of .best_sellers -->
                </div> <!-- End of .wrapper -->
            </div>
