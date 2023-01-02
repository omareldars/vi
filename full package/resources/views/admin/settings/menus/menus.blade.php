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
                                    <li class="breadcrumb-item active"> {{__('settings.EditSettings')}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<div class="invoice-create-btn mb-1">
						<a href="/admin/add_menu" class="btn btn-primary glow">{{__('settings.AddNew')}}</a>
                        <a href="/admin" class="btn btn-success glow">{{__('settings.BackHome')}}</a>
            </div>
            <div class="content-body">
                <!-- Zero configuration table -->
                <section id="basic-datatable">

				@if(session()->has('message'))
				<div class="alert alert-success alert-dismissible mb-2" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <div class="d-flex align-items-center">
                                                <i class="bx bx-like"></i>
                                                <span>
                                                    {{ __('admin.'.session()->get('message')) }}
                                                </span>
                                            </div>
                  </div>
					@endif
					@if(session()->has('message2'))
					 <div class="alert alert-danger alert-dismissible mb-2" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <div class="d-flex align-items-center">
                                                <i class="bx bx-error"></i>
                                                <span>
                                                    {{ __('admin.'.session()->get('message2')) }}
                                                </span>
                                            </div>
                     </div>
					 @endif

<?php $n=1; ?>
@if (count($getMenus)>0)
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
								<h4 class="text-bold-400">{{__('settings.MainMenuItems')}}</h4>
                                </div>

                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                    <tr>
                                                        <th>{{__('settings.ARABICTITLE')}}</th>
                                                        <th>{{__('settings.ENGLISHTITLE')}}</th>
                                                        <th>{{__('settings.URLOF')}}</th>
														<th>Target</th>
                                                        <th>{{__('settings.EditDelete')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                           		@foreach ($getMenus->where('menu_type','0') as $getMenusA)
                                                    <tr>
													@if( $getMenusA->parent_id == 0 )
														@if($getMenusA->children->isEmpty() )
                                                        <td class="primary">{{$getMenusA->order}}- <b>{{ $getMenusA->ar_title}}</b></td>
                                                        <td>{{$getMenusA->title}}</td>
                                                        <td>{{$getMenusA->url}}</td>
														<td>{{$getMenusA->target}}</td>
                                                        <td><a href="/admin/edit_menu/{{$getMenusA->id}}"><i class="bx
bx-edit-alt"> </i></a> |
                                   <a onclick="return confirm('{{__('settings.SureDelete')}}');" href="{{URL::to('/admin/delete_menu/'.$getMenusA->id ?? null)}}"><i class="bx bx-trash"> </i></a></td>
                                                    </tr>
													@else
													 <td class="primary">{{$getMenusA->order}}- <b>{{ $getMenusA->ar_title}}</b></td>
                                                        <td>{{$getMenusA->title}}</td>
                                                        <td>{{$getMenusA->url}}</td>
														<td>{{$getMenusA->target}}</td>
                                                        <td><a href="/edit_menu/{{$getMenusA->id}}"><i class="bx bx-edit-alt"> </i></a> |
                                   <a onclick="return confirm('{{__('settings.SureDelete')}}');" href="{{URL::to('/admin/delete_menu/'.$getMenusA->id ?? null)}}"><i class="bx bx-trash"> </i></a></td>
                                                    </tr>
													@foreach($getMenusA->children->sortby('order') as $subMenuItem)
													<tr>
													<td class="warning">&nbsp;&nbsp;&nbsp;&nbsp;{{$subMenuItem->order}}- <b>{{$subMenuItem->ar_title}}</b></td>
                                                        <td>{{$subMenuItem->title}}</td>
                                                        <td>{{$subMenuItem->url}}</td>
														<td>{{$subMenuItem->target}}</td>
                                                        <td><a href="/edit_menu/{{$subMenuItem->id}}"><i class="bx bx-edit-alt"> </i></a> |
                                   <a onclick="return confirm('{{__('settings.SureDelete')}}');" href="{{URL::to('/admin/delete_menu/'.$subMenuItem->id ?? null)}}"><i class="bx bx-trash"> </i></a></td>
                                                    </tr>

													@endforeach
									@endif
	 							@endif
                                </tr>

                            	@endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


							 <div class="card">
                                <div class="card-header">
								<h4 class="text-bold-400">{{__('settings.FooterMenusItems')}}</h4>
                                </div>

                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                    <tr>
                                                        <th>{{__('settings.ARABICTITLE')}}</th>
                                                        <th>{{__('settings.ENGLISHTITLE')}}</th>
                                                        <th>{{__('settings.URLOF')}}</th>
														<th>Target</th>
                                                        <th>{{__('settings.EditDelete')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
												<tr><td colspan="5" class="text-bold-600">{{__('settings.WhatWeDoMenu')}}</td></tr>
                           		@foreach ($getMenus->where('menu_type','1')->sortby('order') as $getMenusA)
                                                    <tr>
                                                        <td class="primary">{{$getMenusA->order}}- <b>{{ $getMenusA->ar_title}}</b></td>
                                                        <td>{{$getMenusA->title}}</td>
                                                        <td>{{$getMenusA->url}}</td>
														<td>{{$getMenusA->target}}</td>
                                                        <td><a href="/admin/edit_menu/{{$getMenusA->id}}"><i class="bx
bx-edit-alt"> </i></a> |
                                   <a onclick="return confirm('{{__('settings.SureDelete')}}');" href="{{URL::to('/admin/delete_menu/'.$getMenusA->id ?? null)}}"><i class="bx bx-trash"> </i></a></td>
                                                    </tr>
                            	@endforeach
								<tr><td colspan="5" class="text-bold-600">{{__('settings.FooterLineMenu')}}</td></tr>
                           		@foreach ($getMenus->where('menu_type','2')->sortby('order') as $getMenusA)
                                                    <tr>
                                                        <td class="primary">{{$getMenusA->order}}- <b>{{ $getMenusA->ar_title}}</b></td>
                                                        <td>{{$getMenusA->title}}</td>
                                                        <td>{{$getMenusA->url}}</td>
														<td>{{$getMenusA->target}}</td>
                                                        <td><a href="edit_menu/{{$getMenusA->id}}"><i class="bx
bx-edit-alt"> </i></a> |
                                   <a onclick="return confirm('{{__('settings.SureDelete')}}');" href="{{URL::to('/admin/delete_menu/'.$getMenusA->id ?? null)}}"><i class="bx bx-trash"> </i></a></td>
                                                    </tr>
                            	@endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
@else
<h3>
{{__('settings.NoData')}}
 </h3>
@endif
                </section>

                <!--/ Zero configuration table -->
            </div>
        </div>
    </div>
    <!-- END: Content-->
@stop
