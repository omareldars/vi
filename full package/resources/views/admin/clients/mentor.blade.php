@extends('layouts.admin')
@section('style')
<link rel="stylesheet" type="text/css" href="/app-assets/css{{$l=='ar'?'-rtl':''}}/pages/widgets.css">
<link rel="stylesheet" type="text/css" href="/app-assets/css{{$l=='ar'?'-rtl':''}}/pages/dashboard-ecommerce.css">
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.min.css">
@stop
@section('title', __('admin.Dashboard') )
@section('subTitle', __('admin.My Dashboard'))
@section('content')

@if(!Auth::user()->bio)
{!!redirect('/admin/myProfile#bio')!!}
@endif
@php
    $s_latest = \App\Service::orderBy('created_at','DESC')->take(5)->get();
      $e_latest = \App\Calendar::where('start','>=',now()->format('Y-m-d'))->where(function ($q) {
          $q->orWhere('user_id',Auth::id())
          ->orWhereNull('isPrivate');
      })->orderBy('start')->take(5)->get();
      $s_count = \App\Service::count();
      $s_r_count = \App\ServicesRequests::where('user_id',Auth::id())->count();
      $nm_count = \App\Messenger::where('receiver',Auth::id())->whereNull('read')->count();
          $myid = Auth::id();
          $mysteps = App\Screening::where('user_id',Auth::id())->get();
          $today = date("Y-m-d");
          $csteps = App\Step::whereRaw( '"'.$today. '" BETWEEN `from` AND `to`')->whereIn('id',$mysteps->pluck('step_id'))->get();
          $fcompanies = App\Finalscreening::where('judges', 'like', "%\"{$myid}\"%")->get();
  $mysessions = \App\MentorshipRequest::where('mentor_id',Auth::id())->where('zoom_date','>=',date("Y-m-d 00:00:00"))->where('approved','Yes')->get();
  $mycycles = \App\CyclesMentors::where('user_id',$myid)->get();
@endphp
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        @include('admin.includes.heading')
        <div class="content-header row">
        </div>
        <div class="content-body">
            @if(session()->has('msg'))
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success  mb-2" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="d-flex align-items-center">
                                <i class="bx bx-like"></i>
                                <span>
                                    {{ __('admin.'.session()->get('msg')) }}
                                    {{ Session::forget('msg') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <section>
                <div class="row">
                    <div class="col-sm-3 col-12 dashboard-users-success">
                        <div class="card text-center">
                            <div class="card-content">
                                <a href="/admin/directory">
                                    <div class="card-body py-1">
                                        <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50">
                                            <i class="bx bx bx-briefcase-alt font-medium-5"></i>
                                        </div>
                                        <div class="text-muted line-ellipsis">{{__('dashboard.Services')}}</div>
                                        <h3 class="mb-0">{{$s_count}}</h3>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-12 dashboard-users-danger">
                        <div class="card text-center">
                            <div class="card-content">
                                <a href="/admin/inbox">
                                    <div class="card-body py-1">
                                        <div class="badge-circle badge-circle-lg badge-circle-light-primary mx-auto mb-50">
                                            <i class="bx bxs-message font-medium-5"></i>
                                        </div>
                                        <div class="text-muted line-ellipsis">{{__('dashboard.newmessages')}}</div>
                                        <h3 class="mb-0">{{$nm_count}}</h3>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-12 dashboard-users-success">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body py-1">
                                    <div class="badge-circle badge-circle-lg badge-circle-light-secondary mx-auto mb-50">
                                        <i class="bx bx-chalkboard font-medium-5"></i>
                                    </div>
                                    <div class="text-muted line-ellipsis">{{__('dashboard.Coming sessions')}}</div>
                                    <h3 class="mb-0">{{ count($mysessions) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-12">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body py-1">
                                    <div class="badge-circle badge-circle-lg badge-circle-light-warning mx-auto mb-50">
                                        <i class="bx bx-calendar-alt font-medium-5"></i>
                                    </div>
                                    <div class="text-muted line-ellipsis">{{__('dashboard.Cycles')}}</div>
                                    <h3 class="mb-0">{{count($mycycles)}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              <div class="row">
                    <div class="col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title"><i class="bx bx-help-circle mr-1"></i>{{__('dashboard.Latest services')}}</h4>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li>
                                            <a data-action="close">
                                                <i class="bx bx-x"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                @if (count($s_latest)>0)
                                    @foreach($s_latest as $serv)
                                        <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-75">
                                            <div class="widget-todo-title-area d-flex align-items-center">
                                                <a href="/admin/directory?find={{$serv->{'name_'.$l} }}">
                                            <span class="widget-todo-title ml-50 text-secondary">

                <i class="bx bx-link text-primary"></i>
                                                {{$serv->{'name_'.$l} }}</span></a>
                                            </div>
                                            <div class="widget-todo-item-action d-flex align-items-center">
                                                <div class="badge badge-pill badge-light-primary mr-1">
                                                    <a href="/admin/directory?type={{$serv->serviceCategory->id}}">
                                                        {{$serv->serviceCategory->{'name_'.$l} }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-75">
                                        <div class="widget-todo-title-area d-flex align-items-center">
                                            <span class="widget-todo-title ml-50">
                                     <i class="bx bxs-bell-ring text-danger"></i>
                                                {{__('dashboard.No services added')}}.</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title"><i class="bx bx-calendar mr-1"></i>{{__('dashboard.Latest Events')}}</h4>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li>
                                            <a data-action="close">
                                                <i class="bx bx-x"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                @if (count($e_latest)>0)
                                    @foreach($e_latest as $event)
                                        <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-75">
                                            <div class="widget-todo-title-area d-flex align-items-center">
                                                <a href="/admin/calendar">
                                            <span class="widget-todo-title ml-50 text-secondary">
                <i class="bx bx-calendar-event text-primary"></i>
                                                {{$event->title}}</span></a>
                                            </div>
                                            <div class="widget-todo-item-action d-flex align-items-center">
                                                <div class="badge badge-pill badge-light-success mr-1">
                                                    {{date('d-m-Y', strtotime($event->start))}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-75">
                                        <div class="widget-todo-title-area d-flex align-items-center">
                                            <span class="widget-todo-title ml-50">
                                     <i class="bx bxs-bell-ring text-danger"></i>
                                                {{__('dashboard.No Events added')}} '<a href="/admin/calendar">{{__('dashboard.Add yours now')}}</a>'.</span>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </section>

                <section>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title align-items-center">
                                    <i class='bx bx-card font-medium-4 mr-1'></i>{{__('dashboard.My current schedule')}}:
                                    <button onclick="modify(0,0,0)" type="button" class="btn btn-icon rounded-circle btn-light-info float-right" >
                                        <i class="bx bx-plus"></i></button></h4>
                            </div>
                            <div class="card-body">
                                @php ($myschedules = \App\Schedule::where('user_id',Auth::id())->get())
                                @if(count($myschedules))
                                <div class="card border-light">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>{{__('dashboard.Days')}}</th>
                                                <th>{{__('dashboard.Time')}}</th>
                                                <th>{{__('dashboard.Notes')}}</th>
                                                <th>{{__('dashboard.Actions')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                    @foreach($myschedules as $key=>$schedule)
                                            <tr class="text-{{$schedule->active?'primary':'danger'}}">
                                                <td>{{$key+1}}</td>
                                                <td>
                                                    @switch($schedule->type)
                                                        @case("Weekly")
                                                        Weekly({{str_replace(['[',']','"'],' ',json_encode($schedule->days))}})
                                                        @break
                                                        @case("WorkingDays")
                                                        {{__('dashboard.All working days')}}
                                                        @break
                                                        @case("Period")
                                                        {{ __('dashboard.from').$schedule->dfrom->format('d-m-Y'). __('dashboard.to') .$schedule->dto->format('d-m-Y')}}
                                                        @break
                                                        @default
                                                        {{$schedule->dfrom->format('d-m-Y')}}
                                                    @endswitch
                                                </td>
                                                <td>{{ __('dashboard.from')}} {{ substr($schedule->tfrom,0,5)}} {{ __('dashboard.to')}} {{substr($schedule->tto,0,5)}}</td>
                                                <td>{{$schedule->notes}}</td>
                                                <td>
                                                    <button onclick="modify(1,{{$schedule->id}},0)" type="button" class="btn btn-icon rounded-circle btn-light-success" >
                                                        <i class="bx bx-edit-alt"></i></button>
                                                    <button onclick="modify(2,{{$schedule->id}},{{$schedule->active}})" type="button" class="btn btn-icon rounded-circle btn-light{{$schedule->active?'-primary':''}}" >
                                                        <i class="bx bx-{{$schedule->active?'show-alt':'hide'}}"></i></button>
                                                    <button onclick="modify(3,{{$schedule->id}},0)" type="button" class="btn btn-icon rounded-circle btn-light-danger" >
                                                        <i class="bx bx-trash"></i></button>
                                                </td>
                                            </tr>
@endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                                @else
                                {{ __('dashboard.kindly add your schedule')}}  <a href="#" onclick="modify(0,0,0)">"{{ __('dashboard.here')}}"</a>.
@endif
                        </div>
                    </div>
                </div>
            </section>
          @if(count($mysessions))
          <section>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title align-items-center">
                                    <i class='bx bx-card font-medium-4 mr-1'></i>{{__('dashboard.My next mentorship sessions')}}:</h4>
                            </div>
                            <div class="card-body">
                                
                                <div class="card border-light">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead>
                                            <tr class="table-secondary">
                                                <th>#</th>
                                                <th>{{__('dashboard.Company')}}</th>
                                                <th>{{__('dashboard.User')}}</th>
                                              	<th>{{__('dashboard.Date')}}</th>
                                                <th>{{__('dashboard.Admin Notes')}}</th>
                                                <th>{{__('dashboard.Meeting Link')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                    @foreach($mysessions as $key=>$session)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>
                                                    <a class="media-left mr-50" href="/admin/companyProfile/{{$session->user->company->id}}">
                                                        <img src="/191014/{{$session->user->company->logo??'../app-assets/images/logo_placeholder.png'}}" alt="avatar" class="rounded-circle" height="40" width="40">
                                                    </a>
                                                    <a href="/admin/companyProfile/{{$session->user->company->id}}">
                                                        <div class="media align-items-center">
                                                            {{$session->user->company->{'name_'.$l} }}
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="media align-items-center">
                                                        <a class="media-left mr-50">
                                                            <img src="/191014/{{$session->user->img_url??'../images/placeholder.jpg'}}" alt="avatar" class="rounded-circle" height="40" width="40">
                                                        </a>
                                                            <div class="media-body">
                                                                <h6 class="media-heading mb-0">{{$session->user->{'first_name_'.$l} }} {{$session->user->{'last_name_'.$l} }}</h6>
                                                                <span class="font-small-2">{{$session->user->{'title_'.$l} }}</span>
                                                            </div>
                                                    </div>
                                                </td>
                                              <td>
                                              {{$session->zoom_date}} ({{$session->period}}M)
                                              </td>
                                                <td>
                                                   {{$session->admin_comment??'-'}}
                                                </td>
                                              <td>
                                                 <a href="{{$session->join_url}}" target="_blank">
                                  	<button title="Start Meeting" type="button" class="btn btn-icon rounded-circle btn-light-success">
                                        <i class="bx bx-user"></i></button></a>
                                                </td>
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
            </section>
          @endif
        </div>
    </div>
</div>
<!-- END: Content-->
<!-- Send response -->
<div class="modal fade text-left" id="SendRequest" tabindex="-1" role="dialog" aria-labelledby="sendrequest" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" action="/admin/mentors/modify" enctype="multipart/form-data" autocomplete="off">
            <div class="modal-header">
                <h4 class="modal-title">{{__('dashboard.Add new')}} <span id="rname"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                @csrf
                <label>{{__('dashboard.Choose type')}}:</label>
                <div class="form-group">
                    <select name="type" class="select form-control" id="type" onchange="SelectType(this.options[this.selectedIndex].value)" required>
                        <option value="OneDay">{{__('dashboard.Add one day')}}</option>
                        <option value="Weekly">{{__('dashboard.Select weekly days and times')}}</option>
                        <option value="WorkingDays">{{__('dashboard.Add working days times')}}</option>
                        <option value="Period">{{__('dashboard.Add period')}}</option>
                    </select>
                </div>
                <input type="hidden" name="rtype" value="0" id="rtype">
                <input type="hidden" name="id" value="0" id="sid">
                <div id="showdays" class="form-group" style="display: none">
                    <select name="days[]" class="select2 form-control" multiple id="days">
                        <option value="Sat">{{__('dashboard.Saturday')}}</option>
                        <option value="Sun">{{__('dashboard.Sunday')}}</option>
                        <option value="Mon">{{__('dashboard.Monday')}}</option>
                        <option value="Tue">{{__('dashboard.Tuesday')}}</option>
                        <option value="Wed">{{__('dashboard.Wednesday')}}</option>
                        <option value="Thu">{{__('dashboard.Thursday')}}</option>
                        <option value="Fri">{{__('dashboard.Friday')}}</option>
                    </select>
                </div>

                <div class="form-group" id="showdates">
                    <label>{{__('dashboard.Date')}}:</label>
                    <input class='date width-100' type="text" id="dfrom" name="dfrom" value="" required>
                    <span id="showtto" style="display: none">
                    <label>{{__('dashboard.to')}}:</label>
                    <input class='date width-100' type="text" id="dto" name="dto" value="">
                    </span>
                </div>
                <div class="form-group">
                <label>{{__('dashboard.Time from')}}:</label>
                    <input class="time width-100" type="text" id="tfrom" name="tfrom" value="" required> <label>{{__('dashboard.to')}}:</label>
                    <input class="time width-100" type="text" id="tto" name="tto" value="" required>
                </div>

                <label>{{__('dashboard.Add a Note')}}:</label>
                <div class="form-group">
                            <textarea class="form-control" id="notes" name='notes' rows="4"
                                      placeholder="{{__('dashboard.Write your note here')}}." ></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary ml-1" >
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">{{__('dashboard.Submit')}}</span>
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
@stop
@section('pagescripts')
<script src="/js/jquery.datetimepicker.full.min.js"></script>
<script>
    $('.date').datetimepicker({timepicker:false,format:'Y-m-d'});
    $('.time').datetimepicker({datepicker:false,format:'H:i'});
    function modify(type,id,stat){
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        if (type===3) {
            //delete
            if (confirm("{{__('dashboard.sure del schedule')}}")) {
                $.ajax({
                    type: "POST", url: "/admin/mentors/modify",
                    data: {"id": id, "rtype": type,},
                    success: function (response) {
                        location.reload();
                    },
                    error: function (error) {
                        console.log(error);
                        alert("Error Occurred, Try again!");
                    }
                });
            }} else if (type===2) {
            //Enable-disable
            $.ajax({
                type: "POST", url: "/admin/mentors/modify",
                data: {"id": id, "rtype": type,"stat":stat},
                success: function (response) {
                    location.reload();},
                error: function (error) {
                    console.log(error);
                    alert("Error Occurred, Try again!");
                }});
        } else if (type===1) {
            // Edit current
            $.ajax({
                type: "POST", url: "/admin/mentors/modify",
                data: {"id": id, "rtype": type,},
                success: function (response) {
                    switchtypes(response.type);
                    $('#sid').val(response.id);
                    $('#rtype').val(4);
                    $('#type').val(response.type);
                    $('#days').val(response.days);
                    $('#dfrom').val(response.dfrom);
                    $('#dto').val(response.dto);
                    $('#tfrom').val(response.tfrom);
                    $('#tto').val(response.tto);
                    $('#notes').val(response.notes);
                    $('#SendRequest').modal('show');
                    },
                error: function (error) {
                    console.log(error);
                    alert("Error Occurred, Try again!");
                }});
        } else {
            //show from as new
            $('#sid, #type, #days, #dfrom, #dto, #tfrom, #tto, #notes').val();
            $('#rtype').val('0');
            switchtypes(type);
            $('#SendRequest').modal('show');
        }
    }
    function SelectType(type){
        switchtypes(type);
    }
    function switchtypes(type) {
        switch (type) {
            case 'OneDay':
                $('#showdates').show();
                $('#showtto, #showdays').hide();
                $("#dfrom").prop('required',true);
                $("#days, #dto").prop('required',false);
                break;
            case 'Weekly':
                $('#showdates').hide();
                $('#showdays').show();
                $("#days").prop('required',true);
                $("#dfrom, #dto").prop('required',false);
                break;
            case 'WorkingDays':
                $('#showdates, #showdays').hide();
                $("#dfrom, #dto, #days").prop('required',false);
                break;
            case 'Period':
                $('#showtto,#showdates').show();
                $('#showdays').hide();
                $("#dfrom, #dto").prop('required',true);
                $("#days").prop('required',false);
                break;
        }
    }
</script>
@stop