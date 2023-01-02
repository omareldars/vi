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
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('cycles.Final Screening')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
									<li class="breadcrumb-item active">{{__('cycles.Manage Final Screening')}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<div class="content-body">
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
                                    <h4 class="card-title">{{__('cycles.Portal Final Screening list')}}</h4>
                                </div>
                                <hr>
                                <div class="card-body">
                                    <span>{{__('cycles.Select step from list to manage')}}</span>
                                    <fieldset class="input-group">
                                            <select id="cstep" class="select form-control" onchange="window.open('/admin/'+this.options[this.selectedIndex].value+'/final','_self');">
                                                @foreach($steps as $step)
                                                    <option value="{{$step->id}}" {{$step->id==$id?'selected':''}}>{{$step->title}} ({{__('cycles.Cycle')}} "{{$step->cycle->title}}" - {{__('cycles.Start')}} {{$step->from->format('d-m')}})</option>
                                                @endforeach
                                            </select>
                                        <div class="input-group-append">
                                    <button class="btn btn-primary" onclick="DoChange(1)">
                                        <i class="bx bx-edit"></i> <span class="align-middle ml-25">{{__('cycles.Edit')}}</span>
                                    </button>
                                    <button class="btn btn-danger" onclick="DoChange(2)" >
                                        <i class="bx bx-trash"></i> <span class="align-middle ml-25">{{__('cycles.Delete')}}</span>
                                    </button>
                                            <button class="btn btn-secondary" onclick="window.location.href='/admin/final/results/{{$id}}'">
                                                <i class="bx bxs-user"></i> <span class="align-middle ml-25">{{__('cycles.Results')}}</span>
                                            </button>
                                    <a class="btn btn-success" href="/admin/cycles/{{$cstep->cycle_id??null}}">
                                         <i class="bx bx-pencil"></i> <span class="align-middle ml-25">{{__('cycles.Cycle')}}</span>
                                    </a>
                                        </div>
                                    </fieldset>
                                    <br />
                                </div>
                            </div>

                            @if(!$cstep)
                                <div class="card">
                                    <div class="card-header border-bottom">
                                        <h4 class="card-title">{{ __('cycles.Error') }}</h4>
                                    </div>
                                        <div class="card-body">
                                            {{__('cycles.No records Add final')}} <a href="/admin/cycles">{{__('cycles.Cycle')}}</a>.
                                        </div>

                                </div>
                            @endif

                        </div>
                    </div>
                </section>
    <section class="row">
        @if(isset($cstep))


    <div class="col-xl-12 col-md-12 col-sm-12">
                        <div class="card">
                            <form action="/admin/final/update" method="POST" enctype="multipart/form-data">
                                {!! csrf_field() !!}
                            <div class="card-header border-bottom">
                                <h4>{{$cstep->title}} <small class="text-muted"> {{__('cycles.from')}} {{$cstep->from->format('d-m')}} {{__('cycles.to')}} {{$cstep->to->format('d-m-Y')}}</small></h4>
                                <h4 class="card-title primary">{{__('cycles.Select judges from the menu')}}.</h4>
                            </div>
                            <div class="card-body">
                                    <div class="card-text">
                                        <input type="hidden" value="{{$cstep->id}}" name="step">
                                        <div class="form-group">
                                                <div class="form-row">
                                                    <p style="margin:5px;">{{__('cycles.Judges list')}}</p>
                                                    <div class="row col-md-12">
                                                        <div class="col-md-12">
                                                            <select name="judges[]" class="select2 form-control" multiple="multiple">
                                                                @foreach($judges as $judge)
                                                                    <option value="{{$judge->id}}">{{$judge->{'first_name_'.$l} }}  {{$judge->{'last_name_'.$l} }} ({{$judge->email}})</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit"
                                                        class="btn btn-primary mr-1 mb-1">{{__('cycles.Assign to selected users')}}</button>
                                            </div>
                                        </div>

                                         <div class="table-responsive">
                                            <table class="table" id="mentorstable">
                                                <thead class="thead-dark">
                                                <tr>
                                                    <th>{{__('cycles.Company')}}</th>
                                                    <th>{{__('cycles.Users')}}</th>
                                                    <th>{{__('cycles.Judges')}}</th>
                                                    <th>{{__('cycles.Actions')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($companies as $company)
                                                    <tr>
                                                        <td>
                                                            <div class="checkbox">
                                                                <input type='checkbox' id="checkbox{{$company->id}}" class="checkbox-input"
                                                                       {{ in_array($company->id,[]) ? 'checked' :'' }}
                                                                       name='users[]' value="{{$company->id}}">
                                                                <label for="checkbox{{$company->id}}">
                                                            <div class="media align-items-center">
                                                                <a class="media-left mr-50" href="/admin/companyProfile/{{$company->id}}">
                                                                    <img src="/191014/{{$company->logo??'../app-assets/images/logo_placeholder.png'}}" alt="avatar" class="rounded-circle" height="40" width="40">
                                                                </a>
                                                                <a href="/admin/companyProfile/{{$company->id}}">
                                                                    <div class="media align-items-center">
                                                                        {{$company->{'name_'.$l} }}
                                                                    </div>
                                                                </a>
                                                            </div>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="media align-items-center">
                                                                <a class="media-left mr-50" href="/admin/users/{{$company->user->id}}/edit">
                                                                    <img src="/191014/{{$company->user->img_url??'../images/placeholder.jpg'}}" alt="avatar" class="rounded-circle" height="40" width="40">
                                                                </a>
                                                                <a href="/admin/users/{{$company->user->id}}/edit">
                                                                    <div class="media-body">
                                                                        <h6 class="media-heading mb-0">{{$company->user->{'first_name_'.$l} }} {{$company->user->{'last_name_'.$l} }}</h6>
                                                                        <span class="font-small-2">{{$company->user->{'title_'.$l} }}</span>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @foreach(\App\User::whereIn('id', $company->finals($cstep->id) )->get() as $judge)
                                                            <div class="chip mr-1">
                                                                <div class="chip-body">
                                                                    <div class="avatar">
                                                                        <img class="img-fluid" src="/191014/{{$judge->img_url??'users/avatar.jpg'}}" alt="click to view" height="20" width="20">
                                                                    </div>
                                                                    <span class="chip-text">{{$judge->{'first_name_'.$l} .' '. $judge->{'last_name_'.$l} }}</span>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @if(!$company->fsession($cstep->id))
                                                                {{__('cycles.Add Judges first')}}
                                                             @elseif($company->fsession($cstep->id)->join_url)
                                                                 <a href="{{$company->fsession($cstep->id)->start_url}}" target="_blank">
                                                                    <button title="Start Meeting" type="button" class="btn btn-icon rounded-circle btn-light-success">
                                                                        <i class="bx bx-slider-alt"></i></button></a>
                                                                <a href="{{$company->fsession($cstep->id)->join_url}}" target="_blank">
                                                                    <button title="Join only" type="button" class="btn btn-icon rounded-circle btn-light-primary">
                                                                        <i class="bx bx-user"></i></button></a>
                                                            @else
                                                                    <button title="Add meeting" onclick="addzoom({{$company->id}})" type="button" class="btn btn-icon rounded-circle btn-light-secondary">
                                                                        <i class="bx bx-plus"></i></button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <hr>
                                        <div class="checkbox m-2">
                                            <input type='checkbox' id="checkAll" class="checkbox-input">
                                            <label for="checkAll">
                                                {{__('cycles.Select All')}}
                                            </label>
                                        </div>
                                </div>
                            </div>
                            </form>
                        </div>
    </div>
        @endif
    </section>

            </div>
        </div>
    </div>
    <!-- END: Content-->
<!--Screening form Modal -->
@if(isset($cstep))
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
                    <input type="hidden" name="sid" value="{{$cstep->id}}">
                    <input type="hidden" name="type" value="8">
                    <br>
                    <label>{{__('cycles.Title')}}: </label>
                    <div class="form-group">
                        <input value="{{$cstep->title}}" name='title' type="text" placeholder="Title" class="form-control" required>
                    </div>
                    <label>{{__('cycles.from')}}: </label>
                    <div class="form-group">
                        <input value="{{$cstep->from->format('Y-m-d')}}" name='fromDate' type="text" class="form-control date" required>
                    </div>
                    <label>{{__('cycles.to')}}: </label>
                    <div class="form-group">
                        <input value="{{$cstep->to->format('Y-m-d')}}" name='toDate' type="text" class="form-control date" required>
                    </div>
                    <label>{{__('cycles.Description')}}: </label>
                    <div class="form-group mb-0">
                        <textarea  name='description' placeholder="Description" class="form-control">{{$cstep->description}}</textarea>
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
<!-- create meeting -->
<div class="modal fade text-left" id="addzoom" tabindex="-1" role="dialog" aria-labelledby="addzoom" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" action="/admin/final/addzoom" enctype="multipart/form-data" autocomplete="off">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title white">{{__('cycles.Add new zoom session')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <p class="text-danger">{{__('cycles.Before submit review')}}.</p>
                    <input type="hidden" name="step" value="{{$cstep->id}}" id="sid">
                    <input type="hidden" name="company" value="0" id="cid">
                    <div class="form-group" id="showdates">
                        <label>{{__('cycles.Date/Time')}}:</label>
                        <input class='width-200 form-control' type="text" id="date" name="date" value="" required>
                    </div>
                    <div class="form-group">
                        <label>{{__('cycles.Meeting period')}}:</label>
                        <select name="period" class="select form-control">
                            <option value="30">30 {{__('cycles.Minutes')}}</option>
                            <option value="60" selected>1 {{__('cycles.Hour')}}</option>
                            <option value="120">2 {{__('cycles.Hours')}}</option>
                            <option value="180">3 {{__('cycles.Hours')}}</option>
                            <option value="240">4 {{__('cycles.Hours')}}</option>
                            <option value="300">5 {{__('cycles.Hours')}}</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary ml-1" >
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">{{__('cycles.Submit')}}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@stop
@section('pagescripts')
    <script src="/js/jquery.datetimepicker.full.min.js"></script>
    <script>
        $('.date').datetimepicker({timepicker:false,format:'Y-m-d'});
        $('#date').datetimepicker({timepicker:true,format:'Y-m-d H:i'});
        function DoChange(set) {
            switch (set) {
                case 1:
                    $('#stepForm').modal('show');
                    break;
                case 2:
                    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                    if (confirm('{{__('cycles.sure delete step')}}'))
                    {
                        $.ajax({
                            type: "POST", url: "/admin/cycles/modify",
                            data: {"stepid": {{$cstep->id??0}}, "type" : 6,},
                            success: function (response) {
                                console.log(response);
                                location.href = '/admin/final';
                            },
                            error: function (error) {
                                console.log(error);
                                alert("Error Occurred, Try again!");
                            }
                        });
                    }
            }
        }
        $('#checkAll').click(function () {
            $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
        });
        function addzoom(company) {
            $('#cid').val(company);
            $('#addzoom').modal('show');
        }
    </script>
@stop