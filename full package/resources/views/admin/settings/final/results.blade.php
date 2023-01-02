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
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('cycles.Final Screening results')}}</h5>
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
                                            <select id="cstep" class="select form-control" onchange="window.open('/admin/final/results/'+this.options[this.selectedIndex].value,'_self');">
                                                @foreach($steps as $step)
                                                    <option value="{{$step->id}}" {{$step->id==$id?'selected':''}}>{{$step->title}} ({{__('cycles.Cycle')}} "{{$step->cycle->title}}" - {{__('cycles.Start')}} {{$step->from->format('d-m')}})</option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-append">

                                                <button class="btn btn-primary" onclick="window.location.href='/admin/{{$id}}/final'">
                                                    <i class="bx bx-cog"></i> <span class="align-middle ml-25">{{__('cycles.Manage')}}</span>
                                                </button>
                                                <a class="btn btn-success" href="/admin/cycles/{{$cstep->cycle_id??null}}">
                                                    <i class="bx bx-pencil"></i> <span class="align-middle ml-25">{{__('cycles.Cycle')}}</span>
                                                </a>
                                            </div>
                                        </fieldset>
                                        <br>
                                        <span>{{__('cycles.Select registered company')}}:</span>
                                        <fieldset class="input-group">
                                            <select id="cstep" class="select form-control" onchange="window.open('/admin/final/results/{{$id}}?c='+this.options[this.selectedIndex].value,'_self');">
                                                <option value="0">{{__('cycles.Select Company')}}</option>
                                                @foreach($companies as $company)
                                                    <option value="{{$company->id}}" {{$c?$company->id == $c->id?'selected':'' :''}}>{{ $company->{'name_'.$l} }} ({{__('cycles.Added By')}} {{$company->user->{'first_name_'.$l} }} {{$company->user->{'last_name_'.$l} }})</option>
                                                @endforeach
                                            </select>
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
    <div class="col-xl-12 col-md-12 col-sm-12">
        @if ($c)
    <div class="card">
        <div class="card-header">
            <h4 class="card-title secondary">{{$cstep->title}} <small class="text-muted"> {{__('cycles.from')}} {{$cstep->from->format('d-m')}} {{__('cycles.to')}} {{$cstep->to->format('d-m-Y')}}</small>
                {{__('cycles.for')}} :
                        <a   href="/admin/companyProfile/{{$c->id}}">
                        <img src="/191014/{{$company->logo??'../app-assets/images/logo_placeholder.png'}}" alt="avatar" class="rounded-circle" height="40" width="40">
                             {{ $c->{'name_'.$l} }}</a>
            </h4>
            <p>{{$cstep->description}}</p>
        </div>
        <hr style="margin:-20px 0;">
        <div class="card-body">
                @if (count($cj))
                <div class="table-responsive">
                    <table class="table  table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Question</th>
@foreach($cj as $judge)
                            <th>{{ $judge->judge->{'first_name_'.$l} }} {{$judge->judge->{'last_name_'.$l} }}</th>
@endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(\App\FinalData::where('step_id',$cstep->id)->where('company_id',$c->id)->distinct('field_id')->get(['field_id']) as $key=>$question)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>
                                    {{\App\FinalData::where('step_id',$cstep->id)->where('company_id',$c->id)->where('field_id',$question->field_id)->first(['question'])->question }}
                                </td>
                                @foreach($cj as $judge)
                                @foreach(\App\FinalData::where('step_id',$cstep->id)->where('judge_id',$judge->judge_id)->where('field_id',$question->field_id)->where('company_id',$c->id)->get(['answer']) as $answer)
                                <td>
                                        {{$answer->answer}}
                                </td>
                                @endforeach
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <br>
                <p>{{__('cycles.No answers submitted yet')}}.</p>
                    @endif
        </div>
    </div>
        @else
            <div class="card">
                <div class="card-body">
           {{__('cycles.Select company from menu above')}}.
                </div>
            </div>
    </div>
        @endif
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
                "responsive": true, "searching": true, "lengthChange": false, "paging": true, "bInfo": false,
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
@stop