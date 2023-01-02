@extends('layouts.admin')
@section('style')
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/extensions/dragula.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/plugins/extensions/drag-and-drop.css">
    <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.min.css">
@stop
@section('content')
<!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('cycles.Cycles')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
									<li class="breadcrumb-item active">{{__('cycles.Manage Cycles')}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<div class="content-body">
    @if(count($cycles)>0)
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
                                    <h4 class="card-title">{{__('cycles.Portal Cycles')}}</h4>
                                </div>
                                <hr>
                                <div class="card-body">
                                    <span>{{__('cycles.Select cycle from list')}}</span>
                                    <fieldset class="input-group">
                                            <select id="ccycle" class="select form-control" onchange="window.open('/admin/cycles/'+this.options[this.selectedIndex].value,'_self');">
                                                @foreach($cycles as $cycle)
                                                    <option value="{{$cycle->id}}" {{$cycle->id==$id?'selected':''}}>{{$cycle->title}} ({{__('cycles.Start')}} {{$cycle->start->format('d-m')}} {{__('cycles.to')}} {{$cycle->end->format('d-m')}})</option>
                                                @endforeach
                                            </select>
                                        <div class="input-group-append">
                                    <button class="btn btn-secondary" onclick="window.location.href='/admin/cycles/{{$id}}/registered'">
                                                <i class="bx bxs-user"></i> <span class="align-middle ml-25">{{__('cycles.Users')}}</span>
                                    </button>
                                    <button class="btn btn-primary" onclick="DoChange(1)">
                                        <i class="bx bx-edit"></i> <span class="align-middle ml-25">{{__('cycles.Edit')}}</span>
                                    </button>
                                    <button class="btn btn-success" onclick="DoChange(2)">
                                        <i class="bx bx-star" ></i> <span class="align-middle ml-25">{{__('cycles.New')}}</span>
                                    </button>
                                    <button class="btn btn-danger" onclick="DoChange(3)">
                                        <i class="bx bx-trash"></i> <span class="align-middle ml-25">{{__('cycles.Delete')}}</span>
                                    </button>
                                        </div>
                                    </fieldset>
                                    <br />
                                    <span>{{__('cycles.Add cycle steps')}}</span>
                                    <fieldset class="input-group">
                                            <select class="select form-control" id="StepSelect" >
                                                <option value="1" >{{__('cycles.Custom Form')}}</option>
                                                <option value="2" >{{__('cycles.Screening')}}</option>
                                                <option value="3" >{{__('cycles.Mentorship')}}</option>
                                                <option value="4" >{{__('cycles.Training')}}</option>
                                                <option value="5" >{{__('cycles.Final evaluation')}}</option>
                                            </select>
                                        <span class="input-group-append">
                                    <button class="btn btn-warning" onclick="DoChange(4)">
                                        <i class="bx bx-plus-circle" ></i> <span class="align-middle ml-25">{{__('cycles.Add New step')}}</span>
                                    </button>
                                        </span>

                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
    <!-- Sortable lists section start -->
    <section id="sortable-lists">
        <div class="row">
            <!-- Basic List Group -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{__('cycles.Cycle steps')}}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <p>{{__('cycles.Drag arrange')}}.</p>
                            <ul class="list-group" id="basic-list-group">
                                @foreach($steps as $step)
                                <li class="list-group-item">
                                    <div class="media">
                                        <i class="livicon-evo mr-2" data-options="name: {{$svgs[$step->stype-1]}}.svg; size: 50px; style: original;"></i>
                                        <div class="media-body">
                                            <h5 class="mt-0"><span id="{{$step->id}}-step" class="carr">{{$step->arr}}</span>-&nbsp;{{$step->title}}</h5>
                                            {{__('cycles.Start From')}} {{$step->from->format('d-m')}}, {{__('cycles.to')}} {{$step->to->format('d-m-Y')}}
                                        </div>
                                        <a href="javascript:void(0)" onclick="ModifyStep(1,{{$step->id}})" id="{{$step->id}}" title="{{__('cycles.Edit Title and dates')}}">
                                            <span class="badge badge-success badge-pill"><i style="font-size: 14px;" class="bx bx-pencil"></i></span>
                                        </a>&nbsp;
                                        <a href="javascript:void(0)" onclick="deleteStep(this.id)" id="{{$step->id}}" title="{{__('cycles.Delete current step')}}">
                                        <span class="badge badge-danger badge-pill"><i style="font-size: 14px;" class="bx bx-trash"></i></span>
                                        </a>&nbsp;
                                        @php
                                        if ($step->stype=='1') {
                                                $link = 'cycles/view/'.$step->cycle_id;
                                                $set = 'show-builder';
                                            } elseif ($step->stype=='2') {
                                                $link = $step->id.'/screening';
                                                $set = $step->id.'/screening';
                                            } elseif ($step->stype=='3') {
                                                $link = 'mentorship/sessions';
                                                $set = 'mentorship/assign/'.$step->cycle_id;
                                            } elseif ($step->stype=='4') {
                                                $link = $set = 'training/sessions/'.$step->id;
                                            } else {
                                                $link = 'final/results/'.$step->id;
                                                $set = $step->id.'/final/';
                                            }
                                        @endphp
                                        <a href="/admin/{{$set}}" id="{{$step->id}}">
                                            <span class="badge badge-secondary badge-pill"><i style="font-size: 15px;" class="bx bx-cog" title="{{__('cycles.Step settings')}}"></i></span>
                                        </a>&nbsp;
                                        <a href="/admin/{{$link}}" id="{{$step->id}}">
                                            <span class="badge badge-primary badge-pill"><i style="font-size: 15px;" class="bx bx-show" title="{{__('cycles.view step results')}}"></i></span>
                                        </a>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- // Sortable lists section end -->
    @else
        <div class="card">
            <div class="card-header border-bottom">
                <h4 class="card-title">{{ __('cycles.Error') }}</h4>
            </div>
                <div class="card-body">
                    {{__('cycles.No records ... Add cycle first')}}: <button class="btn btn-light-primary" onclick="DoChange(2)">{{__('cycles.Add new')}}</button>
                </div>
            </div>
        </div>
    @endif
            </div>
        </div>
    </div>
    <!-- END: Content-->
<!--Cycle Modal -->
<div class="modal fade text-left" id="cycleForm" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form class="form" action= "{{URL::to('admin/cycles/modify')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                {!! csrf_field() !!}
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">{{__('cycles.Cycle data')}}
                </h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
                <div class="modal-body">
                    <label>{{__('cycles.Cycle title')}}: </label>
                    <div class="form-group">
                        <input type="hidden" name="type" id="type">
                        <input type="hidden" name="cycleid" id="cycleid">
                        <input id='title' name='title' type="text" placeholder="{{__('cycles.Title')}}" class="form-control" required>
                    </div>
                    <label>{{__('cycles.Valid from')}}: </label>
                    <div class="form-group">
                        <input id='start' name='start' type="text" placeholder="{{now()->format('Y-m-d')}}" class="form-control date" required>
                    </div>
                    <label>{{__('cycles.Valid to')}}: </label>
                    <div class="form-group">
                        <input id='end' name='end' type="text" placeholder="{{now()->addDays(15)->format('Y-m-d')}}" class="form-control date" required>
                    </div>
                    <label>{{__('cycles.Description')}}: </label>
                    <div class="form-group mb-0">
                        <textarea id='description' name='description' placeholder="{{__('cycles.Description')}}" class="form-control"></textarea>
                    </div>
                    <label> </label>
                    <div class="form-group mb-0 custom-switch">
                        <span>{{__('settings.Private')}}</span>&nbsp;
                        <input name="private" type="checkbox" class="custom-control-input" id="customSwitch3">
                        <label class="custom-control-label mr-1" for="customSwitch3"></label>
                        <a id="cyclelink" target="_blank"></a>
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
<!--Add step form Modal -->
<div class="modal fade text-left" id="stepForm" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form class="form" action= "{{URL::to('admin/cycles/modify')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                {!! csrf_field() !!}
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">{{__('cycles.New step data')}} - <span id="formtitle">{{__('cycles.Custom Form')}}</span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="cid" id="cid" value="{{$id}}">
                    <input type="hidden" name="type" id="type5" value="5">
                    <input type="hidden" name="arr" id="sarr" value="{{isset($step)?$step->arr+1:1}}">
                    <input type="hidden" name="stype" id="stype" value="1">
                    <div id="menu1">
                    <label>{{__('cycles.Choose form')}}: </label>
                    <div class="form-group mb-0">
                        <select class="select form-control" name="FormSelect" required>
                            @foreach(\App\BuilderForm::all() as $form)
                            <option value="{{$form->id}}" >{{$form->form_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    </div>
                    <div id="menu2">
                        <label>{{__('cycles.Choose screening type')}}: </label>
                        <div class="form-group mb-0">
                            <select class="select form-control" name="ScreeningSelect" required>
                                    <option selected disabled> {{__('cycles.Select type')}}</option>
                                    <option value="onetoall">{{__('cycles.Assign One to all users')}}</option>
                                    <option value="grouptoall">{{__('cycles.Assign Group to all users')}}</option>
                                        <option value="grouptogroup">{{__('cycles.Assign Group to group of users')}}</option>
                            </select>
                        </div>
                    </div>
                    <label>{{__('cycles.Step Title')}}: </label>
                    <div class="form-group">
                        <input id='title' name='title' type="text" placeholder="{{__('cycles.Title')}}" class="form-control" required>
                    </div>
                    <label>{{__('cycles.Valid from')}}: </label>
                    <div class="form-group">
                        <input id='fromDate' name='fromDate' type="text" placeholder="{{now()->format('Y-m-d')}}" class="form-control" required readonly>
                    </div>
                    <label>{{__('cycles.Valid to')}}: </label>
                    <div class="form-group">
                        <input id='toDate' name='toDate' type="text" placeholder="{{now()->addDays(15)->format('Y-m-d')}}" class="form-control" required readonly>
                    </div>
                    <label>{{__('cycles.Description')}}: </label>
                    <div class="form-group mb-0">
                        <textarea id='description' name='description' placeholder="{{__('cycles.Description')}}" class="form-control"></textarea>
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
<!--Modify custom form step Modal -->
<div class="modal fade text-left" id="ModifyStepForm" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form class="form" action= "{{URL::to('admin/cycles/modify')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                {!! csrf_field() !!}
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">{{__('cycles.Modify current step')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="sid" id="sid" >
                    <input type="hidden" name="type" id="type7" value="8">
                    <label>{{__('cycles.Form title')}}: </label>
                    <div class="form-group">
                        <input id='mtitle' name='title' type="text" placeholder="{{__('cycles.Title')}}" class="form-control" required>
                    </div>
                    <label>{{__('cycles.Valid from')}}: </label>
                    <div class="form-group">
                        <input id='mfromDate' name='fromDate' type="text"  class="form-control" required readonly>
                    </div>
                    <label>{{__('cycles.Valid to')}}: </label>
                    <div class="form-group">
                        <input id='mtoDate' name='toDate' type="text" class="form-control" required readonly>
                    </div>
                    <label>{{__('cycles.Description')}}: </label>
                    <div class="form-group mb-0">
                        <textarea id='mdescription' name='description' placeholder="{{__('cycles.Description')}}" class="form-control"></textarea>
                    </div>
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
@stop
@section('pagescripts')
   @php (count($cycles)>0 ? $ccycle = \App\Cycle::findOrFail($id):$ccycle ='')
    <script src="/app-assets/vendors/js/extensions/dragula.min.js"></script>
    <script src="/js/jquery.datetimepicker.full.min.js"></script>
    <script>
        $('.date').datetimepicker({timepicker:false,format:'Y-m-d'});
        $('#fromDate,#toDate,#mfromDate,#mtoDate').datetimepicker({format:'Y-m-d',
            minDate:'{{$ccycle?$ccycle->start->format('Y/m/d'):''}}',
            maxDate:'{{$ccycle?$ccycle->end->format('Y/m/d'):''}}',
            timepicker:false});
        $(document).ready(function () {
            let drake =  dragula([document.getElementById('basic-list-group')]);
            drake.on('drop', function(el) {
                let badges = document.getElementsByClassName('carr');
                let ids = [];
                for (let i = 0; i<badges.length-1; ++i) {badges[i].innerText=i+1;let id = badges[i].id.split('-');ids.push(id[0]);}
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                $.ajax({
                    type: "POST", url: "/admin/cycles/modify",
                    data: {
                        "steps": ids,
                        "type" : 4,
                    },
                    success: function (response) {
                        console.log(response);
                    },
                    error: function (error) {
                        console.log(error);
                        alert("Error Occurred, arrange failed");
                    }});
            })});
        function DoChange(set) {
            var cycle = $('#ccycle').find(":selected").val();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            switch (set) {
                case 1:
                    $.ajax({
                        type: "POST", url: "/admin/cycles/modify",
                        data: {
                            "cycleid": cycle,
                        },
                        success: function (response) {
                            $('#title').val(response.title);$('#description').val(response.description);
                            $('#cycleid').val(cycle);$('#type').val(1);$('#start').val(response.start);$('#end').val(response.end);
                            if (response.private) {$('#customSwitch3').attr('checked','checked');$('#cyclelink').html('{{__('cycles.Join URL')}}');$('#cyclelink').attr('href', '/admin/cycles/view/' + response.id + '?id=' + response.private);}
                            $('#cycleForm').modal('show');
                        },
                        error: function (error) {
                            console.log(error);
                            alert("Error Occurred, Try again!");
                        }
                    });
                    break;
                case 2:
                    $('#title').val('');$('#description').val('');
                    $('#cycleid').val('');$('#type').val(2);$('#start').val('');$('#end').val('');
                    $('#customSwitch3').removeAttr('checked');
                    $('#cycleForm').modal('show');
                    break;
                case 3:
                    if (confirm('{{__('cycles.sure delete cycle')}}?')) {
                    if (confirm('{{__('cycles.cant undo')}}'))
                    {$.ajax({
                            type: "POST", url: "/admin/cycles/modify",
                            data: {
                                "cycleid": cycle, "type" : 3,
                            },
                            success: function (response) {
                                console.log(response);
                                location.href = '/admin/cycles';
                            },
                            error: function (error) {
                                console.log(error);
                                alert("Error Occurred, Try again!");
                        }});}}
                    break;
                case 4:
                    let step = $('#StepSelect').find(":selected").val();
                    let steptxt = $('#StepSelect').find(":selected").text();
                    let menu = $('#menu'+step);
                    $('#menu1,#menu2').hide();
                    if (menu !== null) {menu.show();}
                    if (step==='5'){$('#menu1').show();}
                    $('#stype').val(step);
                    $('#formtitle').text(steptxt);
                    $('#stepForm').modal('show');
                break;
            }}
        function ModifyStep(set,id) {
            var cycle = $('#ccycle').find(":selected").val();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            switch (set) {
                case 1:
                    $.ajax({
                        type: "POST", url: "/admin/cycles/modify",data: {"type" : 7,"sid" : id,"cycleid" : 0,},
                        success: function (response) {
                            $('#sid').val(response.id);
                            $('#mtitle').val(response.title);$('#mdescription').val(response.description);
                            $('#mfromDate').val(response.from);$('#mtoDate').val(response.to);
                            $('#ModifyStepForm').modal('show');
                        },
                        error: function (error) {
                            console.log(error);
                            alert("Error Occurred, Try again!");
                        }
                    });
                    break;
            }}
            function deleteStep (id) {
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                if (confirm('{{__('cycles.sure delete step')}}?'))
                {
                    let badges = document.getElementsByClassName('carr');
                    let ids = [];
                    for (let a = 0; a<badges.length; ++a) {badges[a].innerText=a+1;let id = badges[a].id.split('-');ids.push(id[0]);}
                    $.ajax({
                        type: "POST", url: "/admin/cycles/modify",
                        data: {"stepid": id,"steps": ids, "type" : 6,},
                        success: function (response) {
                            console.log(response);
                            location.href = '/admin/cycles/'+$('#ccycle').find(":selected").val();
                        },
                        error: function (error) {
                            console.log(error);
                            alert("Error Occurred, Try again!");
                        }
                    });
                }}
    </script>
@stop


