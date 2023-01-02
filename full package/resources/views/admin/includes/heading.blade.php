<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">@yield('title')</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><a href="/admin">
                                <i class="bx bx-home-alt"></i></a>
                        </li>
                        @hasSection('index_url')
                            <li class="breadcrumb-item"><a href="@yield('index_url')">
                                    <i class="bx bx-briefcase"></i></a>
                            </li>
                        @endif
                        <li class="breadcrumb-item active">@yield('subTitle')
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
