@extends('layouts.admin')
@section('style')
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/tables/datatable/datatables.min.css">
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
                                            <select id="ccycle" class="select form-control" onchange="window.open('/admin/cycles/'+this.options[this.selectedIndex].value+'/registered','_self');">
                                                @foreach($cycles as $cycle)
                                                    <option value="{{$cycle->id}}" {{$cycle->id==$id?'selected':''}}>{{$cycle->title}} ({{__('cycles.Start')}} {{$cycle->start->format('d-m')}})</option>
                                                @endforeach
                                            </select>
                                        <div class="input-group-append">
                                    <button class="btn btn-secondary" onclick="window.location.href='/admin/cycles/{{$id}}'">
                                                <i class="bx bx-spreadsheet"></i> <span class="align-middle ml-25">{{__('cycles.steps')}}</span>
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
                                   <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
    <section class="row">
        <div class="col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title primary">{{__('cycles.Cycle Registered Users')}}</h4>
                </div>
                <hr style="margin:-10px 0 5px 0;">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="thead-dark">
                            <tr>
                                <th>{{__('cycles.Company')}}</th>
                                <th>{{__('cycles.User/Title')}}</th>
                                <th>{{__('cycles.Mobile')}}</th>
                                <th>{{__('cycles.E-Mail')}}</th>
                                <th>{{__('cycles.Current Step')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $companies = \App\Company::where('cycle',$id)->get();
                            @endphp
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
                                        {{$company->user->phone}}
                                    </td>
                                    <td>
                                        {{$company->user->email}}
                                    </td>
                                    <td>
                                        <div class="media align-items-center">
                                            <select id="cstep" class="select form-control" onchange="changestep({{$company->id}},this.options[this.selectedIndex].value)">
                                                <option value="0" >{{__('cycles.Disapprove')}}</option>
                                                @foreach(\App\Step::where('cycle_id',$company->cycle)->orderBy('arr')->get() as $step)
                                                    <option value="{{$step->id}}" {{$step->id==$company->step?'selected':''}}>{{$step->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
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

@stop
@section('pagescripts')
        <script type="text/javascript">
            $(document).ready(function() {
                $('.table').DataTable({
                    "responsive": true,
                    "searching": true,
                    "lengthChange": false,
                    "paging": true,
                    "bInfo": false,
                    "columnDefs": [
                        {"orderable": false, "targets":  [4]},
                    ],
                    @if ($l=='ar')
                    "language": {
                        "sEmptyTable":     "ليست هناك بيانات متاحة في الجدول",
                        "sLoadingRecords": "جارٍ التحميل...",
                        "sProcessing":   "جارٍ التحميل...",
                        "sLengthMenu":   "أظهر _MENU_ مدخلات",
                        "sZeroRecords":  "لم يعثر على أية سجلات",
                        "sInfo":         "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                        "sInfoEmpty":    "يعرض 0 إلى 0 من أصل 0 سجل",
                        "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                        "sInfoPostFix":  "",
                        "sSearch":       "ابحث:",
                        "sUrl":          "",
                        "oPaginate": {
                            "sFirst":    "الأول",
                            "sPrevious": "السابق",
                            "sNext":     "التالي",
                            "sLast":     "الأخير"
                        },
                        "oAria": {
                            "sSortAscending":  ": تفعيل لترتيب العمود تصاعدياً",
                            "sSortDescending": ": تفعيل لترتيب العمود تنازلياً"
                        }
                    }
                    @endif
                } );
            });
        </script>
    <script src="/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>
    <script>

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
                    if (confirm('{{__('cycles.sure delete cycle')}}'))
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
                        }});}
                    break;
                case 4:
                    let step = $('#StepSelect').find(":selected").val();
                    let steptxt = $('#StepSelect').find(":selected").text();
                    let menu = $('#menu'+step);
                    $('#menu1,#menu2,#menu5').hide();
                    if (menu !== null) {menu.show();}
                    $('#stype').val(step);
                    $('#formtitle').text(steptxt);
                    $('#stepForm').modal('show');
                    break;
            }}

        function changestep(company,step){
            if (confirm("{{__('cycles.sure change step')}}")) {
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                $.ajax({
                    type: "POST", url: "/admin/screening/changestep",
                    data: {
                        "company": company,
                        "step" : step,
                    },
                    success: function (response) {
                        console.log(response);
                        location.href = '/admin/cycles/{{$id}}/registered';
                    },
                    error: function (error) {
                        console.log(error);
                        alert("Error Occurred, arrange failed");
                    }});
            } else {
                location.reload();
            }}
    </script>

@stop
