<!-- BEGIN: Header-->
@php
$msgs = 0;
if (Auth::user()->hasanyRole('Admin|Manager')) {
    $msgs = App\Messages::where('read',0)->count();
}
$messages = App\Messenger::where('receiver',Auth::user()->id)->whereNull('read')->count();
$all = $msgs + $messages;
isset(Auth::user()->company()->first()->id)?$companyid=Auth::user()->company()->first()->id:$companyid=null;
@endphp
    <div class="header-navbar-shadow"></div>
    <nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top ">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">
                    <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                        <ul class="nav navbar-nav">
                            <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon bx bx-menu"></i></a></li>
                        </ul>
                    </div>
                    <ul class="nav navbar-nav float-right">
                        <li class="nav-item d-lg-block"><a class="nav-link nav-link-search"
                        @if(Request::is('admin/documentation/view*'))
                        href="/admin" ><i class="ficon bx bx-arrow-back">
                        @else
                        href="/admin/documentation/view" ><i class="ficon bx bx-help-circle">
                        @endif
                                </i></a></li>
                        <li class="nav-item d-lg-block"><a class="nav-link nav-link-search" href="/admin/dark?l={{session('layout')??'dark'}}" ><i class="ficon bx {{session('icon')??'bx-moon'}}"></i></a></li>
                        @hasrole('Admin|Manager')
                        <li class="nav-item nav-search"><a class="nav-link nav-link-search"><i class="ficon bx bx-search"></i></a>
                            <div class="search-input">
                                <div class="search-input-icon"><i class="bx bx-search primary"></i></div>
                                <input class="input" type="text" placeholder="{{__('Search')}} ..." tabindex="-1" data-search="template-list-{{$l}}">
                                <div class="search-input-close"><i class="bx bx-x"></i></div>
                                <ul class="search-list"></ul>
                            </div>
                        </li>
                        @endhasrole
					<li class="dropdown dropdown-language nav-item">
				@if ($l=='ar')
                        <a class="dropdown-toggle nav-link" href="/lang/en">
						<i class="flag-icon flag-icon-us"></i>
                        <span class="selected-language">English</span></a>
				@else
						<a class="dropdown-toggle nav-link" href="/lang/ar">
						<i class="flag-icon flag-icon-eg"></i>
                        <span class="selected-language">عربي</span></a>
				@endif
                        </li>

						<li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-search" href="/" target="_blank"><i class="ficon bx bx-home"></i></a></li>
                        <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i class="ficon bx bx-fullscreen"></i></a></li>
                        <li class="dropdown dropdown-notification nav-item">
                            <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon bx bx-bell bx-tada bx-flip-horizontal"></i><span class="badge badge-pill badge-danger badge-up notif-count">{{$all==0?'':$all}}</span></a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                <li class="dropdown-menu-header" >
                                    <div class="dropdown-header px-1 py-75 d-flex justify-content-between"><span class="notification-title"><span class="notif-count">{{$all}}</span> {{__('admin.NewNotify')}}</span><span class="text-bold-400 cursor-pointer"><a onclick="location.reload();">{{__('admin.MarkRead')}}</a></span></div>
                                </li>
                                <li class="scrollable-container media-list" data-count="0" >

                                    @if ($messages)
                                        <a class="d-flex justify-content-between" href="/admin/inbox">
                                            <div class="media d-flex align-items-center">
                                                <div class="media-left pr-0">
                                                    <div class="mr-1"><i class="bx bxs-envelope bx-md"></i></div>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="media-heading">{{__('admin.YouHve')}} <span id="notif-plus-count1">{{$messages}}</span> {{__('admin.UnreadM')}}</h6>
                                                </div>
                                            </div>
                                        </a>
                                    @endif
                                    @hasanyrole('Admin|Manager')
                                    @if ($msgs)
                                    <a class="d-flex justify-content-between" href="/admin/mymsg">
                                        <div class="media d-flex align-items-center">
                                            <div class="media-left pr-0">
                                                <div class="mr-1"><i class="bx bxs-envelope bx-md"></i></div>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading">{{__('admin.YouHve')}} <span id="notif-plus-count2">{{$msgs}}</span> {{__('admin.UnreadCM')}}</h6>
                                            </div>
                                        </div>
                                    </a>
                                    @endif
                                    @endhasanyrole
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <div class="user-nav d-sm-flex d-none"><span style="font-weight: 500;" class="user-name">{{Auth::user()->first_name_ar?Auth::user()->{'first_name_'.$l}.' '.Auth::user()->{'last_name_'.$l}:Auth::user()->first_name_en.' '.Auth::user()->last_name_en}}</span>
                                <span class="user-status text-muted">{{ Auth::user()->{'title_'.$l} }}</span></div><span>
                                 <img class="round" src="/191014/{{Auth::user()->img_url?Auth::user()->img_url:'/users/avatar.jpg'}}" alt="avatar" height="40" width="40">
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right pb-0">
							<a class="dropdown-item" href="/admin/myProfile"><i class="bx bx-user mr-50"></i>{{ __('admin.Profile') }}</a>
@if ($companyid)
                            <a class="dropdown-item" href="/admin/myCompany"><i class="bx bxs-factory mr-50"></i>{{ __('admin.Company') }}</a>
@endif
                                <div class="dropdown-divider mb-0"></div><a class="dropdown-item" href="{{ route('logout') }}"  onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="bx bx-power-off mr-50"></i> {{ __('admin.Logout') }}</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                            </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->