@extends('layouts.admin')
@section('vendorstyle')
<link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/charts/apexcharts.css">
<link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/extensions/swiper.min.css">
@stop
@section('style')
<link rel="stylesheet" type="text/css" href="/app-assets/css{{$l=='ar'?'-rtl':''}}/pages/dashboard-ecommerce.css">
@stop
@section('content')
 <!-- BEGIN: Content-->
 @php
     //Counts
     $messages = App\Messenger::where('receiver',Auth::user()->id)->whereNull('read')->count();
     $servrequests = App\ServicesRequests::whereNull('approved')->count();
     $mentrequests = App\MentorshipRequest::whereNull('approved')->count();
     $managers = App\User::join('model_has_roles','id','=','model_id')->where('role_id',5)->count();
     $cmessages = App\Messages::where('read','<>',1)->count();
     $startups= \App\Company::count();
     $mentors = App\User::join('model_has_roles', 'id', 'model_id')->where('role_id', 6)->count();
     $judgers = App\User::join('model_has_roles', 'id', 'model_id')->where('role_id', 7)->count();
     // lists
     $finalscr = \App\Finalscreening::where('datetime','>=',now()->format('Y-m-d'))->whereNotNull('start_url')->orderBy('datetime')->take(5)->get();
     $mentsessions = \App\MentorshipRequest::where('zoom_date','>=',now()->format('Y-m-d'))->whereNotNull('start_url')->orderBy('zoom_date')->take(5)->get();
     $trsessions = \App\TrainingSession::where('datetime','>=',now()->format('Y-m-d'))->whereNotNull('start_url')->orderBy('datetime')->take(5)->get();
     $e_latest = \App\Calendar::where('start','>=',now()->format('Y-m-d'))->where(function ($q) {
    $q->orWhere('user_id',Auth::id())
    ->orWhereNull('isPrivate');
})->orderBy('start')->take(5)->get();
	 $events = \App\Event::where('timerdate','>=',now()->format('Y-m-d'))->where('published','1')->orderBy('timerdate')->take(5)->get();
     //Charts
     $usersgov = App\User::join('states','state_id','=','states.id')
                ->select('name_en as state_en','name_ar as state_ar', DB::raw('count(*) as total'))->groupBy('name_en','name_ar');
     $usersgender = App\User::select('gender', DB::raw('count(*) as total'))->groupBy('gender');
/// Sectors chart
     $Industrial = App\Company::where('sector','Industrial')->count();
     $Agriculture = App\Company::where('sector','Agriculture')->count();
     $Commercial = App\Company::where('sector','Commercial')->count();
     $Technology = App\Company::where('sector','Technology')->count();
     $other = App\Company::whereNotIn('sector',['Industrial','Agriculture','Commercial','Technology'])->count();
/// Bar chart
    $New = App\Company::whereNull('cycle')->whereNotNull('step')->whereNull('approved')->count();
    $CycleRegistered =App\Company::where('cycle','>',0)->whereNull('approved')->count();
    $Approved = App\Company::where('cycle','>',0)->whereNotNull('approved')->count();
    $Disaproved = App\Company::where('cycle','>',0)->where('step',0)->whereNull('approved')->count();
 @endphp
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                @if(session()->has('msg'))
                    <div class="col-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-{{session()->get('class')}} mb-2" role="alert">
                                <button type="button" class="close" data-dismiss="alert"
                                        aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-{{session()->get('class')=='success'?'like':'error'}}"></i>
                                    <span>
                                                            {{ __('admin.'.session()->get('msg')) }}
                                        {{ Session::forget('msg') }}
                                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                @endif
                <div class="col-12">
                    <div class="row" >
                        <div class="col-sm-3 col-12 dashboard-users-success">
                            <div class="card text-center">
                                <div class="card-content">
                                    <a href="/admin/companies">
                                    <div class="card-body py-1">
                                        <div class="badge-circle badge-circle-lg badge-circle-light-primary mx-auto mb-50">
                                            <i class="bx bx-briefcase-alt font-medium-5"></i>
                                        </div>
                                        <div class="text-muted line-ellipsis">{{__('admin.Startups')}}</div>
                                        <h3 class="mb-0">{{$startups}}</h3>
                                    </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-12 dashboard-users-danger">
                            <div class="card text-center">
                                <div class="card-content">
                                    <a href="/admin/users#search=Mentor">
                                    <div class="card-body py-1">
                                        <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50">
                                            <i class="bx bxs-graduation font-medium-5"></i>
                                        </div>
                                        <div class="text-muted line-ellipsis">{{__('admin.Mentors')}}</div>
                                        <h3 class="mb-0">{{$mentors}}</h3>
                                    </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-12 dashboard-users-success">
                            <div class="card text-center">
                                <div class="card-content">
                                    <a href="/admin/users#search=Judger">
                                    <div class="card-body py-1">
                                        <div class="badge-circle badge-circle-lg badge-circle-light-primary mx-auto mb-50">
                                            <i class="bx bxs-filter-alt font-medium-5"></i>
                                        </div>
                                        <div class="text-muted line-ellipsis">{{__('admin.Judgers')}}</div>
                                        <h3 class="mb-0">{{$judgers}}</h3>
                                    </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-12 dashboard-users-danger">
                            <div class="card text-center">
                                <a href="/admin/users#search=Manager">
                                <div class="card-content">
                                    <div class="card-body py-1">
                                        <div class="badge-circle badge-circle-lg badge-circle-light-warning mx-auto mb-50">
                                            <i class="bx bxs-user-voice font-medium-5"></i>
                                        </div>
                                        <div class="text-muted line-ellipsis">{{__('admin.Managers')}}</div>
                                        <h3 class="mb-0">{{$managers}}</h3>
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>
                            <div class="col-sm-3 col-12 dashboard-users-success">
                                <div class="card text-center">
                                    <div class="card-content">
                                        <a href="/admin/inbox">
                                        <div class="card-body py-1">
                                            <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50">
                                                <i class="bx bxs-conversation font-medium-5"></i>
                                            </div>
                                            <div class="text-muted line-ellipsis">{{__('admin.New messages')}}</div>
                                            <h3 class="mb-0">{{$messages}}</h3>
                                        </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-12 dashboard-users-danger">
                                <div class="card text-center">
                                    <div class="card-content">
                                        <a href="/admin/mymsg">
                                        <div class="card-body py-1">
                                            <div class="badge-circle badge-circle-lg badge-circle-light-info mx-auto mb-50">
                                                <i class="bx bxs-message font-medium-5"></i>
                                            </div>
                                            <div class="text-muted line-ellipsis">{{__('admin.Contact us')}}</div>
                                            <h3 class="mb-0">{{$cmessages}}</h3>
                                        </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-12 dashboard-users-success">
                                <div class="card text-center">
                                    <div class="card-content">
                                        <a href="/admin/requests/all">
                                        <div class="card-body py-1">
                                            <div class="badge-circle badge-circle-lg badge-circle-light-primary mx-auto mb-50">
                                                <i class="bx bxs-megaphone font-medium-5"></i>
                                            </div>
                                            <div class="text-muted line-ellipsis">{{__('admin.Services Requests')}}</div>
                                            <h3 class="mb-0">{{$servrequests}}</h3>
                                        </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-12 dashboard-users-danger">
                                <div class="card text-center">
                                    <div class="card-content">
                                        <a href="/admin/mentorship/sessions">
                                        <div class="card-body py-1">
                                            <div class="badge-circle badge-circle-lg badge-circle-light-secondary mx-auto mb-50">
                                                <i class="bx bxs-help-circle font-medium-5"></i>
                                            </div>
                                            <div class="text-muted line-ellipsis">{{__('admin.Mentorship requests')}}</div>
                                            <h3 class="mb-0">{{$mentrequests}}</h3>
                                        </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title"><i class="bx bx-chat mr-1"></i>{{__('dashboard.Upcoming zoom sessions')}}</h4>
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
                                @if (count($finalscr)+count($mentsessions)+count($trsessions)>0)
                                    @foreach($mentsessions as $msitem)
                                        <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-75">
                                            <div class="widget-todo-title-area d-flex align-items-center">
                                                <a href="{{$msitem->start_url}}" target="_blank">
                                            <span class="widget-todo-title ml-50 text-primary">
                <i class="bx bxs-bell-ring text-primary"></i>
                                                {{__('dashboard.Mentorship session')}} (M{{$msitem->mentor_id}} -U{{$msitem->user_id}}) {{__('at')}} {{$msitem->zoom_date}}</span></a>
                                            </div>
                                            <div class="widget-todo-item-action d-flex align-items-center">
                                                <div class="badge badge-pill badge-light-primary mr-1">
                                                    <a href="/admin/mentorship/sessions?show=approved">
                                                        {{__('dashboard.Mentorship requests')}}
                                                   </a>
                                               </div>
                                           </div>
                                       </div>
                                   @endforeach
                                       @foreach($trsessions as $tritem)
                                           <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-75">
                                               <div class="widget-todo-title-area d-flex align-items-center">
                                                   <a href="{{$tritem->start_url}}" target="_blank">
                                            <span class="widget-todo-title ml-50 text-success">
                <i class="bx bxs-bell-ring text-primary"></i>
                                                 {{__('dashboard.Training')}} "{{$tritem->title}}" {{__('at')}} {{$tritem->datetime}}</span></a>
                                                </div>
                                                <div class="widget-todo-item-action d-flex align-items-center">
                                                    <div class="badge badge-pill badge-light-success mr-1">
                                                        <a href="/admin/training/sessions">
                                                            {{__('dashboard.Training sessions')}}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        @foreach($finalscr as $fsitem)
                                            <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-75">
                                                <div class="widget-todo-title-area d-flex align-items-center">
                                                    <a href="{{$fsitem->start_url}}" target="_blank">
                                            <span class="widget-todo-title ml-50 text-danger">
                <i class="bx bxs-bell-ring text-primary"></i>
                                                {{__('dashboard.Final screening for company')}}:{{$fsitem->company_id}} {{__('at')}} {{$fsitem->datetime}}</span></a>
                                                </div>
                                                <div class="widget-todo-item-action d-flex align-items-center">
                                                    <div class="badge badge-pill badge-light-danger mr-1">
                                                        <a href="/admin/final">
                                                            {{__('dashboard.Final sessions')}}
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
                                                {{__('dashboard.No Upcoming sessions')}} {{__('dashboard.Add yours now')}}</span>
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
                    <section><div class="row">
						<div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{__('admin.totalregisteredusers')}}</h4>
                                </div>
                                <div class="card-content" style="margin-right: {{$l=='ar'?'30px':'10px'}};">
                                    <div class="card-body pl-0">
                                        <div class="height-300">
                                            <canvas id="bar-chart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{__('admin.totalusersmf')}} </h4>
                                </div>
                                <div class="card-content" >
                                    <div class="card-body pl-0">
                                        <div class="height-300">
                                            <canvas id="simple-pie-chart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{__('admin.CompaniesBySector')}}</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="height-300">
                        <canvas id="simple-doughnut-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Horizontal Chart -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{__('admin.CompaniesStatus')}}</h4>
            </div>
            <div class="card-content" style="margin-right: {{$l=='ar'?'30px':'10px'}};">
                <div class="card-body pl-0">
                    <div class="height-300">
                        <canvas id="horizontal-bar"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
            </div>
        </div>
    </div>
    </div>
    <!-- END: Content-->
@stop

@section('scripts')
	<script src="/app-assets/vendors/js/charts/chart.min.js"></script>
	<script src="/app-assets/vendors/js/extensions/swiper.min.js"></script>
@stop
@section('pagescripts')
    <script>
        $(window).on("load", function () {
            var $primary = '#5A8DEE',
                $success = '#39DA8A',
                $danger = '#FF5B5C',
                $warning = '#FDAC41',
                $info = '#00CFDD',
                $label_color = '#475F7B',
                grid_line_color = '#dae1e7';
            var themeColors = [$primary, $warning, $success, $danger, $info, $label_color,$primary, $warning, $danger, $success, $info, $label_color,
                $primary, $warning, $danger, $success, $info, $label_color,$primary, $warning, $danger, $success, $info, $label_color];
            var barChartctx = $("#bar-chart");
            // Chart Options
            var barchartOptions = {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderSkipped: 'left'
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                responsiveAnimationDuration: 500,
                legend: { display: false },
                scales: {
                    xAxes: [{
                        display: true,
                        gridLines: {
                            color: grid_line_color,
                        },
                        scaleLabel: {
                            display: true,
                        }
                    }],
                    yAxes: [{
                        display: true,
                        gridLines: {
                            color: grid_line_color,
                        },
                        scaleLabel: {
                            display: true,
                        },
                        ticks: {
                            stepSize: 10
                        },
                    }],
                },
                title: {
                    display: false,
                    text: '{{__('admin.totalregisteredusers')}}'
                },
            };
            // Chart Data
            var barchartData = {
                labels: {!!$usersgov->pluck('state_'.$l)->toJson()!!},
                datasets: [{
                    label: "Total",
                    data: {!!$usersgov->pluck('total')->toJson()!!},
                    backgroundColor: themeColors,
                    borderColor: "transparent"
                }]
            };
            var barChartconfig = {
                type: 'bar',
                options: barchartOptions,
                data: barchartData
            };
            // Create the chart
            var barChart = new Chart(barChartctx, barChartconfig);
            var pieChartctx = $("#simple-pie-chart");
            var piechartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                responsiveAnimationDuration: 500,
                title: {
                    display: false,
                    text: '{{__('admin.totalregisteredusers')}}'
                }
            };
            var piechartData = {
                labels: ['{{__('admin.Male')}}','{{__('admin.Female')}}'],
                datasets: [{
                    label: "{{__('admin.totalregistered')}}",
                    data: {!!$usersgender->pluck('total')->toJson()!!},
                    backgroundColor: themeColors,
                }]
            };
            var pieChartconfig = {
                type: 'pie',
                // Chart Options
                options: piechartOptions,
                data: piechartData
            };
            var pieSimpleChart = new Chart(pieChartctx, pieChartconfig);
            // Doughnut Chart
            var doughnutChartctx = $("#simple-doughnut-chart");
            // Chart Options
            var doughnutchartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                responsiveAnimationDuration: 500,
                title: {
                    display: false,
                    text: 'Companies count by sector'
                }
            };
            // Chart Data
            var doughnutchartData = {
                labels: [{!! '"'.__('Industrial').'","'.__('Agriculture').'","'.__('Commercial').'","'. __('Technology').'","'. __('Other').'"' !!}],
                datasets: [{
                    label: "Sectors",
                    data: [{{$Industrial.','.$Agriculture.','.$Commercial.','.$Technology.','.$other}}],
                    backgroundColor: themeColors,
                }]
            };
            var doughnutChartconfig = {
                type: 'doughnut',
                options: doughnutchartOptions,
                data: doughnutchartData
            };
            var doughnutSimpleChart = new Chart(doughnutChartctx, doughnutChartconfig);

            // Horizontal Chart
            // -------------------------------------

            // Get the context of the Chart canvas element we want to select
            var horizontalChartctx = $("#horizontal-bar");

            var horizontalchartOptions = {
                // Elements options apply to all of the options unless overridden in a dataset
                // In this case, we are setting the border of each horizontal bar to be 2px wide
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderSkipped: 'right',
                        borderSkipped: 'top',
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                responsiveAnimationDuration: 500,
                legend: {
                    display: false,
                },
                scales: {
                    xAxes: [{
                        display: true,
                        gridLines: {
                            color: grid_line_color,
                        },
                        scaleLabel: {
                            display: true,
                        },
                        ticks: {
                            beginAtZero: true,
                            precision: 0,
                        }
                    }],
                    yAxes: [{
                        display: true,
                        gridLines: {
                            color: grid_line_color,
                        },
                        scaleLabel: {
                            display: true,
                        }
                    }]
                },
                title: {
                    display: false,
                    text: 'By Cycle'
                }
            };

            // Chart Data
            var horizontalchartData = {
                labels: ["{{__('admin.New')}}", "{{__('admin.Approved')}}", "{{__('admin.CycleRegistered')}}",  "{{__('admin.Disapproved')}}"],
                datasets: [{
                    label: "",
                    data: [{{$New}}, {{ $Approved}} , {{$CycleRegistered}}, {{$Disaproved }} ],
                    backgroundColor: themeColors,
                    borderColor: "transparent"
                }]
            };

            var horizontalChartconfig = {
                type: 'horizontalBar',

                // Chart Options
                options: horizontalchartOptions,

                data: horizontalchartData
            };

            // Create the chart
            var horizontalChart = new Chart(horizontalChartctx, horizontalChartconfig);

        });
    </script>


@stop
