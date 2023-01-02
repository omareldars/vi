@extends('layouts.admin')
@section('style')
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/tables/datatable/datatables.min.css">
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
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('cycles.Mentorship requests')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
									<li class="breadcrumb-item active">{{__('cycles.New requests')}}
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
                </section>
    <section class="row">
    <div class="col-xl-12 col-md-12 col-sm-12">
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                @if (Request()->show)
                    <a href="/admin/mentorship/sessions" class="btn btn-primary glow width-200">{{__('cycles.New requests only')}}</a>
                @else
                    <a href="/admin/mentorship/sessions?show=all" class="btn btn-primary glow width-200">{{__('cycles.All requests')}}</a>
                    <a href="/admin/mentorship/sessions?show=approved" class="btn btn-success glow width-200">{{__('cycles.approved requests')}}</a>
                @endif
            </div>
        </div>
            <div class="card-body">
            <div class="card-text">
                <div class="table-responsive">
                    <table class="table mb-0" id="userstable">
                        <thead class="thead-dark">
                        <tr>
                            <th>{{__('cycles.Company')}}</th>
                            <th>{{__('cycles.User/Title')}}</th>
                            <th>{{__('cycles.Mentor')}}</th>
                            <th>{{__('cycles.Rate/Comment')}}</th>
                            <th>{{__('cycles.Date/Time')}}</th>
                            <th>{{__('cycles.Approved')}}</th>
                            <th>{{__('cycles.Done')}}</th>
                            <th>{{__('cycles.Actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sessions as $session)
                            <tr>
                                <td>
                                    <div class="media align-items-center">
                                        <a class="media-left mr-50" href="/admin/companyProfile/{{$session->user->company->id}}">
                                            <img src="/191014/{{$session->user->company->logo??'../app-assets/images/logo_placeholder.png'}}" alt="avatar" class="rounded-circle" height="40" width="40">
                                        </a>
                                        <a href="/admin/companyProfile/{{$session->user->company->id}}">
                                            <div class="media align-items-center">
                                                {{$session->user->company->{'name_'.$l} }}
                                            </div>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="media align-items-center">
                                        <a class="media-left mr-50" href="/admin/users/{{$session->user->company->user->id}}/edit">
                                            <img src="/191014/{{$session->user->img_url??'../images/placeholder.jpg'}}" alt="avatar" class="rounded-circle" height="40" width="40">
                                        </a>
                                        <a href="/admin/users/{{$session->user_id}}/edit">
                                            <div class="media-body">
                                                <h6 class="media-heading mb-0">{{$session->user->{'first_name_'.$l} }} {{$session->user->{'last_name_'.$l} }}</h6>
                                                <span class="font-small-2">{{$session->user->{'title_'.$l} }}</span>
                                            </div>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div style="cursor: pointer;" class="chip mr-1" onclick="mentor({{$session->mentor_id}},'{{$session->mentor->{'first_name_'.$l} .' '. $session->mentor->{'last_name_'.$l} }}','{{$session->mentor->mrating()}}')">
                                        <div class="chip-body">
                                            <div class="avatar">
                                                <img class="img-fluid" src="/191014/{{$session->mentor->img_url??'users/avatar.jpg'}}" alt="Mentor photo" height="20" width="20">
                                            </div>
                                    <span class="chip-text">
{{$session->mentor->{'first_name_'.$l} .' '. $session->mentor->{'last_name_'.$l} }}
                                    </span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <small>{!!  $session->rate_comment?
str_repeat('<i class="bx bxs-star" style="color: #fc960f;"></i>',$session->rating).
'<br>'.$session->rate_comment:$session->comment  !!}</small>
                                </td>
                                <td>
                                    {{$session->zoom_date}}
                                    <br>({{$session->period}}M)
                                </td>
                                <td>
                                    <div class="media align-items-center">
                                        {!!  __($session->approved) ??'<span class="warning">'.__('Waiting').'</span>'  !!}
                                    </div>
                                </td>
                                <td>
                                    {{$session->done?__('Yes'):__('No')}}
                                </td>
                                <td>
                                  @if(!$session->approved)
                                    <button title="Approve" onclick="approve({{$session->id}},'Yes')" type="button" class="btn btn-icon rounded-circle btn-light-success">
                                        <i class="bx bx-check-square"></i></button>
                                    <button title="Dispprove" onclick="approve({{$session->id}}, 'No')" type="button" class="btn btn-icon rounded-circle btn-light-danger">
                                        <i class="bx bxs-x-square"></i></button>
                                    <button title="Edit" onclick="edit({{$session->id}})" type="button" class="btn btn-icon rounded-circle btn-light-primary">
                                        <i class="bx bxs-edit-alt"></i></button>
                                        @endif
                                  @if($session->join_url)
                                  <a href="{{$session->start_url}}" target="_blank">
                                  	<button title="Start Meeting" type="button" class="btn btn-icon rounded-circle btn-light-success">
                                        <i class="bx bx-slider-alt"></i></button></a>
                                  <a href="{{$session->join_url}}" target="_blank">
                                    <button title="Join only" type="button" class="btn btn-icon rounded-circle btn-light-primary">
                                        <i class="bx bx-user"></i></button></a>
                                  @endif
                                  @if($session->fileurl)
                                            <a href="/admin/private/{{$session->fileurl}}" target="_blank" title="Download attched" class="btn btn-icon rounded-circle btn-light-primary">
                                                    <i class="bx bx-download"></i></a>
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
        <div class="col-xl-12 col-md-12 col-sm-12">
            <div class="card">
        <div id="mentors" style="display: none;">
            <div class="card-header">
                <h4 class="card-title"><b id="name"></b> {{__('cycles.Schedule')}}: </h4>
            </div>
            <div class="table-responsive">
                <table class="table" id="mentorstable">
                </table>
            </div>
        </div>
            </div>
        </div>


    </section>
            </div>
        </div>
    </div>
    <!-- END: Content-->
<div class="modal fade text-left" id="ModifyRequest" tabindex="-1" role="dialog" aria-labelledby="sendrequest" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" action="/admin/mentorship/modify" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('cycles.Modify mentorship session')}} </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                  	<input type="hidden" name="id" value="0" id="sid">
                  	<input type="hidden" name="mentorid" value="0" id="mentorid">
                  	<input type="hidden" name="userid" value="0" id="userid">
                    <div class="form-group" id="showdates">
                        <label>{{__('cycles.Date/Time')}}:</label>
                        <input class='date width-200 form-control' type="text" id="sdate" name="date" value="" required>
                    </div>
                    <div class="form-group">
                        <label>{{__('cycles.Meeting period')}}:</label>
                        <select name="period" class="select form-control" id="period">
                            <option value="30">30 {{__('cycles.Minutes')}}</option>
                            <option value="60">1 {{__('cycles.Hour')}}</option>
                            <option value="120">2 {{__('cycles.Hours')}}</option>
                            <option value="180">3 {{__('cycles.Hours')}}</option>
                            <option value="240">4 {{__('cycles.Hours')}}</option>
                            <option value="300">5 {{__('cycles.Hours')}}</option>
                        </select>
                    </div>
                    <label>{{__('cycles.Add a session note')}}:</label>
                    <div class="form-group">
                            <textarea class="form-control" id="notes" name='notes' rows="4"
                                      placeholder="{{__('cycles.Write your note here')}}" ></textarea>
                    </div>
                 	<div class="checkbox">
                  	<input type="checkbox" class="checkbox-input" id="checkbox1" name="approved">
                  	<label for="checkbox1">{{__('cycles.Approve & notify users')}}.</label>
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
    <script>
        $(document).ready(function() {
            $('.table').DataTable({
                "responsive": true, "searching": true, "lengthChange": false, "paging": true, "bInfo": false,
                "columnDefs": [
                    {"orderable": false, "targets":  [7]},
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
            function edit(id) {
                    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                    $.ajax({
                        type: "POST", url: "/admin/mentorship/session",
                        data: {"id": id,},
                        success: function (response) {
                        $('#sid').val(id);
                        $('#mentorid').val(response.mentor_id);
                        $('#userid').val(response.user_id);  
                        $('#sdate').val(response.zoom_date);
                        $('#period').val(response.period);
                        $('#notes').val(response.notes);
                        $('#ModifyRequest').modal('show');  
                        },
                        error: function (error) {
                            console.log(error);
                            alert("Error Occurred, Try again!");
                        }});
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
                                    break;}
                            let num = i+1;
                            $('<tr>').html("<td>" + num + "</td><td>" + days + "</td><td>"+ time +"</td><td>"+ note +"</td>").appendTo('#mentorstable');
                        });
                        } else {
                            $('<tr>').html("<td colspan='5'> No records saved.</td>").appendTo('#mentorstable');
                    }
                        $('#mentors').show();
                    },
                    error: function (error) {
                        console.log(error);
                        alert("Error Occurred, Try again!");
                    }});
            }
            function approve(id,stat){
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                $.ajax({
                    type: "POST", url: "/admin/mentors/modify",
                    data: {"id": id,"stat": stat,'rtype':6,},
                    success: function (response) {
                        location.reload();
                    },
                    error: function (error) {
                        console.log(error);
                        alert("Error Occurred, Try again!");
                    }});
            }
    </script>
@stop