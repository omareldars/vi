        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto"><a class="navbar-brand" href="/admin">
                        <div class="brand-logo"></div>
                        <h2 class="brand-text mb-0">{{config('app.name')}}</h2>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i
                            class="bx bx-x d-block d-xl-none font-medium-4 primary"></i><i
                            class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block primary"
                            data-ticon="bx-disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation"
                data-icon-style="lines">
                <li class="{{Request::is('admin','admin/final/*/*','admin/companyProfile/*','admin/cycles/view/*','admin/cycles/my/*','admin/screening/*/*')?'active':''}} nav-item"><a href="/admin"><i class="menu-livicon"
                            data-icon="desktop"></i><span class="menu-title"
                            >{{__('admin.Dashboard')}}</span></a>
                </li>
                <li class="{{Request::is('*myProfile')?'active':''}} nav-item">
                    <a href="{{route('my_profile')}}">
                        <i class="menu-livicon" data-icon="user"></i>
                        <span class="menu-title">{{__('admin.Profile')}}</span>
                    </a>
                </li>
                @if(auth()->user()->HaveCompany==1)
                    <li class="{{Request::is('*myCompany')?'active':''}} nav-item">
                        <a href="{{route('my_company')}}">
                            <i class="menu-livicon" data-icon="building"></i>
                            <span class="menu-title" >{{__('admin.My company')}}</span>
                        </a>
                    </li>
                @endif
                <li class="{{Request::is('*calendar*')?'active':''}} nav-item">
                    <a href="{{route('calendar')}}">
                        <i class="menu-livicon" data-icon="calendar"></i>
                        <span class="menu-title">{{__('admin.Calendar')}}</span>
                    </a>
                </li>
<?php
$unread = \App\Messenger::where('receiver',Auth::user()->id)->whereNull('read')->count();
$l=='ar'?$arrow='left':$arrow='right';
?>
                <li class="{{Request::is('admin/inbox','admin/outbox','admin/mymsg','admin/sendmessage')?'sidebar-group-active open':''}} nav-item "><a href="#"><i class="menu-livicon" data-icon="comments"></i>
                        <span class="menu-title" >{{__('admin.My messages')}}</span>
                    </a>
                <ul class="menu-content">
                <li class="{{Request::is('admin/sendmessage')?'active':''}}"><a href="/admin/sendmessage"><i class="bx bx-message"></i>
                            <span class="menu-item" >{{__('admin.New Message')}}</span>
                        </a>
                </li>
                <li class="{{Request::is('admin/inbox')?'active':''}}"><a href="/admin/inbox"><i class="bx bxs-inbox"></i>
                        <span class="menu-item" >{{__('admin.myinbox')}}</span>
                        @if($unread>0)  <span class="badge badge-pill badge-round badge-dark-info float-right mr-50 ml-auto">{{$unread}}</span>@endif
                    </a>
                </li>
                <li class="{{Request::is('admin/outbox')?'active':''}}"><a href="/admin/outbox"><i class="bx bx-mail-send"></i>
                            <span class="menu-item" >{{__('admin.myoutbox')}}</span></a>
                </li>
                    @can('view_messages')
                <li class="{{Request::is('admin/mymsg')?'active':''}}"><a href="/admin/mymsg"><i class="bx bx-support"></i><span class="menu-item"
                                >{{__('admin.contactus')}}</span></a>
                </li>
                    @endcan
                </ul>
                </li>
              	
                <li class="{{Request::is('admin/directory')?'active':''}} nav-item"><a href="/admin/directory">
                        <i class="menu-livicon" data-icon="search"></i>
                        <span class="menu-title" >{{__('admin.Services')}}</span></a>
                </li>
              @role('Registered')
                <li class="{{Request::is('admin/requests/mine','/admin/mentorship/mine')?'sidebar-group-active open':''}} nav-item "><a href="#"><i class="menu-livicon" data-icon="two-pointers"></i>
                        <span class="menu-title" >{{__('admin.My Requests')}}</span>
                    </a>
                    <ul class="menu-content">
                      
                        <li class="{{Request::is('admin/requests/mine')?'active':''}}"><a href="/admin/requests/mine"><i class="bx bx-{{$arrow}}-arrow-alt"></i>
                                <span class="menu-item" >{{__('admin.Services')}}</span>
                            </a>
                        </li>
                      
                        <li class="{{Request::is('admin/mentorship/mine')?'active':''}}"><a href="/admin/mentorship/mine"><i class="bx bx-{{$arrow}}-arrow-alt"></i>
                                <span class="menu-item" >{{__('admin.Mentorship')}}</span>
                            </a>
                        </li>
                    </ul>
                </li>
              	
                <li class="{{Request::is('admin/training/my*')?'active':''}} nav-item"><a href="/admin/training/my">
                        <i class="menu-livicon" data-icon="help"></i>
                        <span class="menu-title" >{{__('admin.My courses')}}</span></a>
                </li>
                @endrole
                <li class="{{Request::is('admin/myFiles')?'active':''}} nav-item"><a href="/admin/myFiles">
                        <i class="menu-livicon" data-icon="save"></i>
                        <span class="menu-title" >{{__('admin.filemanager')}}</span></a>
                </li>
                @canany (['view_user','view_log','view_forms','view_report'])
                <li class=" navigation-header"><span>{{__('admin.Portal Settings')}}</span>
                </li>
                @endcanany
                @can ('edit_forms')
                    <li class="{{Request::is('admin/show-builder*','admin/show-form*')?'active':''}} nav-item"><a href="/admin/show-builder">
                            <i class="menu-livicon" data-icon="thumbnails-big"></i>
                            <span class="menu-title" >{{__('admin.Forms builder')}}</span></a>
                    </li>
                @endcan
                @can ('edit_cycles')
                    <li class="{{Request::is('admin/cycles*')?'active':''}} nav-item"><a href="/admin/cycles">
                            <i class="menu-livicon" data-icon="retweet"></i>
                            <span class="menu-title" >{{__('admin.Cycles')}}</span></a>
                    </li>

                    <li class="{{Request::is('admin/screening*')?'sidebar-group-active open':''}} nav-item">
                        <a href="#"><i class="menu-livicon" data-icon="hourglass"></i><span class="menu-title"
                            > {{__('admin.Screening')}}</span></a>
                        <ul class="menu-content">
                            <li class="{{Request::is('admin/screening','admin/*/screening')?'active':''}}"><a href="/admin/screening"><i class="bx bx-{{$arrow}}-arrow-alt"></i><span class="menu-item"
                                    > {{__('admin.Manage')}}</span></a>
                            </li>
                            <li class="{{Request::is('admin/screening/results*')?'active':''}}"><a href="/admin/screening/results"><i class="bx bx-{{$arrow}}-arrow-alt"></i><span class="menu-item"
                                    > {{__('admin.Results')}}</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{Request::is('admin/mentorship/assign*','admin/mentorship/view*','admin/mentorship/sessions*')?'sidebar-group-active open':''}} nav-item">
                        <a href="#"><i class="menu-livicon" data-icon="idea"></i><span class="menu-title" > {{__('admin.Mentorship')}}</span></a>
                        <ul class="menu-content">
                            <li class="{{Request::is('admin/mentorship/assign*')?'active':''}}"><a href="/admin/mentorship/assign"><i class="bx bx-{{$arrow}}-arrow-alt"></i><span class="menu-item" > {{__('admin.Cycles Mentors')}}</span></a>
                            </li>
                            <li class="{{Request::is('admin/mentorship/view*')?'active':''}}"><a href="/admin/mentorship/view"><i class="bx bx-{{$arrow}}-arrow-alt"></i><span class="menu-item" > {{__('admin.Manage')}}</span></a>
                            </li>
                            <li class="{{Request::is('admin/mentorship/sessions*')?'active':''}}"><a href="/admin/mentorship/sessions"><i class="bx bx-{{$arrow}}-arrow-alt"></i><span class="menu-item" > {{__('admin.Sessions')}}</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{Request::is('*training*')?'sidebar-group-active open':''}} nav-item">
                        <a href="#"><i class="menu-livicon" data-icon="info-alt"></i><span class="menu-title"> {{__('admin.Training')}}</span></a>
                        <ul class="menu-content">
                            <li class="{{Request::is('admin/training/sessions*')?'active':''}}"><a href="/admin/training/sessions"><i class="bx bx-{{$arrow}}-arrow-alt"></i><span class="menu-item"> {{__('admin.Training sessions')}}</span></a>
                            </li>
                            <li class="{{Request::is('admin/training/all*','admin/training/addcontent*','admin/training/editcontent*','admin/training/viewcontent*')?'active':''}}">
                                <a href="/admin/training/all"><i class="bx bx-{{$arrow}}-arrow-alt"></i><span class="menu-item"> {{__('admin.Training courses')}}</span></a>
                            </li>
                            <li class="{{Request::is('admin/training/results*')?'active':''}}"><a href="/admin/training/results"><i class="bx bx-{{$arrow}}-arrow-alt"></i><span class="menu-item"> {{__('admin.Results')}}</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{Request::is('admin/final/*')?'sidebar-group-active open':''}} nav-item">
                        <a href="#"><i class="menu-livicon" data-icon="trophy"></i><span class="menu-title"
                            > {{__('admin.Final Screening')}}</span></a>
                        <ul class="menu-content">
                            <li class="{{Request::is('admin/final','admin/*/final')?'active':''}}"><a href="/admin/final"><i class="bx bx-{{$arrow}}-arrow-alt"></i><span class="menu-item"
                                    > {{__('admin.Manage')}}</span></a>
                            </li>
                            <li class="{{Request::is('admin/final/results*')?'active':''}}"><a href="/admin/final/results"><i class="bx bx-{{$arrow}}-arrow-alt"></i><span class="menu-item"
                                    > {{__('admin.Results')}}</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{Request::is('*services*','','admin/requests/all','admin/room*')?'sidebar-group-active open':''}} nav-item">
                        <a href="#"><i class="menu-livicon" data-icon="loader-10"></i><span class="menu-title"
                            > {{__('admin.Services')}}</span></a>
                        <ul class="menu-content">
                            <li class="{{Request::is('admin/requests/all','admin/requests/old')?'active':''}}"><a href="{{route('requests')}}"><i class="bx bx-{{$arrow}}-arrow-alt"></i>
                                    <span class="menu-item"> {{__('admin.Requests')}}</span></a>
                            </li>
                            <li class="{{Request::is('admin/services/create')?'active':''}}"><a href="{{route('services.create')}}"><i class="bx bx-{{$arrow}}-arrow-alt"></i><span class="menu-item"
                                    > {{__('admin.Add Service')}}</span></a>
                            </li>
                            <li class="{{Request::is('admin/services','admin/services/*/edit')?'active':''}}"><a href="{{route('services.index')}}"><i class="bx bx-{{$arrow}}-arrow-alt"></i><span class="menu-item"
                                    > {{__('admin.All Services')}}</span></a>
                            </li>
                            <!--
                            <li class="{{Request::is('admin/room*','')?'active':''}}"><a href="{{route('rooms.index')}}"><i class="bx bx-{{$arrow}}-arrow-alt"></i><span class="menu-item"
                                    > {{__('admin.Rooms Management')}}</span></a>
                            </li> -->
                            <li class="{{Request::is('admin/serviceCategories*')?'active':''}}"><a href="{{route('serviceCategories.index')}}"><i class="bx bx-{{$arrow}}-arrow-alt"></i><span class="menu-item"
                                    > {{__('admin.Services Categories')}}</span></a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('view_user')
                    <li class="{{Request::is('*users*')?'sidebar-group-active open':''}} nav-item">
                        <a href="#"><i class="menu-livicon" data-icon="users"></i><span class="menu-title"
                            > {{__('admin.Users')}}</span></a>
                        <ul class="menu-content">
                            <li class="{{Request::is('admin/users/create')?'active':''}}"><a href="{{route('users.create')}}"><i class="bx bx-{{$arrow}}-arrow-alt"></i><span class="menu-item"
                                    > {{__('admin.Add New')}}</span></a>
                            </li>
                            <li class="{{Request::is('admin/users','admin/users/*/edit')?'active':''}}"><a href="{{route('users.index')}}"><i class="bx bx-{{$arrow}}-arrow-alt"></i><span class="menu-item"
                                    > {{__('admin.List All')}}</span></a>
                            </li>
                            <li class="{{Request::is('admin/companies')?'active':''}}"><a href="{{route('users.companies')}}"><i class="bx bx-{{$arrow}}-arrow-alt"></i><span class="menu-item"
                                    > {{__('admin.Companies')}}</span></a>
                            </li>
                            @can('view_permissions')
                                <li class="{{Request::is('admin/permissions*')?'active':''}}"><a href="{{route('permissions.index')}}"><i class="bx bx-{{$arrow}}-arrow-alt"></i><span class="menu-item"
                                        > {{__('admin.Permissions')}}</span></a>
                                </li>
                                <li class="{{Request::is('admin/roles*')?'active':''}}"><a href="{{route('roles.index')}}"><i class="bx bx-{{$arrow}}-arrow-alt"></i><span class="menu-item"
                                        > {{__('admin.Roles')}}</span></a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('view_documentation')
                    <li class="{{Request::is('admin/documentation*')?'active':''}} nav-item"><a href="/admin/documentation">
                            <i class="menu-livicon" data-icon="morph-folder"></i>
                            <span class="menu-title" >{{__('admin.Documentations')}}</span></a>
                    </li>
                @endcan
                @can ('view_log')
                    <li class="{{Request::is('*audit-logs*')?'active':''}} nav-item"><a href="/admin/audit-logs"><i class="menu-livicon"
                                                                                                                    data-icon="lab"></i><span class="menu-title"
                            >{{__('admin.Log viewer')}}</span></a>
                    </li>
                @endcan
                @can ('view_report')
                <li class="{{Request::is('reports*')?'active':''}} nav-item"><a href="/reports"><i class="menu-livicon"
                                                                                                              data-icon="notebook"></i><span class="menu-title"
                                                                                                                                         >{{__('admin.Reports')}}</span></a>
                </li>
                @endcan
                @can('edit_settings')
                    <li class=" navigation-header"><span>{{__('admin.Frontend settings')}}</span>
                    </li>
                    <li class="{{Request::is('admin/settings')?'active':''}} nav-item"><a href="/admin/settings"><i class="menu-livicon"
                                                                                                                    data-icon="wrench"></i><span class="menu-title"
                            >{{__('admin.Homesettings')}}</span></a>
                    </li>
                    <li class="{{Request::is('admin/setaboutus')?'active':''}} nav-item"><a href="/admin/setaboutus"><i
                                    class="menu-livicon" data-icon="globe"></i><span class="menu-title"
                            >{{__('admin.About Settings')}}</span></a>
                    </li>
                    <li class="{{Request::is('admin/setcontactus')?'active':''}} nav-item"><a href="/admin/setcontactus"><i
                                    class="menu-livicon" data-icon="paper-plane"></i><span class="menu-title"
                            >{{__('admin.Contact Settings')}}</span></a>
                    </li>
                @endcan
                @can ('manage_menus')
                    <li class="{{Request::is('*menu*')?'active':''}} nav-item"><a href="/admin/menus"><i class="menu-livicon"
                                                                                                         data-icon="morph-menu-arrow-bottom"></i><span class="menu-title"
                            >{{__('admin.Menusettings')}}</span></a>
                    </li>
                @endcan
                @can ('view_slide')
                    <li class="{{Request::is('*slide*')?'active':''}} nav-item"><a href="/admin/slides"><i class="menu-livicon"
                                                                                                           data-icon="settings"></i><span class="menu-title"
                            >{{__('admin.Slidersettings')}}</span></a>
                    </li>
                @endcan
                @can ('manage_pages')
                    <li class="{{Request::is('*page*')?'active':''}} nav-item"><a href="/admin/pages"><i class="menu-livicon"
                                                                                                         data-icon="briefcase"></i><span class="menu-title"
                            >{{__('admin.Pagesettings')}}</span></a>
                    </li>
                @endcan
                @can ('manage_posts')
                    <li class="{{Request::is('*post*')?'active':''}} nav-item"><a href="/admin/posts"><i class="menu-livicon"
                                                                                                         data-icon="box-add"></i><span class="menu-title"
                            >{{__('admin.Postsettings')}}</span></a>
                    </li>
                @endcan
                @can ('view_faqs')
                    <li class="{{Request::is('*faqs*')?'active':''}} nav-item"><a href="/admin/faqs"><i class="menu-livicon"
                                                                                                        data-icon="comments"></i><span class="menu-title"
                            >{{__('admin.Faqs settings')}}</span></a>
                    </li>
                @endcan
                @can ('view_partner')
                    <li class="{{Request::is('*partners*')?'active':''}} nav-item"><a href="/admin/partners"><i class="menu-livicon"
                                                                                                                data-icon="share"></i><span class="menu-title"
                            >{{__('admin.partners settings')}}</span></a>
                    </li>
                @endcan
                @can ('view_press')
                    <li class="{{Request::is('*press*')?'active':''}} nav-item"><a href="/admin/press"><i class="menu-livicon"
                                                                                                          data-icon="paper-clip"></i><span class="menu-title"
                            >{{__('admin.press settings')}}</span></a>
                    </li>
                @endcan
                @can('manage_events')
                    <li class="{{Request::is('*event*')?'active':''}} nav-item"><a href="/admin/allevents"><i class="menu-livicon"
                                                                                                              data-icon="calendar"></i><span class="menu-title">{{__('admin.manageevents')}}</span></a>
                    </li>
                @endcan
                @can('manage_page')
                    @if (Auth::user()->PageId)
                        <li class="{{Request::is('editmypage')?'active':''}} nav-item"><a href="/admin/editmypage"><i class="menu-livicon"
                                                                                                                      data-icon="briefcase"></i><span class="menu-title">{{__('admin.editmypage')}}</span></a>
                        </li>
                    @endif
                @endcan
            </ul>
        </div>