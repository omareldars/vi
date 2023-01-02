@extends('layouts.admin')
@section('style')
<link rel="stylesheet" type="text/css" href="/app-assets/css{{$l=='ar'?'-rtl':''}}/pages/widgets.css">
<link rel="stylesheet" type="text/css" href="/app-assets/css{{$l=='ar'?'-rtl':''}}/pages/dashboard-ecommerce.css">
<link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/tables/datatable/datatables.min.css">
@stop
@section('title', __('admin.Dashboard') )
@section('subTitle', __('admin.My Dashboard'))
@section('content')
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
                            <button type="button" class="close" data-dismiss="alert"
                                    aria-label="Close">
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
                                        <i class="bx bx-badge-check font-medium-5"></i>
                                    </div>
                                    <div class="text-muted line-ellipsis">{{__('dashboard.First screening')}}</div>
                                    <h3 class="mb-0">{{  count($csteps) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-12">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body py-1">
                                    <div class="badge-circle badge-circle-lg badge-circle-light-warning mx-auto mb-50">
                                        <i class="bx bx-bullseye font-medium-5"></i>
                                    </div>
                                    <div class="text-muted line-ellipsis">{{__('dashboard.Final screening')}}</div>
                                    <h3 class="mb-0">{{count($fcompanies)}}</h3>
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
                                <h4 class="card-title d-flex align-items-center">
                                    <i class='bx bx-card font-medium-4 mr-1'></i>{{__('dashboard.Your Judging List')}}</h4>
                            </div>
                            <div class="card-body">

@if (count($csteps)>0)
@foreach($csteps as $step)
                                <div class="card border-light">
                                    <div class="card-header">
                                        <h4 class="primary"><i class="bx bxs-bell"></i>{{$step->title}} - ({{$step->cycle->title}}) - {{__('dashboard.start from')}} {{$step->from->format('d-m')}} {{__('dashboard.to')}} {{$step->to->format('d-m-Y')}}</h4>
                                    </div>
                                    <div class="card-body bg-rgba-light">
                                        <p class="card-text">
                                            {{$step->description}}
                                        </p>
                                        <small class="text-muted">{{__('dashboard.This Cycle Start from')}} {{$step->cycle->start->format('d-m')}} {{__('dashboard.to')}} {{$step->cycle->end->format('d-m-Y')}}</small>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th>{{__('dashboard.Company')}}</th>
                                                <th>{{__('dashboard.User/Title')}}</th>
                                                <th>{{__('dashboard.Screening completed')}}</th>
                                                <th>{{__('dashboard.AVG degree')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                $form = \App\Step::where('cycle_id',$step->cycle_id)->where('stype',1)->where('arr',$step->arr-1)->first(['id']);
                                $groups = App\Screening::where('user_id',Auth::id())->where('step_id',$step->id)->pluck('users');
                                $groups = json_decode("[".str_replace(['[',']'],' ',json_encode($groups))."]");
                                if ($mysteps->where('step_id',$step->id)->pluck('panel')->first()==0) {
                                  $companies = \App\Company::where('step',$step->id)->get();
                                } else {
                                  $companies = \App\Company::where('step',$step->id)->whereIN('id',$groups??[])->get();
                                }
                                            @endphp
                                            @foreach($companies as $company)
                                            <tr>
                                                <td>
                                                    <div class="media align-items-center">
                                                        <a class="media-left mr-50">
                                                            <img src="/191014/{{$company->logo??'../app-assets/images/logo_placeholder.png'}}" alt="avatar" class="rounded-circle" height="40" width="40">
                                                        </a>
                                                    <a href="/admin/screening/{{$form->id??'0'}}/{{$company->id}}">
                                                    <div class="media align-items-center">
                                                    {{$company->{'name_'.$l} }}
                                                    </div>
                                                    </a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="media align-items-center">
                                                        <a class="media-left mr-50">
                                                            <img src="/191014/{{$company->user->img_url??'../images/placeholder.jpg'}}" alt="avatar" class="rounded-circle" height="40" width="40">
                                                        </a>
                                                        <a href="/admin/screening/{{$form->id??''}}/{{$company->id}}">
                                                            <div class="media-body">
                                                                <h6 class="media-heading mb-0">{{$company->user->{'first_name_'.$l} }} {{$company->user->{'last_name_'.$l} }}</h6>
                                                                <span class="font-small-2">{{$company->user->{'title_'.$l} }}</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </td>
                                                @php
                                                    $weight=$company->companyWeight($company->id,$form->id??'',Auth::id());
                                                    $judgepercentage = $company->companyJudge($company->id,$form->id??'',Auth::id());
                                                @endphp
                                                <td>
                                                    <div class="progress progress-bar-{{$judgepercentage<50?'danger':($judgepercentage<75?'warning':'success') }} progress-sm mb-0">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="52" aria-valuemin="80" aria-valuemax="100" style="width:{{$judgepercentage}}%;"></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge badge-light-{{$weight<25?'danger':($weight<50?'warning':'success') }}"> {{$weight}} %</span>
                                                </td>
                                            </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>


                                </div>
@endforeach
@else
                        {{__('dashboard.No screening started yet')}}.
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
                            <h4 class="card-title d-flex align-items-center">
                                <i class='bx bx-card font-medium-4 mr-1'></i>{{__('dashboard.Cycle final screening')}}</h4>
                        </div>
                        <div class="card-body">
                            @php
                                $today = date("Y-m-d");
                                $csteps = App\Step::whereRaw( '"'.$today. '" BETWEEN `from` AND `to`')->where('stype',5)->get()
                            @endphp
                            @if (count($fcompanies)>0)
                                @foreach($csteps as $step)

                                    <div class="card border-light">
                                        <div class="card-header">
                                            <h4 class="primary"><i class="bx bxs-bell"></i>{{$step->title}} - ({{$step->cycle->title}}) - {{__('dashboard.start from')}} {{$step->from->format('d-M')}} {{__('dashboard.to')}} {{$step->to->format('d-M-Y')}}</h4>
                                                </div>
                                                <div class="card-body bg-rgba-light">
                                                    <p class="card-text">
                                                        {{$step->description}}
                                                    </p>
                                                    <small class="text-muted">{{__('dashboard.This Cycle Start from')}} {{$step->cycle->start->format('d-m')}} {{__('dashboard.to')}} {{$step->cycle->end->format('d-m-Y')}}</small>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table mb-0">
                                                        <thead class="thead-dark">
                                                        <tr>
                                                            <th>{{__('dashboard.Company')}}</th>
                                                            <th>{{__('dashboard.User/Title')}}</th>
                                                            <th>{{__('dashboard.Meeting')}}</th>
                                                            <th>{{__('dashboard.Actions')}}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                        @foreach($fcompanies as $fcompany)
                                                            <tr>
                                                                <td>
                                                                    <div class="media align-items-center">
                                                                        <a class="media-left mr-50">
                                                                            <img src="/191014/{{$fcompany->company->logo??'../app-assets/images/logo_placeholder.png'}}" alt="avatar" class="rounded-circle" height="40" width="40">
                                                                        </a>
                                                                        <a href="/admin/companyProfile/{{$fcompany->company_id}}">
                                                                            <div class="media align-items-center">
                                                                                {{$fcompany->company->{'name_'.$l} }}
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="media align-items-center">
                                                                        <a class="media-left mr-50">
                                                                            <img src="/191014/{{$fcompany->company->user->img_url??'../images/placeholder.jpg'}}" alt="avatar" class="rounded-circle" height="40" width="40">
                                                                        </a>
                                                                        <a href="/admin/companyProfile/{{$fcompany->company_id}}">
                                                                            <div class="media-body">
                                                                                <h6 class="media-heading mb-0">{{$fcompany->company->user->{'first_name_'.$l} }} {{$fcompany->company->user->{'last_name_'.$l} }}</h6>
                                                                                <span class="font-small-2">{{$fcompany->company->user->{'title_'.$l} }}</span>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                </td>

                                                                 
                                                                <td>
                                                                    {{$fcompany->datetime??__('dashboard.Not added yet')}}
                                                                </td>
                                                                <td>
                                                                    @if($fcompany->join_url)
                                                                        <a href="{{$fcompany->join_url}}" target="_blank">
                                                                            <button title="Join" type="button" class="btn btn-icon rounded-circle btn-light-primary">
                                                                                <i class="bx bx-user"></i></button></a>
                                                                        <a href="/admin/final/{{$step->id}}/{{$fcompany->company_id}}" target="_blank">
                                                                        <button title="Open form" type="button" class="btn btn-icon rounded-circle btn-light-success">
                                                                            <i class="bx bx-file"></i></button></a>
                                                                    @else
                                                                       {{__('dashboard.Not started')}}
                                                                        @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>


                                            </div>
                                        @endforeach
                                    @else
                                        {{__('dashboard.No Final screening started yet')}}.
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
        </div>
    </div>
</div>
<!-- END: Content-->
@stop
@section('pagescripts')

<script src="/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
<script src="/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('.table').DataTable({
                "responsive": true,
                "searching": false,
                "lengthChange": false,
                "paging": false,
                "bInfo": false,
                "columnDefs": [
                    {"orderable": false, "targets":  [2]},
                ]
            }
        );
    });
</script>
@stop