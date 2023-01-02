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
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('cycles.Training results')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
									<li class="breadcrumb-item active">{{__('cycles.Show training results')}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<div class="content-body">
    @if (count($sessions)>0)
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
                                    <h4 class="card-title">{{__('cycles.Portal training results')}}</h4>
                                </div>
                                <hr>
                                <div class="card-body">
                                    <span>{{__('cycles.Select training from list')}}</span>
                                    <fieldset class="input-group">
                                            <select id="cstep" class="select form-control" onchange="window.open('/admin/training/results/'+this.options[this.selectedIndex].value,'_self');">
                                                @foreach($sessions as $step)
                                                    <option value="{{$step->id}}" {{$step->id==$id?'selected':''}}>{{$step->title}} - {{$step->step->title}} ({{__('cycles.Cycle')}} "{{$step->step->cycle->title}}" - {{__('cycles.Start')}} {{$step->step->from->format('d-m')}})</option>
                                                @endforeach
                                            </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary" onclick="window.location.href='/admin/cycles/{{$csession->step->cycle->id}}/registered'">
                                                <i class="bx bxs-user"></i> <span class="align-middle ml-25">{{__('cycles.Users')}}</span>
                                            </button>
                                    <a class="btn btn-success" href="/admin/cycles/{{$csession->step->cycle->id}}">
                                         <i class="bx bx-pencil"></i> <span class="align-middle ml-25">{{__('cycles.Cycle')}}</span>
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
            <h4 class="card-title success">{{$step->title}} - {{$csession->step->title}} <small class="text-muted"> {{__('cycles.from')}} {{$csession->step->from->format('d-m')}} {{__('cycles.to')}} {{$csession->step->to->format('d-m-Y')}}</small></h4>
            <p>{{$csession->step->description}}</p>
        </div>
        <hr style="margin:-10px 0 5px 0;">
        <div class="card-body">

                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="thead-dark">
                        <tr>
                            <th>{{__('cycles.Company')}}</th>
                            <th>{{__('cycles.User/Title')}}</th>
                            <th>{{__('cycles.Completed')}}</th>
                            <th>{{__('cycles.Current Step')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $companies = \App\Company::where('step',$csession->step_id)->get();
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
                                @php
                                $cc = \App\TrainingCompleted::where('user_id',$company->user->id)->where('course_id',$csession->location)->count();
                                $per = $contents? $cc/$contents*100 :'0';
                                @endphp
                                <td>
                                    <span class="badge badge-light-{{$per>50?'success':'danger'}}">
                                {{(int)$per}}
                                        %</span>
                                </td>
                                <td>
                                    <div class="media align-items-center">
                                        <select id="cstep" class="select form-control" onchange="changestep({{$company->id}},this.options[this.selectedIndex].value)">
                                            <option value="0" >Disapprove</option>
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
    @else
        <section class="row">
        <div class="col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title danger">{{__('cycles.Error')}}</h4>
                </div>
                <hr style="margin:-10px 0 5px 0;">
                <div class="card-body">
                    {{__('cycles.No training courses into cycles')}}, <a href="/admin/cycles"> {{__('cycles.Back to Manage cycles')}}</a>.
                </div>
            </div>
        </div>
        </section>
    @endif
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
                "responsive": true, "searching": true, "lengthChange": false, "paging": true, "bInfo": false,
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
            });
        });
    </script>
    <script>
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
                        location.href = '/admin/training/results/{{$id}}';
                    },
                    error: function (error) {
                        console.log(error);
                        alert("Error Occurred, arrange failed");
                    }});
            } else {
                location.href = '/admin/training/results/{{$id}}';
            }}
    </script>
@stop