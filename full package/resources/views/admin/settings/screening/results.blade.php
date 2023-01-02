@extends('layouts.admin')
@section('style')
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/tables/datatable/datatables.min.css">
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
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('cycles.Screening results')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
									<li class="breadcrumb-item active">{{__('cycles.show screening results')}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<div class="content-body">
    @if ($cstep)
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
                                    <h4 class="card-title">{{__('cycles.Screening results')}}</h4>
                                </div>
                                <hr>
                                <div class="card-body">
                                    <span>{{__('cycles.Select screening from list')}}</span>
                                    <fieldset class="input-group">
                                            <select id="cstep" class="select form-control" onchange="window.open('/admin/screening/results/'+this.options[this.selectedIndex].value,'_self');">
                                                @foreach($steps as $step)
                                                    <option value="{{$step->id}}" {{$step->id==$id?'selected':''}}>{{$step->title}} ({{__('cycles.Cycle')}} "{{$step->cycle->title}}" - {{__('cycles.Start')}} {{$step->from->format('d-m')}})</option>
                                                @endforeach
                                            </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary" onclick="window.location.href='/admin/cycles/{{$cstep->cycle_id}}/registered'">
                                                <i class="bx bxs-user"></i> <span class="align-middle ml-25">{{__('cycles.Users')}}</span>
                                            </button>
                                    <a class="btn btn-primary" href="/admin/{{$id}}/screening">
                                        <i class="bx bx-edit"></i> <span class="align-middle ml-25">{{__('cycles.Manage')}}</span>
                                    </a>
                                    <a class="btn btn-success" href="/admin/cycles/{{$cstep->cycle_id}}">
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
        @php
            $clist = [$cstep->id];
            if($form) {$clist = [$form->id,$cstep->id];}
            $companies = \App\Company::whereIn('step',$clist)->get();
        @endphp
    <section class="row">
    <div class="col-xl-12 col-md-12 col-sm-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title success">{{$cstep->title}} <small class="text-muted"> {{__('cycles.from')}} {{$cstep->from->format('d-m')}} {{__('cycles.to')}} {{$cstep->to->format('d-m-Y')}}</small></h4>
            <p>{{$cstep->description}}</p>
        </div>
        <hr style="margin:-10px 0 5px 0;">
        <div class="card-body">
            <div class="card-text">
                <dl class="row">
                    <dt class="col-sm-3 text-right">{{__('cycles.Cycle')}}</dt>
                    <dd class="col-sm-9">{{$cstep->cycle->title}} {{__('cycles.from')}} "{{$cstep->cycle->start->format('d-m')}} {{__('cycles.to')}} {{$cstep->cycle->end->format('d-m-Y')}}"</dd>
                </dl>
                <dl class="row">
                    <dt class="col-sm-3 text-right">{{__('cycles.Form title')}}</dt>
                    <dd class="col-sm-9">{!!$form->title??'<span class="danger">'. __('cycles.NoForm').'</span>'!!}</dd>
                </dl>
                <dl class="row">
                    <dt class="col-sm-3 text-right">{{__('cycles.Screening type')}}</dt>
                    <dd class="col-sm-9">
                        {{ __('cycles.'.$types[$cstep->data]) }}
                    </dd>
                </dl>
                <dl class="row">
                    <dt class="col-sm-3 text-right">{{__('cycles.Total registered')}}</dt>
                    <dd class="col-sm-9">{{$companies->count()}}</dd>
                </dl>
                <dl class="row">
                    <dt class="col-sm-3 text-right">{{__('cycles.Judges')}}</dt>
                    <dd class="col-sm-9">
                        @foreach($judges as $judge)
                            <div class="chip mr-1" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{$judge->phone}} {{$judge->email}}">
                                <div class="chip-body">
                                    <div class="avatar">
                                        <img class="img-fluid" src="/191014/{{$judge->img_url??'users/avatar.jpg'}}" alt="click to view" height="20" width="20">
                                    </div>
                                    <span class="chip-text">{{ $judge->{'first_name_'.$l} .' '. $judge->{'last_name_'.$l} }}
                                    </span>
                                </div>
                            </div>
                        @endforeach

                    </dd>
                </dl>
            </div>

            <div class="card border-light">
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="thead-dark">
                        <tr>
                            <th>{{__('cycles.Company')}}</th>
                            <th>{{__('cycles.User/Title')}}</th>
                            <th>{{__('cycles.Judges')}}</th>
                            <th>{{__('cycles.AVG degree')}}</th>
                            <th>{{__('cycles.Current Step')}}</th>
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
                                    @if($form->id)
                                    @foreach(\App\User::whereIn('id',$company->judges($company->id,$form->id))->get() as $judger)
                                        <div class="chip mr-1">
                                            <div class="chip-body">
                                                <div class="avatar">
                                                    <img class="img-fluid" src="/191014/{{$judger->img_url??'users/avatar.jpg'}}" alt="click to view" height="20" width="20">
                                                </div>
                                                <span class="chip-text">{{ $judger->{'first_name_'.$l} .' '. $judger->{'last_name_'.$l} }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                        @endif
                                </td>

                                <td>
                                    @php($weight=$company->companyWeight($company->id,$form->id??'',0))
                                    <span class="badge badge-light-{{$weight<25?'danger':($weight<50?'warning':'success') }}"> {{$weight}} %</span>
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
    @else
        <div class="card">
            <div class="card-header border-bottom">
                <h4 class="card-title">{{ __('cycles.Error') }}</h4>
            </div>
                <div class="card-body">
                    {{__('cycles.No records screening from')}} <a href="/admin/cycles">{{__('cycles.Cycles')}}</a>.
                </div>
        </div>
    @endif
</div>

        </div>
    </div>
    <!-- END: Content-->

@stop
@section('pagescripts')
    <script src="/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('.table').DataTable({
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
                        location.href = '/admin/screening/results/{{$id}}';
                    },
                    error: function (error) {
                        console.log(error);
                        alert("Error Occurred, arrange failed");
                    }});
            } else {
                location.href = '/admin/screening/results/{{$id}}';
            }}
    </script>
@stop