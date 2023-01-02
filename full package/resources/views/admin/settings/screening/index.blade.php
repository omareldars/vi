@extends('layouts.admin')
@section('style')
    <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.min.css">
@stop
@section('content')
@php $types = ['onetoall'=>'Assign One to all users','grouptoall'=>'Assign Group to all users','grouptogroup'=>'Assign Group to group of users'] @endphp
<!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('cycles.Screening')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
									<li class="breadcrumb-item active">{{__('cycles.Manage Screening')}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<div class="content-body">
    @if ($cstep)
    <section id="multiple-column-form">
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
                    <div class="row match-height">
                        <div class="col-xl-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header" style="padding-bottom: 15px;">
                                    <h4 class="card-title">{{__('cycles.Portal screening list')}}</h4>
                                </div>
                                <hr>
                                <div class="card-body">
                                    <span>{{__('cycles.Select step from list to manage')}}</span>
                                    <fieldset class="input-group">
                                            <select id="cstep" class="select form-control" onchange="window.open('/admin/'+this.options[this.selectedIndex].value+'/screening','_self');">
                                                @foreach($steps as $step)
                                                    <option value="{{$step->id}}" {{$step->id==$id?'selected':''}}>{{$step->title}} ({{__('cycles.Cycle')}} "{{$step->cycle->title}}" -
                                                        {{__('cycles.Start')}} {{$step->from->format('d-m')}})</option>
                                                @endforeach
                                            </select>
                                        <div class="input-group-append">
                                    <button class="btn btn-primary" onclick="DoChange(1)">
                                        <i class="bx bx-edit"></i> <span class="align-middle ml-25">{{__('cycles.Edit')}}</span>
                                    </button>
                                    <button class="btn btn-danger" onclick="DoChange(2)" >
                                        <i class="bx bx-trash"></i> <span class="align-middle ml-25">{{__('cycles.Delete')}}</span>
                                    </button>
                                            <button class="btn btn-secondary" onclick="window.location.href='/admin/screening/results/{{$id}}'">
                                                <i class="bx bxs-user"></i> <span class="align-middle ml-25">{{__('cycles.Results')}}</span>
                                            </button>
                                    <a class="btn btn-success" href="/admin/cycles/{{$cstep->cycle_id}}">
                                         <i class="bx bx-pencil"></i> <span class="align-middle ml-25">{{__('cycles.Cycle')}}</span>
                                    </a>
                                        </div>
                                    </fieldset>
                                    <br />
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
    <section class="row">
    <div class="col-xl-12 col-md-12 col-sm-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title success">{{$cstep->title}} <small class="text-muted"> {{__('cycles.from')}} {{$cstep->from->format('d-m')}} {{__('cycles.to')}} {{$cstep->to->format('d-m-Y')}}</small></h4>
            <p>{{$cstep->description}}</p>
        </div>
        <hr style="margin:-10px 0 5px 0;">
        <div class="card-body">
            <div class="card-text">
                <dl class="row">
                    <dt class="col-sm-3 text-right">{{__('cycles.Cycle')}}</dt>
                    <dd class="col-sm-9">{{$cstep->cycle->title}} {{__('cycles.from')}} {{$cstep->cycle->start->format('d-m')}} {{__('cycles.to')}} {{$cstep->cycle->end->format('d-m-Y')}}</dd>
                </dl>
                <dl class="row">
                    <dt class="col-sm-3 text-right">{{__('cycles.Form title')}}</dt>
                    <dd class="col-sm-9">{!!$form->title??'<span class="danger">'. __('cycles.NoForm').'</span>'!!}</dd>
                </dl>
                <dl class="row">
                    <dt class="col-sm-3 text-right">{{__('cycles.Screening type')}}</dt>
                    <dd class="col-sm-9">
                      {{ __('cycles.'.$types[$cstep->data])}}
                    </dd>
                </dl>
                <dl class="row">
                    <dt class="col-sm-3 text-right">{{__('cycles.Total registered')}}</dt>
                    <dd class="col-sm-9">{{\App\Company::whereIn('step',[$form->id??'',$cstep->id])->count()}}</dd>
                </dl>
                <dl class="row">
                    <dt class="col-sm-3 text-right">{{__('cycles.Registered Judges')}}</dt>
                    <dd class="col-sm-9">{{$judges->count()}}</dd>
                </dl>
            </div>
        </div>
    </div>
    </div>
    <div class="col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title primary">{{ __('cycles.'.$types[$cstep->data])}}</h4>
                    <p>{{__('cycles.Select judges from the menu')}}:</p>
                </div>
                <hr style="margin:-10px 0 25px 0;">
                <div class="card-body">
                    <div class="card-text">
                        <form action="/admin/screening/update" method="POST" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <input type="hidden" value="{{$cstep->id}}" name="step">
                            <input type="hidden" name="fid" value="{{$form->id??''}}">
                            <div class="form-group">
                               @if($cstep->data == 'grouptogroup')
                               @foreach(json_decode($cstep->list)??[] as $key=>$clist)
                                   <div class="form-row">
                                       <p style="margin:5px;">{{__('cycles.panel list')." ".$key }}</p>
                                       <div class="row col-md-12">
                                       <div class="col-md-11">
                                           <select name="judges[{{$key}}][]" class="select2 form-control panel{{$key}}" multiple="multiple">
                                               @foreach($judges as $judge)
                                                   <option value="{{$judge->id}}" {{in_array($judge->id,$clist??[])?'selected':''}}>{{$judge->{'first_name_'.$l} }}  {{$judge->{'last_name_'.$l} }} ({{$judge->email}})</option>
                                               @endforeach
                                           </select>
                                       </div>
                                       @php
                                       $panel=\App\Screening::where('step_id',$cstep->id)->where('panel',$key)->first();
                                       if ($panel && $panel->users) {$panel = json_encode($panel->users);
                                       }else {$panel='';}

                                       @endphp
                                       <input type="hidden" value="{{$panel}}" name="panel{{$key}}">
                                       <div class="col-md-1"><button type="button" class="btn btn-warning" onclick="openusers({{$key}})"><i class="bx bx-edit"></i></button></div>
                                       </div>
                                   </div>
                               @endforeach
                               @php($key = ($key??0)+1)
                                   <div class="form-row">
                                       <p style="margin: 5px">{{__('cycles.panel list')." ".$key }}</p>
                                       <div class="row col-md-12">
                                       <div class="col-md-11">
                                           <select name="judges[{{$key}}][]" class="select2 form-control panel{{$key}}" multiple="multiple" >
                                               @foreach($judges as $judge)
                                                   <option value="{{$judge->id}}"  >{{$judge->{'first_name_'.$l} }}  {{$judge->{'last_name_'.$l} }} ({{$judge->email}})</option>
                                               @endforeach
                                           </select>
                                       </div>

                                       <div class="col-md-1 float-right"><button class="btn btn-primary" type="submit"><i class="bx bx-plus"></i></button></div>
                                       </div>
                                   </div>
                               @else
                                   <h5>{{__('cycles.Judges list')}}</h5>
                                       <select name="judges[]" class="select2 form-control" {{$cstep->data=='onetoall'?'':'multiple="multiple"'}}  >
                                           {!!$cstep->data=='onetoall'?'<option selected disabled>'.__('cycles.Please select one name').'</option>':''!!}
                                           @foreach($judges as $judge)
                                               <option value="{{$judge->id}}" {{in_array($judge->id,json_decode($cstep->list)??[])?'selected':''}}>{{$judge->{'first_name_'.$l} }}  {{$judge->{'last_name_'.$l} }} ({{$judge->email}})</option>
                                           @endforeach
                                       </select>
                               @endif
                           </div>
                           <div class="custom-control custom-switch custom-control-inline mb-1">
                               <span>{{__('cycles.Notify them')}}</span>&nbsp;
                               <input name="notify" type="checkbox" class="custom-control-input" id="customSwitch1">
                               <label class="custom-control-label mr-1" for="customSwitch1">
                               </label>
                               <br><br>
                           </div>
                           <div class="row">
                               <div class="col-12 d-flex justify-content-end">
                                   <button type="submit"
                                           class="btn btn-primary mr-1 mb-1">{{__('admin.Update')}}</button>
                               </div>
                           </div>

                       </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @else
        <div class="card">
            <div class="card-header border-bottom">
                <h4 class="card-title">{{ __('cycles.Error') }}</h4>
            </div>
                <div class="card-body">
                    {{__('cycles.No records screening from')}} <a href="/admin/cycles">{{__('cycles.Cycles')}}</a>.
                </div>
        </div>
    @endif
            </div>
        </div>
    </div>
    <!-- END: Content-->
@if ($cstep)
<!--Screening form Modal -->
<div class="modal fade text-left" id="stepForm" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form class="form" action= "{{URL::to('admin/cycles/modify')}}" method="POST" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">{{__('cycles.Modify current screening')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="menu2">
                        <label>{{__('cycles.Choose screening type')}}: </label>
                        <div class="form-group mb-0">
                            <select class="select form-control" name="ScreeningSelect" required>
                                @foreach($types as $k=>$type)
                                <option value="{{$k}}" {{$cstep->data == $k ?'selected':''}}>{{ __('cycles.'.$type) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="sid" value="{{$cstep->id}}">
                    <input type="hidden" name="type" value="8">
                    <br>
                    <label>{{__('cycles.Title')}}: </label>
                    <div class="form-group">
                        <input value="{{$cstep->title}}" name='title' type="text" placeholder="{{__('cycles.Title')}}" class="form-control" required>
                    </div>
                    <label>{{__('cycles.Start From')}}: </label>
                    <div class="form-group">
                        <input value="{{$cstep->from->format('Y-m-d')}}" name='fromDate' type="text" class="form-control date" required>
                    </div>
                    <label>{{__('cycles.to')}}: </label>
                    <div class="form-group">
                        <input value="{{$cstep->to->format('Y-m-d')}}" name='toDate' type="text" class="form-control date" required>
                    </div>
                    <label>{{__('cycles.Description')}}: </label>
                    <div class="form-group mb-0">
                        <textarea  name='description' placeholder="{{__('cycles.Description')}}" class="form-control">{{$cstep->description}}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">{{__('cycles.Close')}}</span>
                    </button>
                    <button type="submit" value="submit" class="btn btn-primary ml-1" >
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">{{__('cycles.Submit')}}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@if($cstep->data == 'grouptogroup')
<!--Users form -->
<div class="modal fade text-left" id="usersForm" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form class="form" action= "{{URL::to('admin/screening/add')}}" method="POST" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">{{__('cycles.Assign companies to panel')}} <span id="cpanel">0</span> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="form-group mb-0">
                            <select class="select2 form-control" name="panelusers[]" id="panelusers" multiple>

                            </select>
                        </div>
                    <input type="hidden" name="sid" value="{{$cstep->id}}">
                    <input type="hidden" name="pid" value="0" id="pid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">{{__('cycles.Close')}}</span>
                    </button>
                    <button type="submit" value="submit" class="btn btn-primary ml-1" >
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">{{__('cycles.Save')}}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endif
@stop
@section('pagescripts')
    <script src="/js/jquery.datetimepicker.full.min.js"></script>
    <script>
        $('.date').datetimepicker({timepicker:false,format:'Y-m-d'});
        function DoChange(set) {
            switch (set) {
                case 1:
                    $('#stepForm').modal('show');
                    break;
                case 2:
                    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                    if (confirm('{{__('cycles.Are you sure, Delete current step and all its contents?')}}'))
                    {
                        $.ajax({
                            type: "POST", url: "/admin/cycles/modify",
                            data: {"stepid": {{$cstep->id??0}}, "type" : 6,},
                            success: function (response) {
                                console.log(response);
                                location.href = '/admin/screening';
                            },
                            error: function (error) {
                                console.log(error);
                                alert("Error Occurred, Try again!");
                            }
                        });
                    }
            }
        }
        function openusers(panel) {
            $('#pid').val(panel);
            $('#cpanel').text(panel);
            let theurl = "/admin/screening/get/{{$form->id??0}}/{{$cstep->id??0}}/"+panel;
            $.ajax({
                type: "GET", url:theurl ,
                success: function (response) {
                    console.log(response);
                    $('#panelusers').html(response);
                    $('#usersForm').modal('show');
                },
                error: function (error) {
                    console.log(error);
                    alert("Error Occurred, Try again!");
                }
            });
        }
    </script>
@stop