@extends('layouts.admin')
@section('style')
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.min.css">
    <style>
        #mentorstable tr td {
            padding:0.15rem 2rem;
        }
    </style>
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
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('cycles.Mentorship sessions')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
									<li class="breadcrumb-item active">{{__('cycles.Manage')}}
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
                                    <h4 class="card-title">{{__('cycles.Portal Cycles Users')}}</h4>
                                </div>
                                <hr>
                                <div class="card-body">
                                    <span>{{__('cycles.Select cycle from list')}}</span>
                                    <fieldset class="input-group">
                                            <select id="cstep" class="select form-control" onchange="window.open('/admin/mentorship/view/'+this.options[this.selectedIndex].value,'_self');">
                                                @foreach(\App\Cycle::get() as $cycle)
                                                    <option value="{{$cycle->id}}" {{$cycle->id==$id?'selected':''}}>{{$cycle->title}} ({{__('cycles.from')}} {{$cycle->start->format('d-M')}} {{__('cycles.to')}} {{$cycle->end->format('d-M-Y')}})</option>
                                                @endforeach
                                                @if(!$id)
                                                    <option>  {{__('cycles.No records saved')}} - ({{__('cycles.Manage Cycle')}}).</option>
                                                @endif
                                            </select>
                                        <div class="input-group-append">
                                    <a class="btn btn-success" href="/admin/cycles/{{$id}}">
                                         <i class="bx bx-pencil"></i> <span class="align-middle ml-25">{{__('cycles.Manage Cycle')}}</span>
                                    </a>
                                    <a class="btn btn-primary" href="/admin/mentorship/assign/{{$id}}">
                                                <i class="bx bx-user"></i> <span class="align-middle ml-25">{{__('cycles.Mentors list')}}</span>
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
            <h4 class="card-title">{{__('cycles.Mentors')}}:
                @if (count($mentors)==0)
<span class="font-small-3">
                    {{__('cycles.Add mentors to this cycle from')}} <a href="/admin/mentorship/assign/{{$id}}">{{__('cycles.here')}} </a>.</span>
                @endif
                @foreach($mentors as $mentor)
                    <div class="chip mr-1">
                        <div class="chip-body">
                            <div class="avatar">
                                <img class="img-fluid" src="/191014/{{$mentor->user->img_url??'users/avatar.jpg'}}" alt="click to view" height="20" width="20">
                            </div>
                            <span class="chip-text">
                                <label for="mentor{{$mentor->id}}">
{{$mentor->user->id}}-{{$thementor = $mentor->user->{'first_name_'.$l} .' '. $mentor->user->{'last_name_'.$l} }}
                                </label>
                            <input type="radio" value="{{$mentor->user_id}}" id="mentor{{$mentor->user_id}}" name="mentor" onclick="mentor({{$mentor->user_id}},'{{$thementor}}','{{$mentor->mrating()}}')" >
                            </span>
                        </div>

                    </div>
                <span>
                    </span>
                @endforeach</h4>

        </div>
            <div class="card-body">
                <div id="mentors" style="display: none;" class="mb-75">
                <hr style="margin:-20px 0 20px 0;">
                <h4 class="card-title"><b id="name"></b> {{__('cycles.Schedule')}}: </h4>
                <div class="table-responsive">
                    <table class="table" id="mentorstable">
                    </table>
                </div>
                </div>
                <h4 class="card-title"><b>{{__('cycles.Cycle registered users')}}:</b></h4>
            <hr style="margin:-10px 0 -10px 0;">
            <div class="card-text">
                <div class="table-responsive">
                    <table class="table mb-0" id="userstable">
                        <thead class="thead-dark">
                        <tr>
                            <th>{{__('cycles.Company')}}</th>
                            <th>{{__('cycles.User/Title')}}</th>
                            <th>{{__('cycles.Session')}}</th>
                            <th>{{__('cycles.Current Step')}}</th>
                            <th>{{__('cycles.Actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($companies as $company)
                            <tr>
                                <td>
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
                                    @if($company->user->mentorship)
                                     @foreach($company->user->mentorship as $session)
                                      @if ($session->approved=='Yes')
                                                M#{{$session->mentor_id}} ({{$session->zoom_date->format('d-M-Y')}}) <br>
                                      @endif
                                     @endforeach
                                        @endif
                                </td>
                                <td>
                                    <div class="media align-items-center">
                                        {{$company->stepdata->title}}
                                    </div>
                                </td>
                                <td>
                                    <button onclick="add({{$company->user->id}})" type="button" class="btn btn-icon rounded-circle btn-light-success">
                                        <i class="bx bx-plus"></i></button>
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
            </div>
        </div>
    </div>
    <!-- END: Content-->
<div class="modal fade text-left" id="SendRequest" tabindex="-1" role="dialog" aria-labelledby="sendrequest" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" action="/admin/mentorship/add" enctype="multipart/form-data" autocomplete="off">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('cycles.Add new mentorship session')}} <span id="rname"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="mentorid" value="0" id="mentorid">
                    <input type="hidden" name="userid" value="0" id="userid">
                    <div class="form-group" id="showdates">
                        <label>{{__('cycles.Date/Time')}}:</label>
                        <input class='date width-200 form-control' type="text" id="date" name="date" value="" required>
                    </div>
                    <div class="form-group">
                        <label>{{__('cycles.Meeting period')}}:</label>
                        <select name="period" class="select form-control">
                                <option value="30">30 {{__('cycles.Minutes')}}</option>
                            <option value="60" selected>1 {{__('cycles.Hour')}}</option>
                            <option value="120">2 {{__('cycles.Hour')}}</option>
                            <option value="180">3 {{__('cycles.Hour')}}</option>
                            <option value="240">4 {{__('cycles.Hour')}}</option>
                            <option value="300">5 {{__('cycles.Hour')}}</option>
                        </select>
                    </div>
                    <label>{{__('cycles.Add a session note')}}:</label>
                    <div class="form-group">
                            <textarea class="form-control" id="notes" name='notes' rows="4"
                                      placeholder="{{__('cycles.Write your note here')}}." ></textarea>
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
@stop
@section('pagescripts')
    <script src="/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="/js/jquery.datetimepicker.full.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#userstable').DataTable({
                    "responsive": true, "searching": true, "lengthChange": false, "paging": true, "bInfo": false,
                    "columnDefs": [
                        {"orderable": false, "targets":  [2,4]},
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
                });
            });
        </script>
        <script>
            $('.date').datetimepicker({timepicker:true,format:'Y-m-d H:i'});
            function add(id) {
                let mentor = $('input[name="mentor"]:checked').val();
                if (mentor) {
                    $('#userid').val(id);
                    $('#mentorid').val(mentor);
                    $('#SendRequest').modal('show');
                } else {
                    alert("{{('cycles.Please select mentor first, and try again')}}!");
                }
            }
            function mentor(id,name,rating) {
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                $.ajax({
                    type: "POST", url: "/admin/mentors/modify",
                    data: {"id": id, "rtype": 5,},
                    success: function (response) {
                        $('#mentorstable tr').remove();
                        let rate = '<i class="bx bxs-star" style="color: #fc960f;"></i>';
                        $('<tr>').html(" <td><b>#</b></td> <td><b>Days</b></td> <td><b>Time</b></td> <td><b>Notes</b></td>").appendTo('#mentorstable');
                        $('#name').html(name + "<span>" + rate.repeat(rating) + "</span>");
                        if (response.length>0) {
                        $.each(response, function(i, item) {
                            let days = '';
                            let note = '';
                            let time = "From " + item.tfrom + " to " + item.tto;
                            let color = "primary";
                            if (item.notes) {note = item.notes;}
                            switch (item.type) {
                                case 'OneDay':
                                    days = item.dfrom;
                                    break;
                                case 'Weekly':
                                    days = 'Weekly (' + item.days + ')';
                                    break;
                                case 'WorkingDays':
                                    days = 'All working days';
                                    break;
                                case 'Period':
                                    days = 'from ' + item.dfrom + ' to ' + item.dto;
                                    break;
                                case 'Session':
                                    days = new Date(item.dfrom);
                                    time = 'From ' + days.toLocaleTimeString('pt-BR') + " (" + item.tfrom + "Minutes)";
                                    days = days.toLocaleDateString('pt-BR') + " Busy";
                                    color ="danger";
                                    break;}
                            let num = i+1;
                            $('<tr class="'+color+'">').html("<td>" + num + "</td><td>" + days + "</td><td>"+ time +"</td><td>"+ note +"</td>").appendTo('#mentorstable');
                        });
                        } else {
                            $('<tr class="warning">').html("<td colspan='5'> {{__('cycles.No records saved')}}.</td>").appendTo('#mentorstable');
                    }
                        $('#mentors').show();
                    },
                    error: function (error) {
                        console.log(error);
                        alert("Error Occurred, Try again!");
                    }});
            }
    </script>
@stop