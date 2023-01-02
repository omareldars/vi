@extends('layouts.admin')
@section('vendorstyle')
@stop
@section('style')
<link rel="stylesheet" type="text/css" href="/app-assets/css{{$l=='ar'?'-rtl':''}}/pages/widgets.css">
<link rel="stylesheet" type="text/css" href="/app-assets/css{{$l=='ar'?'-rtl':''}}/pages/dashboard-ecommerce.css">
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.min.css">
<link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/tables/datatable/datatables.min.css">
<link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/extensions/jquery.rateyo.min.css">
@stop
@section('title', __('admin.Dashboard') )
@section('subTitle', __('admin.My Dashboard'))
@section('content')

@if(!Auth::user()->first_name_ar)
{!!redirect()->route('my_profile')->with( ['msg' => 'FailedStore', 'class' => 'danger'] )!!}
@endif

@php
$s_latest = \App\Service::orderBy('created_at','DESC')->take(5)->get();
$e_latest = \App\Calendar::where('start','>=',now()->format('Y-m-d'))->where(function ($q) {
    $q->orWhere('user_id',Auth::id())
    ->orWhereNull('isPrivate');
})->orderBy('start')->take(5)->get();
$events = \App\Event::where('timerdate','>=',now()->format('Y-m-d'))->where('published','1')->orderBy('timerdate')->take(5)->get();
$s_count = \App\Service::count();
$s_r_count = \App\ServicesRequests::where('user_id',Auth::id())->count();
$nm_count = \App\Messenger::where('receiver',Auth::id())->whereNull('read')->count();
$mentors = \App\CyclesMentors::where('cycle_id',Auth::user()->company->cycle??0)->get();
$m_count = count($mentors);
/// Next session
$nextsession = \App\MentorshipRequest::where('user_id',Auth::id())->where('approved','Yes')->where('zoom_date','>=',date("Y-m-d 00:00:00"))->orderBy('zoom_date','ASC')->first();
/// Rating
$notrated_ser = \App\ServicesRequests::where('user_id',Auth::id())->where('approved','Yes')->where('date_time','<',date("Y-m-d 17:00:00"))->whereNull('rate')->first();
$notrated_men = \App\MentorshipRequest::where('user_id',Auth::id())->where('zoom_date','<',date("Y-m-d 17:00:00"))->where('approved','Yes')->whereNull('rating')->first();
/// My sessions
$sessions = \App\TrainingSession::where('step_id',Auth::user()->company->step ??'')->orderBy('datetime','ASC')->take(3)->get();
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
                        <div class="alert alert-{{session()->get('class')}} mb-2" role="alert">
                            <button type="button" class="close" data-dismiss="alert"
                                    aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="d-flex align-items-center">
                                <i class="bx bx-error"></i>
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
                    <div class="col-sm-3 col-12 dashboard-users-danger">
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
                                <a href="/admin/requests/mine">
                                <div class="card-body py-1">
                                    <div class="badge-circle badge-circle-lg badge-circle-light-secondary mx-auto mb-50">
                                        <i class="bx bxs-megaphone font-medium-5"></i>
                                    </div>
                                    <div class="text-muted line-ellipsis">{{__('dashboard.My Requests')}}</div>
                                    <h3 class="mb-0">{{$s_r_count}}</h3>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-12 dashboard-users-danger">
                        <div class="card text-center">
                            <div class="card-content">
                                <a href="/admin/mentorship/mine">
                                <div class="card-body py-1">
                                    <div class="badge-circle badge-circle-lg badge-circle-light-info mx-auto mb-50">
                                        <i class="bx bxs-graduation font-medium-5"></i>
                                    </div>
                                    <div class="text-muted line-ellipsis">{{__('dashboard.Mentors')}}</div>
                                    <h3 class="mb-0">{{$m_count}}</h3>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-12 dashboard-users-success">
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
                                @if (count($e_latest)+count($events)>0)
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
                              		@foreach($events as $event)
                                            <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-75">
                                                <div class="widget-todo-title-area d-flex align-items-center">
                                                    <a href="/event/{{$event->id}}">
                                            <span class="widget-todo-title ml-50 text-secondary">
                <i class="bx bx-calendar-event text-danger"></i>
                                                {{$event->{'title_'.$l} }}</span></a>
                                                </div>
                                                <div class="widget-todo-item-action d-flex align-items-center">
                                                    <div class="badge badge-pill badge-light-warning mr-1">
                                                        {{date('d-m-Y', strtotime($event->timerdate))}}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                @else
                                    <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-75">
                                        <div class="widget-todo-title-area d-flex align-items-center">
                                            <span class="widget-todo-title ml-50">
                                     <i class="bx bxs-bell-ring text-danger"></i>
                                                {{__('dashboard.No Events added')}}, '<a href="/admin/calendar">{{__('dashboard.Add yours now')}}</a>'.</span>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </section>
                @if (Auth::user()->company && Auth::user()->company->cycle)
                <section>
                <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title d-flex align-items-center">
                                            <i class='bx bx-briefcase font-medium-4 mr-1'></i>{{__('dashboard.My progress')}}</h4>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li>
                                                <a data-action="close">
                                                    <i class="bx bx-x"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
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
                                        <div class="row">
                                            @php
                                                $svgs = ['notebook','search','idea','comments','trophy'];
                                                $colors = ['#39da8a','#99a2ac'];
                                                $cs = Auth::user()->company->step;
                                                $s = 1;
                                                $stat="Completed";
                                                $ctype=0

                                            @endphp
                                            @foreach (\App\Step::where('cycle_id',Auth::user()->company->cycle)->orderBy('arr')->get() as $step)
                                            @php
                                                if($cs==$step->id){$stat="Started";$ctype=$step->stype;}
                                                $trtype=$flink=null;
                                                if (Auth::user()->company->approved){$flink='my/'.Auth::user()->company->step;} else {$flink='view/'.Auth::user()->company->cycle;}
                                                $links = ['','<a href="/admin/cycles/'.$flink.'">',
                                                '','','<a href="/admin/training/my">',''];
                                            @endphp
                                        <div class="col text-center" style="opacity:{{$s==0?"0.4":"1"}};">
                                            {!! $links[$step->stype]&&$stat=='Started' ? $links[$step->stype] : '' !!}
                                            <i class="livicon-evo" data-options="name: {{$svgs[$step->stype-1]}}.svg; size: 60px; style: {{$s==0?'solid;animated: false':'original'}};"></i>
                                                        <hr style="color: {{$s?'#99a2ac':'#39da8a'}}">
                                                        <div class="text-{{$s==0?'muted':'primary'}} line-ellipsis">
                                                            <span class="badge badge-{{$s==0?'secondary':'success'}} badge-pill">{{__('dashboard.STEP ready')}} {{$step->arr}}</span>
                                                            <br> {{__('dashboard.start from')}} {{ Carbon\Carbon::parse($step->from)->format('d-m') }} {{__('dashboard.to')}} {{Carbon\Carbon::parse($step->to)->format('d-m')}}
                                                            <br>{{$step->title}}</div>
                                                            <div class="text-{{$s==0?'muted':'success'}} line-ellipsis">
                                                                {{ __('dashboard.'.$stat) }}
                                                            </div>
                                            {!! $links[$step->stype]&&$stat=='Started' ? '</a>' : '' !!}
                                        </div>
                                            @if(!$loop->last)
                                        <i class="step-icon bx @if($stat=="Completed") bx-check-circle @elseif($stat=="Started") bx-loader-circle @else bx-circle @endif" style="padding: 62px 0;font-size: 30px;color:{{$s==0?'#99a2ac':'#39da8a'}};"></i>
                                             @endif
                                                @php if($cs==$step->id){$s=0;$stat="Not started";} @endphp
                                                @if($stat=="Refused")
                                                    <div class="col text-center" >
                                                        <a>
                                                            <i class="livicon-evo" data-options="name: minus-alt.svg; size: 60px; style: 'original'}};"></i>
                                                        </a>
                                                        <hr style="color: {{$s?'#99a2ac':'#39da8a'}}">
                                                        <div class="text-primary line-ellipsis">
                                                            <span class="badge badge-success badge-pill">{{__('dashboard.Stopped')}}</span>
                                                            <br>{{__('dashboard.Your form not applicable')}}
                                                            <br>{{__('dashboard.Good Luck')}}</div>
                                                        <div class="text-success" line-ellipsis">
                                                        {{__('dashboard.Refused')}}
                                                    </div>
                                        </div>
                                        @break
                                        @endif
                                                @php if($cs==0){$stat="Refused";} @endphp
                                            @endforeach
                                    </div>
                                @if ($ctype==0)
                                    <hr><h6>{{__('dashboard.Sorry your submitted data doesn\'t meet the Cycle requirements')}}.</h6>
                                @elseif ($ctype==1)
                                    <hr><h6><a href="/admin/cycles/{{$flink}}">{{__('dashboard.Click here')}}</a> {{__('dashboard.to fill your data')}}.</h6>
                                @elseif ($ctype==2)
                                 <hr><h6>{{__('dashboard.Please wait till Incubator team review your data to start the next Cycle step')}}.</h6>
                                @elseif ($ctype==3)
                                    <hr><h6>{{__('dashboard.Below Mentors list to get any support, click request icon to check Mentor Schedule & request a meeting')}}.</h6>
                                @elseif ($ctype==4)
                                    @php($mytraining = \App\Step::findOrFail(Auth::user()->company->step))
                                    <hr><h6>{{__('dashboard.Your training step started')}}, <a href="/admin/training/my">{{__('dashboard.Click here')}}</a> {{__('dashboard.to view your training list')}}.</h6>
                                         <p>{{$mytraining->description}}</p>

                                @elseif ($ctype==5)
                                    @php($myfinal = \App\Finalscreening::where('company_id',Auth::user()->company->id)->where('step_id',Auth::user()->company->step)->first())
                                    @if ($myfinal->join_url)
                                        <hr><h6>{{__('dashboard.Your final session will start')}}: ({{$myfinal->datetime}}) <a href="{{$myfinal->join_url}}">{{__('dashboard.Join here')}}</a>.</h6>
                                    @else
                                        <hr><h6>{{__('dashboard.Your final session will start soon')}}.</h6>
                                    @endif
                                @endif
                            </div>
                        </div>
                        </div>
            </section>
                @else
                <section>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center">
                                    <i class='bx bx-card font-medium-4 mr-1'></i>{{__('dashboard.IncubationList')}}</h4>
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
@php($workingcycles = App\Cycle::whereNull('private')->whereRaw('? between start and end', [now()->format('Y-m-d')])->get())
                                @if (count($workingcycles)>0)
@foreach($workingcycles as $cycle)
                                <div class="card border-light">
                                    <div class="card-header">
                                        <h4 class="primary"><i class="bx bxs-bell"></i>  {{$cycle->title}}</h4>
                                    </div>
                                    <div class="card-body bg-rgba-light">
                                        <p class="card-text">
                                            {{$cycle->description}}
                                        </p>
                                        <small class="text-muted">{{__('dashboard.start from')}} {{$cycle->start->format('d-m-Y')}}</small>
                                        <a href="/admin/cycles/view/{{$cycle->id}}" class="btn btn-primary float-right">{{__('dashboard.Join')}}</a>
                                    </div>
                                </div>
@endforeach
                                @else
                                    <div class="card border-light">
                                    <h5 class="m-75 p-75">
                                        <div class="avatar bg-rgba-warning m-0 mr-75">
                                            <div class="avatar-content">
                                                <i class="bx bx-stats text-warning"></i>
                                            </div>
                                        </div>  {{__('dashboard.No Cycles started yet')}}...
                                    </h5>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            @endif
                @if (count($sessions)>0)
                    <section class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title d-flex align-items-center">
                                        <i class='bx bxs-megaphone font-medium-4 mr-1'></i>{{__('dashboard.My Latest training')}} :: <a href="/admin/training/my">{{__('dashboard.Show all')}}</a></h4>
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
                                    <div class="card-text">
                                        <div class="table-responsive">
                                            <table class="table mb-0" id="trainingtable">
                                                <thead class="thead-dark">
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{__('cycles.Type')}}</th>
                                                    <th>{{__('cycles.Title')}}</th>
                                                    <th>{{__('cycles.Start')}}</th>
                                                    <th>{{__('cycles.End')}}</th>
                                                    <th>{{__('cycles.details')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($sessions as $key=>$session)
                                                    <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{__('cycles.'.$session->type)}}</td>
                                                        <td>{{$session->title}}</td>
                                                        <td>{{$session->datetime}}</td>
                                                        <td>{{$session->enddatetime??'-'}}</td>
                                                        <td>
                                                            @if ($session->type=='sessions')
                                                                {{__('cycles.Duration')}}:  {{$session->duration}} {{__('cycles.Minutes')}} :
                                                                <a href="{{$session->join_url}}" target="_blank">
                                                                    <button title="Join only" type="button" class="btn btn-icon rounded-circle btn-light-primary">
                                                                        <i class="bx bx-user"></i></button></a>
                                                            @elseif ($session->type=='offline')
                                                                <b>{{__('cycles.trainer name')}}:</b> {{$session->trainer_name}}<br><b>{{__('cycles.training location')}}:</b> {{$session->location}} <br>
                                                            @else
                                                                <a href="/admin/training/my/{{$session->location}}">{{__('cycles.Display course contents')}} </a>
                                                            @endif
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
                    </section>
                @endif


            @if(Auth::user()->company->approved ?? null && count($mentors))
                    <section>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header border-bottom">
                                        <h4 class="card-title align-items-center">
                                            <i class='bx bx-card font-medium-4 mr-1'></i>{{__('dashboard.Mentors')}}:
                                        @if ($nextsession)
                                                <small class="text-danger">{{__('dashboard.Your next mentorship session with')}} <a href="{{$nextsession->join_url}}" target="_blank">{{$nextsession->mentor->{'first_name_'.$l} }} {{$nextsession->mentor->{'last_name_'.$l} }}</a> {{__('dashboard.will start')}} {{$nextsession->zoom_date}} <a href="{{$nextsession->join_url}}" target="_blank">({{__('dashboard.Join now')}})</a>.</small>
                                        @endif
                                        </h4>
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
                                        <div class="card ">
                                            <div class="table-responsive">
                                                <table class="table" id="mentorstable">
                                                    <thead class="thead-dark">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>{{__('dashboard.Name/Title')}}</th>
                                                        <th>{{__('dashboard.Bio')}}</th>
                                                        <th>{{__('dashboard.Specialization')}}</th>
                                                        <th>{{__('dashboard.Linkedin')}}</th>
                                                        <th>{{__('dashboard.Request')}}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($mentors as $key=>$mentor)
                                                        <tr>
                                                            <td>{{$key+1}}</td>
                                                            <td>
                                                                <div class="media align-items-center">
                                                                    <a class="media-left mr-50">
                                                                        <img src="/191014/{{$mentor->user->img_url??'../images/placeholder.jpg'}}" alt="avatar" class="rounded-circle" height="40" width="40">
                                                                    </a>
                                                                    <div class="media-body">
                                                                        <h6 class="media-heading mb-0">{{$mentor->user->{'first_name_'.$l} }} {{$mentor->user->{'last_name_'.$l} }}</h6>
                                                                        <span class="font-small-2">{{$mentor->user->{'title_'.$l} }}</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                {{$mentor->user->bio->{'bio_'.$l} ?? '-' }}
                                                            </td>
                                                            <td>
                                                                 {{$mentor->user->bio->{'specialization_'.$l} ?? '-' }}
                                                            </td>
                                                            <td>
                                                                @if ($mentor->user->bio->linkedin ??0)
                                                                <a title="Linkedin URL" target="_blank" href="{{$mentor->user->bio->linkedin}}" class="btn btn-icon rounded-circle btn-light-primary">
                                                                    <i class="bx  bxl-linkedin"></i></a>
                                                                    @endif
                                                            </td>
                                                            <td>
                                                                    <button onclick="request({{$mentor->user_id}},'{{$mentor->user->{'first_name_'.$l} }} {{$mentor->user->{'last_name_'.$l} }}')" title="Add new request" type="button" class="btn btn-icon rounded-circle btn-light-primary">
                                                                        <i class="bx bxs-conversation"></i></button>
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
<div class="modal fade text-left" id="SendRequest" tabindex="-1" role="dialog" aria-labelledby="sendrequest" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" action="/admin/mentorship/addwait" enctype="multipart/form-data" autocomplete="off">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('dashboard.Add mentorship session with')}} <span class="primary" id="rname"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="mentorid" value="0" id="mentorid">
                    <div>
                        <h5 class="text-primary"><i class="bx bx-time text-secondary"></i>
                            {{__('dashboard.Mentor schedule')}}</h5>
                        <span class="d-block bg-info p-1 white">
                            <ul class="mb-0" id="schedule"></ul>
                        </span>
                    </div>
                    <hr>
                    <div class="form-group" id="showdates">
                        <label>{{__('dashboard.Start meeting Date/ Time')}}:</label>
                        <input class="date width-250 form-control" type="text" id="date" name="date" value="" required onkeydown="return false">
                    </div>
                    <div class="form-group">
                        <label>{{__('dashboard.Meeting duration')}}:</label>
                        <select name="period" class="select form-control width-150">
                            <option value="30">30 {{__('dashboard.Minutes')}}</option>
                            <option value="60" selected>1 {{__('dashboard.Hour')}}</option>
                            <option value="120">2 {{__('dashboard.Hours')}}</option>
                            <option value="180">3 {{__('dashboard.Hours')}}</option>
                            <option value="240">4 {{__('dashboard.Hours')}}</option>
                            <option value="300">5 {{__('dashboard.Hours')}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="basicInputFile">{{__('dashboard.Send file with your request')}}</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile01" name="file_url" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,
text/plain, application/pdf, image/*">
                            <label class="custom-file-label" for="inputGroupFile01">{{__('dashboard.Choose file')}}</label>
                        </div>
                    </div>
                    <label>{{__('dashboard.Add note')}}:</label>
                    <div class="form-group">
                            <textarea class="form-control" id="notes" name='notes' rows="4"
                                      placeholder="{{__('dashboard.Write your note here')}}" ></textarea>
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
@if ($notrated_men or $notrated_ser)
<div class="modal fade text-left" id="RequestRate" tabindex="-1" role="dialog" aria-labelledby="RequestRate" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            @if ($notrated_ser)
                <div class="modal-header">
                    <h4 class="modal-title primary">{{__('dashboard.Rate')}} {{__('dashboard.service')}}: "{{$notrated_ser->service->{'name_'.$l} }}" <span class="primary" id="rname"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
            <form method="post" action="/admin/directory/{{$notrated_ser->id}}/rate" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="rate" value="0" id="rate">
                    <p class="text-secondary">{{__('dashboard.Your request was in')}} : {{$notrated_ser->date_time}}</p>
                    <hr>
                    <fieldset>
                            <span>{{__('dashboard.Did you get this service?')}}</span>
                          <ul class="list-unstyled mb-0">
            <li class="d-inline-block mr-2 mb-1">
              <fieldset>
                <div>
                  <input type="radio" name="done" id="doneyes" checked="">
                  <label for="doneyes">{{__('Yes')}}</label>
                </div>
              </fieldset>
            </li>
            <li class="d-inline-block mr-2 mb-1">
              <fieldset>
                <div>
                  <input type="radio" name="done" id="doneno">
                  <label for="doneno">{{__('No')}}</label>
                </div>
              </fieldset>
            </li>
          </ul>
                    </fieldset>
                     
                    <h6>{{__('dashboard.Rate from 1 star "bad" to 5 stars "best"')}}:</h6>
                    <div class="full-star-ratings" data-rateyo-full-star="true"></div>
                    <br>
                    <label>{{__('dashboard.Your opinion important kindly write any notes about this service')}}':</label>
                    <div class="form-group">
                            <textarea class="form-control" id="comment" name='comment' rows="4" required
                                      placeholder="{{__('dashboard.Write your notes here')}}" ></textarea>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary ml-1" >
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">{{__('dashboard.Submit')}}</span>
                </button>
            </div>
            </form>
            @else
                <div class="modal-header">
                    <h4 class="modal-title primary">{{__('dashboard.Rate mentorship session with')}} : {{$notrated_men->mentor->{'first_name_'.$l} }} {{$notrated_men->mentor->{'last_name_'.$l} }}<span class="primary" id="rname"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <form method="post" action="/admin/mentorship/rate" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" value="{{$notrated_men->id}}">
                        <input type="hidden" name="rate" value="0" id="rate">
                        <p class="text-secondary">{{__('dashboard.Your session was in')}} : {{$notrated_men->zoom_date}}</p>
                        <hr>
                        <fieldset>
                                <span>{{__('dashboard.Did you attend this session?')}}</span>
                               <ul class="list-unstyled">
            <li class="d-inline-block ">
              <fieldset>
                <div class="radio">
                  <input type="radio" name="done" id="doneyes2" checked="">
                  <label for="doneyes2">{{__('Yes')}}</label>
                </div>
              </fieldset>
            </li>
            <li class="d-inline-block">
              <fieldset>
                <div class="radio">
                  <input type="radio" name="done" id="doneno2">
                  <label for="doneno2">{{__('No')}}</label>
                </div>
              </fieldset>
            </li>
          </ul>  
                        </fieldset>
                        <h6>{{ __('dashboard.Rate from 1 star "bad" to 5 stars "best"') }}:</h6>
                        <div class="full-star-ratings" data-rateyo-full-star="true"></div>
                        <br>
                        <label>{{ __('dashboard.Your opinion important kindly write any notes about this session') }}:</label>
                        <div class="form-group">
                            <textarea class="form-control" id="comment" name='comment' rows="4" required
                                      placeholder="{{ __('dashboard.Write your notes here') }}." ></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary ml-1" >
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">{{__('dashboard.Submit')}}</span>
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@endif
@stop
@section('scripts')
<script src="/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
<script src="/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>
<script src="/app-assets/vendors/js/extensions/swiper.min.js"></script>
<script src="/js/jquery.datetimepicker.full.min.js"></script>
@if ($notrated_men or $notrated_ser)
<script src="/app-assets/vendors/js/extensions/jquery.rateyo.min.js"></script>
<script>
    $(function () {
        var isRtl = $('html').attr('data-textdirection') === 'rtl';
        var fullStar = $('.full-star-ratings');
        var instance = fullStar.rateYo({rtl: isRtl});
        // Rating onSet Event
        if (instance.length) {
            instance.rateYo({rtl: isRtl}).on('rateyo.set', function (e, data) {
                $('#rate').val(data.rating);
            });
        } });
</script>
@endif
<script>
    $(document).ready(function() {
        $('#mentorstable').DataTable({
                "responsive": true,
                "searching": true,
                "lengthChange": false,
                "paging": false,
                "bInfo": false,
                "columnDefs": [
                    {"orderable": false, "targets":  [3]},
                ],
            @if ($l=='ar')
            "language": {
                "sEmptyTable":     "ليست هناك بيانات متاحة في الجدول",
                "sLoadingRecords": "جارٍ التحميل...", "sProcessing":   "جارٍ التحميل...",
                "sLengthMenu":   "أظهر _MENU_ مدخلات", "sZeroRecords":  "لم يعثر على أية سجلات",
                "sInfo":         "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                "sInfoEmpty":    "يعرض 0 إلى 0 من أصل 0 سجل", "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                "sInfoPostFix":  "", "sSearch":       "ابحث:", "sUrl":          "",
                "oPaginate": {"sFirst":    "الأول", "sPrevious": "السابق", "sNext":     "التالي", "sLast":     "الأخير"},
                "oAria": {"sSortAscending":  ": تفعيل لترتيب العمود تصاعدياً", "sSortDescending": ": تفعيل لترتيب العمود تنازلياً"}}
            @endif
            }
        );
        @if ($notrated_men or $notrated_ser)
        //Open rate popup
        $('#RequestRate').modal('show');
        @endif
    });
    $('#date').datetimepicker({format:'Y-m-d H:i',onGenerate:function( ct ){
            jQuery(this).find('.xdsoft_date')
                .toggleClass('xdsoft_disabled');
        },
        maxDate:'{{date('Y/m/d',strtotime("-1 days"))}}',
        timepicker:true});
    function request(id,mentor) {
        $('#mentorid').val(id);
        $('#rname').html(mentor);
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST", url: "/admin/mentors/modify",
            data: {"id": id, "rtype": 5,},
            success: function (response) {
                $('#SendRequest li').remove();
                $('#name').html(name);
                if (response.length>0) {
                    $.each(response, function(i, item) {
                        let note = '';
                        let time = item.tfrom + " {{__('dashboard.to')}} " + item.tto;
                        if (item.notes) {note = item.notes;}
                        switch (item.type) {
                            case 'OneDay':
                                $('<li>').html("<b>" + item.dfrom + "</b> ("+ time +").").appendTo('#schedule');
                                break;
                            case 'Weekly':
                                $('<li>').html("<b> {{__('dashboard.Weekly')}} </b>(" + item.days + ") - ("+ time +").").appendTo('#schedule');
                                break;
                            case 'WorkingDays':
                                $('<li>').html("<b>{{__('dashboard.All working days')}} </b>("+ time +").").appendTo('#schedule');
                                break;
                            case 'Period':
                                $('<li>').html("<b> {{__('dashboard.from')}} " + item.dfrom + " {{__('dashboard.to')}} " + item.dto +" </b> ("+ time +").").appendTo('#schedule');
                                break;
                            case 'Session':
                                $('<li>').html("<b> {{__('dashboard.Busyday')}} " + item.dfrom + " (" + item.tfrom +"Min) </b>.").appendTo('#schedule');
                                break;

                            default:}
                    });
                } else {
                    $('<li>').html("{{__('dashboard.No records saved')}}.</li>").appendTo('#schedule');
                }
                $('#SendRequest').modal('show');
            },
            error: function (error) {
                console.log(error);
                alert("Error Occurred, Try again!");
            }});
    }
</script>
@stop