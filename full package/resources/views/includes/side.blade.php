 <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="blog-sidebar">
                    <?php
                    $latest = App\Posts::whereNotNull('published')->orderBy('created_at','DESC')->take(3)->get();
                    ?>
                    @if (count($latest)>0)
                    <div class="sidebar_search">
                       <form action="/search">
                            <input type="text" name="find" placeholder="{{ __('Search') }}...." required>
                            <button class="tran3s color1_bg"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </form>
                    </div>

                    <div class="popular_news">
                        <div class="inner-title">
                            <h4>{{ __('Latest news') }}</h4>
                        </div>

                        <div class="popular-post">
			@foreach ($latest as $post)
                            <div class="item">
                                <div class="post-thumb"><a href="/blog/{{$post->id}}"><img src="/images/blog/{{$post->image?$post->image:'1.jpg'}}" alt=""></a></div>
                                <h4><a href="/blog/{{$post->id}}">{{$l=='ar'?Illuminate\Support\Str::limit($post->ar_title,30):Illuminate\Support\Str::limit($post->title,20)}}</a></h4>
                                <div class="post-info">{{date('M Y', strtotime($post->created_at))}} </div>
                            </div>
			@endforeach
                        </div>
                    </div>
                    @endif

                    <div class="inner-title">
                        <h4>{{__('Facebook Feed')}}</h4>
                    </div>
                    <div id="fb-root"></div>
                    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/{{$l=='ar'?'ar_AR':'en_US'}}/sdk.js#xfbml=1&version=v6.0&appId=916672995416278"></script>
                    <div class="facebook-feed">
                        <div class="fb-page" data-href="https://www.facebook.com/mift.media/" data-tabs="timeline" data-width="" data-height="" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/mift.media/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/mift.media/">Ministry of Trade and Industry</a></blockquote></div>
                    </div>

                </div> <!-- End of .wrapper -->
            </div>
