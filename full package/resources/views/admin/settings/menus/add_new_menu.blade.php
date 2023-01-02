@extends('layouts.admin')
@section('content') 
<!-- BEGIN: Content--> 
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('settings.Menusettings')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/admin/menus"><i class="bx bx-menu"></i></a>
                                    </li>
									<li class="breadcrumb-item active">{{__('settings.AddNew')}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<div class="content-body">
                <section id="multiple-column-form">
                    <div class="row match-height">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
<form class="form-horizontal form-bordered" id="basicForm" action= "/admin/store_menu" method="POST" enctype="multipart/form-data">
               							 {!! csrf_field() !!}
                                            <div class="form-body">
                                                <div class="row">
												<div class="col-md-12 col-12">
												<label>{{__('settings.SelectMenu')}}</label>
													<fieldset class="form-group">
                                                    <select class="form-control" id="basicSelect" name="menu_type">
                                                        <option value="0" selected>{{__('settings.MainMenu')}}</option>
                                                        <option value="1">{{__('settings.FooterMenu')}}</option>
                                                        <option value="2">{{__('settings.LineMenu')}}</option>
                                                    </select>
                                                	</fieldset>
												</div>
												<div class="col-md-12 col-12">
												<label>{{__('settings.SelectParent')}}</label>
													<fieldset class="form-group">
                                                    <select class="form-control" id="basicSelect" name="parent_id">
                                                        <option value="0" selected>{{__('settings.NoParent')}}</option>
                                       @foreach(App\Menu::where('menu_type','0')->where('parent_id','0')->orderBy('order','asc')->get() as $menuItem)
														<option value="{{$menuItem->id}}">{{$l=='ar'?$menuItem->ar_title:$menuItem->title}}</option>
										@endforeach
                                                    </select>
                                                	</fieldset>
												</div>
												
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" class="form-control" placeholder="{{__('settings.ARABICTITLE')}}" name="ar_title" required>
                                                            <label for="ar_title">{{__('settings.ARABICTITLE')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" class="form-control" placeholder="{{__('settings.ENGLISHTITLE')}}" name="title" required>
                                                            <label for="title">{{__('settings.ENGLISHTITLE')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" class="form-control" placeholder="{{__('settings.URLOF')}} - http://google.com or login" name="url" required>
                                                            <label for="ar_img_desc">{{__('settings.URLOF')}}</label>
                                                        </div>
                                                    </div>
                                                   <div class="col-md-12 col-12">
													<label>{{__('settings.SelectTarget')}}</label>
													<fieldset class="form-group">
                                                    <select class="form-control" id="basicSelect" name="target" required>
                                                        <option value="_self" selected>open in the Same Page</option>
                                                        <option value="_blank">Open in New Page</option>
                                                        <option value="_top">Open in the full body</option>
                                                    </select>
                                                	</fieldset>
													</div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                            <input type="text" class="form-control" placeholder="{{__('settings.OrderNumber')}}" name="order">
                                                        	<label>{{__('settings.OrderNumber')}}</label>
														</div>
                                                    </div>
                                                    <div class="col-12 d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1">{{__('settings.Submit')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic multiple Column BuilderForm section end -->
            </div>
        </div>
    </div>
    <!-- END: Content-->			
@stop