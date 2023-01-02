<section class="theme_menu stricky">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="main-logo">
                    <a href="/"><img style="height: 50px;" src="/images/logo/logo-{{$l=='ar'?'ar':'en'}}.png" alt="VI logo"></a>
                </div>
            </div>
            <div class="col-md-9 menu-column">
                <nav class="menuzord" id="main_menu">
                   <ul class="menuzord-menu">
@foreach(App\Menu::where('menu_type','0')->orderBy('order','asc')->get() as $menuItem)
	 @if( $menuItem->parent_id == 0 )
	 		@if($menuItem->children->isEmpty())
                            <li class="{{substr(request()->getRequestUri(),0,4)==substr($menuItem->url,0,4)?'active':''}}"><a href="{{ $menuItem->url }}" target="{{ $menuItem->target }}">{{$l=='ar' ? $menuItem->ar_title : $menuItem->title}}</a></li>
			@else
							<li><a href="{{ $menuItem->url }}" target="{{ $menuItem->target }}">{{$l=='ar' ? $menuItem->ar_title : $menuItem->title}}</a>
                                <ul class="dropdown">
				@foreach($menuItem->children->sortBy('order') as $subMenuItem)
                                                    <li><a href="{{ $subMenuItem->url }}" target="{{ $menuItem->target }}">{{$l=='ar' ? $subMenuItem->ar_title : $subMenuItem->title}}</a></li>
				@endforeach
                                </ul>
							</li>
			@endif
	 @endif
@endforeach
                    </ul><!-- End of .menuzord-menu -->
                </nav> <!-- End of #main_menu -->
            </div>
  <div class="right-column">
                <div class="right-area">
                    <div class="nav_side_content">
                        <div class="search_option">
                            <button class="search tran3s dropdown-toggle color1_bg" id="searchDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-search" aria-hidden="true"></i></button>
                            <form action="/search" class="dropdown-menu" aria-labelledby="searchDropdown">
                                <input type="text" name="find" placeholder="{{__('Search')}}..." required>
                                <button><i class="fa fa-search" aria-hidden="true"></i></button>
                            </form>
                       </div>

                   </div>
                   <div class="link_btn float_right">
@if (Auth::guest())
                            <a href="/login" class="thm-btn">{{__('Login')}}</a>
@else
                            <a title="{{__('My account')}}" href="/admin"><i class="fa fa-user" style="font-size: 1.5em;color: #0e5583;"></i></a>
                            <a  title="{{__('Sign out')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" href="{{ route('logout') }}">
                                <i class="fa fa-sign-out" style="font-size: 1.5em;color: #d43d71;padding:15px {{$l=='ar'?'25px 0 0':'0 0 25px'}};"></i></a>
                           <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                               @csrf
                           </form>
@endif
                   </div>
                </div>

            </div>
        </div>
   </div> <!-- End of .conatiner -->
</section>
