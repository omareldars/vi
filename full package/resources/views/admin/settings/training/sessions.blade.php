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
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('cycles.all online training steps')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
									<li class="breadcrumb-item active">{{__('cycles.view all')}}
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
            <div class="alert alert-{{session()->get('class')}} alert-dismissible mb-2" role="alert">
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
    </section>
    @if (count($steps)>0)
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-xl-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header" style="padding-bottom: 15px;">
                        <h4 class="card-title">{{__('cycles.Training Steps')}}</h4>
                    </div>
                    <hr>
                    <div class="card-body">
                        <span>{{__('cycles.Select Step')}}</span>
                        <fieldset class="input-group">
                            <select id="ccycle" class="select form-control" onchange="window.open('/admin/training/sessions/'+this.options[this.selectedIndex].value,'_self');">
                                @foreach($steps as $step)
                              	@php if($step->id==$id){$ccycle=$step->cycle->id;} @endphp
                                    <option value="{{$step->id}}" {{$step->id==$id?'selected':''}}>{{$step->title}} ({{$step->cycle->title}}-{{__('cycles.Start')." ". $step->cycle->start->format('d-m')}})</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary block" data-toggle="modal" data-target="#addsession">
                                    <i class="bx bx-plus-circle"></i> <span class="align-middle ml-25">{{__('cycles.Add new training')}}</span>
                                </button>
                              <a class="btn btn-success" href="/admin/cycles/{{$ccycle}}">
                                         <i class="bx bx-pencil"></i> <span class="align-middle ml-25">{{__('cycles.Cycle')}}</span>
                                    </a>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="row">
    <div class="col-xl-12 col-md-12 col-sm-12">
    <div class="card">
        <div class="card-header">
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
                            <th>{{__('cycles.Edit')}} | {{__('cycles.Delete')}}</th>
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
                                <a href="{{$session->start_url}}" target="_blank">
                                        <button title="Start Meeting" type="button" class="btn btn-icon rounded-circle btn-light-success">
                                            <i class="bx bx-slider-alt"></i></button></a> |
                                <a href="{{$session->join_url}}" target="_blank">
                                        <button title="Join only" type="button" class="btn btn-icon rounded-circle btn-light-primary">
                                            <i class="bx bx-user"></i></button></a>
                                    @elseif ($session->type=='offline')
                                        <b>{{__('cycles.trainer name')}}:</b> {{$session->trainer_name}}<br><b>{{__('cycles.training location')}}:</b> {{$session->location}} <br>
                                    @else
                                        <a href="/admin/training/all/{{$session->location}}">{{__('cycles.Display course contents')}} </a>
                                    @endif

                                </td>
                                <td> <button title="Delete" onclick="editme({{$session->id}})" type="button" class="btn btn-icon rounded-circle btn-light-primary">
                                        <i class="bx bx-edit"></i></button>&nbsp;
                                    <button title="Delete" onclick="deleteme({{$session->id}})" type="button" class="btn btn-icon rounded-circle btn-light-danger">
                                        <i class="bx bx-trash"></i></button>

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
    @else
        <section class="row">
        <div class="col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title danger">{{ __('cycles.Error') }}</h4>
                </div>
                <hr style="margin:-10px 0 5px 0;">
                <div class="card-body">
                    {{__('cycles.No training sessions into cycles') }}, <a href="/admin/cycles">{{__('cycles.Back to Manage cycles')}}</a>.
                </div>
            </div>
        </div>
        </section>
    @endif
            </div>
        </div>
    </div>
    <!-- END: Content-->
<div class="modal fade text-left" id="addsession" tabindex="-1" role="dialog" aria-labelledby="addsession" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="/admin/training/addsession" enctype="multipart/form-data" autocomplete="off">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('cycles.Add new training session')}} </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                  	<input type="hidden" name="step_id" value="{{$id}}" id="id">
                    <div class="form-group" id="ctype">
                        <label>{{__('cycles.Type')}}:</label>
                        <select name="type" class="select form-control" required onchange="tchange(this.options[this.selectedIndex].value)">
                            <option value="online">{{__('cycles.online')}}</option>
                            <option value="sessions">{{__('cycles.sessions')}}</option>
                            <option value="offline">{{__('cycles.offline')}}</option>
                        </select>
                    </div>
                    <div class="form-group" id="online">
                        <label>{{__('cycles.select online')}}:</label>
                        <select name="online" class="select form-control" required id="conline">
                            @if (!$online)
                                <option>{{__('cycles.No saved training courses')}}</option>
                            @endif
                            @foreach($online as $tr)
                                <option value="{{$tr->id}}">{{$tr->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <label>{{__('cycles.Session Title')}}</label>
                    <div class="form-group">
                        <input id="title" name="title" type="text" placeholder="{{__('cycles.Session Title')}}" class="form-control" required>
                    </div>
                    <label>{{__('cycles.Add a description')}}:</label>
                    <div class="form-group">
                            <textarea class="form-control" id="dsc" name='dsc' rows="2"
                                      placeholder="{{__('cycles.Write your description here')}}." ></textarea>
                    </div>
                        <div class="form-group">
                            <label>{{__('cycles.Date/Time')}}</label>
                            <input id="datetime" name="datetime" type="text" placeholder="{{__('cycles.Date/Time')}}" class="form-control" required>
                        </div>
                    <div class="form-group" style="display: none;" id="enddatetime">
                        <label>{{__('cycles.End')}}</label>
                        <input id="enddate" name="enddatetime" type="text" placeholder="{{__('cycles.Date/Time')}}" class="form-control" >
                    </div>
                    <div class="form-group" style="display: none;" id="sessions">
                        <label>{{__('cycles.Session duration')}}:</label>
                        <select name="duration" class="select form-control" required>
                            <option value="30">30 {{__('cycles.Minutes')}}</option>
                            <option value="60" selected>1 {{__('cycles.Hour')}}</option>
                            <option value="120">2 {{__('cycles.Hours')}}</option>
                            <option value="180">3 {{__('cycles.Hours')}}</option>
                            <option value="240">4 {{__('cycles.Hours')}}</option>
                            <option value="300">5 {{__('cycles.Hours')}}</option>
                        </select>
                    </div>
                    <div class="form-group" id="trainer" style="display: none;">
                        <label>{{__('cycles.trainer name')}}</label>
                        <input name="trainer_name" type="text" placeholder="{{__('cycles.trainer name')}}" class="form-control" >
                    </div>
                    <div class="form-group" id="location" style="display: none;">
                        <label>{{__('cycles.training location')}}</label>
                        <input name="location" type="text" placeholder="{{__('cycles.training location')}}" class="form-control" >
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


<div class="modal fade text-left" id="editsession" tabindex="-1" role="dialog" aria-labelledby="editsession" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="/admin/training/editsession" enctype="multipart/form-data" autocomplete="off">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('cycles.Edit training session')}} </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="sid" id="sid">
                    <input type="hidden" name="stype" id="stype">
                    <div class="form-group" id="sonline">
                        <label>{{__('cycles.select online')}}:</label>
                        <select name="online" class="select form-control" required id="eonline">
                            @foreach($online as $tr)
                                <option value="{{$tr->id}}">{{$tr->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <label>{{__('cycles.Session Title')}}</label>
                    <div class="form-group">
                        <input id="etitle" name="title" type="text" placeholder="{{__('cycles.Session Title')}}" class="form-control" required>
                    </div>
                    <label>{{__('cycles.Add a description')}}:</label>
                    <div class="form-group">
                            <textarea class="form-control" id="edsc" name='dsc' rows="2"
                                      placeholder="{{__('cycles.Write your description here')}}." ></textarea>
                    </div>
                    <div class="form-group">
                        <label>{{__('cycles.Date/Time')}}</label>
                        <input id="edatetime" name="datetime" type="text" placeholder="{{__('cycles.Date/Time')}}" class="form-control" required>
                    </div>
                    <div class="form-group" style="display: none;" id="senddatetime">
                        <label>{{__('cycles.End')}}</label>
                        <input id="eenddate" name="enddatetime" type="text" placeholder="{{__('cycles.Date/Time')}}" class="form-control" >
                    </div>
                    <div class="form-group" style="display: none;" id="ssessions">
                        <label>{{__('cycles.Session duration')}}:</label>
                        <select id="eduration" name="duration" class="select form-control" required>
                            <option value="30">30 {{__('cycles.Minutes')}}</option>
                            <option value="60">1 {{__('cycles.Hour')}}</option>
                            <option value="120">2 {{__('cycles.Hours')}}</option>
                            <option value="180">3 {{__('cycles.Hours')}}</option>
                            <option value="240">4 {{__('cycles.Hours')}}</option>
                            <option value="300">5 {{__('cycles.Hours')}}</option>
                        </select>
                    </div>
                    <div class="form-group" id="strainer" style="display: none;">
                        <label>{{__('cycles.trainer name')}}</label>
                        <input id="etrainer" name="trainer_name" type="text" placeholder="{{__('cycles.trainer name')}}" class="form-control" >
                    </div>
                    <div class="form-group" id="slocation" style="display: none;">
                        <label>{{__('cycles.training location')}}</label>
                        <input id="elocation" name="location" type="text" placeholder="{{__('cycles.training location')}}" class="form-control" >
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
            $('#trainingtable').DataTable({
                "responsive": true, "searching": true, "lengthChange": false, "paging": true, "bInfo": false,
                "columnDefs": [
                    {"orderable": false, "targets":  [6]},
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
            $('#datetime,#enddate,#edatetime,#eenddate').datetimepicker({timepicker:true,format:'Y-m-d H:i'});
            function deleteme(id) {
                let url = '/admin/training/delsession/'+id;
                let token = '{{ csrf_token() }}';
                Swal.fire({
                    title: "{{__('admin.SureDelete')}}",
                    text: "{{__('admin.Recover')}}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "{{__('admin.DYes')}}",
                    cancelButtonText: "{{__('admin.No')}}!",
                })
                    .then((result) => {
                        if (result.value) {
                            $.post(url, {'_method':'POST' , '_token':token},
                                function(response){
                                    Swal.fire(
                                        '{{__('admin.Deleted')}}!',
                                        '{{__('admin.Course Deleted')}}.',
                                        'success');
                                    window.location.href='/admin/training/sessions/{{$id}}';
                                }).fail(function(error) {console.log(error);});
                        }else{console.log('Canceled')}});    }

                function tchange(training) {
                if (training==='offline') {
                    $('#online').hide();$('#enddatetime').show();$('#sessions').hide();$('#trainer').show();$('#location').show();
                } else if (training==='sessions') {
                    $('#online').hide();$('#enddatetime').hide();$('#sessions').show();$('#trainer').show();$('#location').hide();
                } else {
                    $('#online').show();$('#enddatetime').hide();$('#sessions').hide();$('#trainer').hide();$('#location').hide();
                }
                    }

                function editme(training) {
                    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                    $.ajax({
                        type: "POST", url: "/admin/training/session", data: {"id": training,},
                        success: function (response) {
                            let type = response.type;
                            $('#ctype').hide();
                            $('#etitle').val(response.title);
                            $('#edsc').val(response.dsc);
                            $('#edatetime').val(response.datetime);
                            $('#sid').val(training);
                            $('#stype').val(type);
                            if (type === 'offline') {
                                $('#sonline').hide();
                                $('#senddatetime').show();
                                $('#ssessions').hide();
                                $('#strainer').show();
                                $('#slocation').show();
                                $('#eenddate').val(response.enddatetime);
                                $('#elocation').val(response.location);
                                $('#etrainer').val(response.trainer_name);
                            } else if (type === 'sessions') {
                                $('#sonline').hide();
                                $('#senddatetime').hide();
                                $('#ssessions').show();
                                $('#strainer').show();
                                $('#slocation').hide();
                                $('#etrainer').val(response.trainer_name);
                                $('#eduration').val(response.duration);
                                $('#elocation').val('');
                            } else {
                                $('#sonline').show();
                                $('#senddatetime').hide();
                                $('#ssessions').hide();
                                $('#strainer').hide();
                                $('#slocation').hide();
                                $('#eonline').val(response.location);
                                $('#etrainer').val('');
                            }
                            $('#editsession').modal('show');
                        },
                        error: function (error) {
                            console.log(error);
                            alert("Error Occurred, Try again!");
                        }
                    });
                }
    </script>
@stop