<footer class="main-footer">    
    <!--Widgets Section-->
    <div class="widgets-section">
        <div class="container">
            <div class="row">
                <!--Big Column-->
                <div class="big-column col-md-6 col-sm-12 col-xs-12">
                    <div class="row clearfix">
                        
                        <!--Footer Column-->
                        <div class="footer-column col-md-6 col-sm-6 col-xs-12">
                            <div class="footer-widget about-widget">
                                <figure class="footer-logo"><a href="https://www.usaid.gov/"><img style="width: 80%;" src="/images/logo/usaid-logo.jpg" alt="USAID"></a></figure>                               
                                <div class="widget-content">
                                    <div class="text">
									<p>{{$l=='ar'?'هذا الموقع تم تنفيذه بدعم من الوكالة الأمريكية للتنمية الدولية.':'This portal was produced with the financial support of the USAID.'}}</p>
									<p>{{$l=='ar'?"كافة محتويات الموقع مسئولية الحاضنة الإفتراضية، ولا تعكس بالضرورة رؤى الوكالة الإمريكية.":"All contents are the sole responsibility of the VI and do not necessarily reflect the views of the USAID."}}</p> </div>
                                    <div class="link">
                                        <a href="https://www.usaid.gov/" class="default_link">{{$l=='ar'?"المزيد":"More About USAID"}}<i class="fa fa-angle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Footer Column-->
                        <div class="footer-column col-md-6 col-sm-6 col-xs-12">
                            <div class="footer-widget links-widget">
                                <div class="section-title">
                                    <h3>{{$l=='ar'?'خدمات الموقع':'What we do'}}</h3>
                                </div>
                                <div class="widget-content">
                                    <ul class="list">
		@foreach(App\Menu::where('menu_type','1')->orderBy('order')->get() as $menuItem)
                                <li><a href="{{$menuItem->url}}" target="{{ $menuItem->target }}">{{$l=='ar' ? $menuItem->ar_title : $menuItem->title}}</a></li>
		@endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>         
                <!--Big Column-->
                <div class="big-column col-md-6 col-sm-12 col-xs-12">
                    <div class="row clearfix">  
                        <!--Footer Column-->
                        <div class="footer-column col-md-6 col-sm-6 col-xs-12">
                            <div class="footer-widget posts-widget">
                                <div class="section-title">
                                    <h3>{{$l=="ar"?"آخر الأخبار":"latest news"}}</h3>
                                </div>
                                <div class="widget-content">
                                   @foreach (App\Posts::whereNotNull('published')->orderBy('created_at','DESC')->take(2)->get() as $post)
                                    <div class="post">
                                        <div class="content">
                                            <h4><a href="/blog/{{$post->id}}">{{$l=='ar'?Illuminate\Support\Str::limit($post->ar_title,40):Illuminate\Support\Str::limit($post->title,40)}}</a></h4>
                                        </div>
                                        <div class="time">{{date('d-m-Y', strtotime($post->created_at))}}</div>
                                    </div>
                                   	@endforeach 
                                </div>
                                
                            </div>
                        </div>
                        
                        <!--Footer Column-->
                        <div class="footer-column col-md-6 col-sm-6 col-xs-12">
                            <div class="footer-widget contact-widget">
                                <div class="section-title">
                                    <h3>{{$l=='ar'?'اتصل بنا':'Contact us'}}</h3>
                                </div>
                                <div class="widget-content">
                                    <ul class="contact-info">
                                        <li><span class="icon fa fa-paper-plane"></span>
										{!!$l=='ar'?$contact->ar_dsc:$contact->dsc!!}
										</li>
                                        <li><span class="icon fa fa-phone"></span><p style="direction:ltr;">{{$contact->ar_title}}</p></li>
                                        <li><span class="icon fa fa-envelope"></span>{{$contact->title}}</li>
                                    </ul>
                                </div>
                                <ul class="social">
								@foreach ($SocialIcons as $icon)
                                    <li><a href="{{$icon->url}}"><i class="fa fa-{{$icon->img_url}}"></i></a></li>
                                @endforeach
                                </ul>
                            </div>
                        </div>
           
                    </div>
                </div>
                
             </div>
         </div>
     </div>
     
     <!--Footer Bottom-->
     <section class="footer-bottom">
        <div class="container">
            <div class="pull-left copy-text">
                <p>{{$l=='ar'?"جميع الحقوق محفوظة © ".today()->year." - برمجة ":"Copyrights © ".today()->year." All Rights Reserved - Developed by "}}<a href="http://masterencode.com"> Masterencode</a>.</p>
                
            </div><!-- /.pull-right -->
            <div class="pull-right get-text">
                <ul>
@foreach(App\Menu::where('menu_type','2')->orderBy('order','asc')->get() as $menuItem)
  <li><a href="{{$menuItem->url}}" target="{{$menuItem->target}}">{{$l=='ar' ? $menuItem->ar_title : $menuItem->title}}</a></li>
@endforeach
                </ul>
            </div><!-- /.pull-left -->
        </div><!-- /.container -->
    </section>
</footer>