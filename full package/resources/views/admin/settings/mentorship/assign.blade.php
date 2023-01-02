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
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('cycles.Cycles Mentors')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
									<li class="breadcrumb-item active">{{__('cycles.Manage Cycle mentors')}}
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
                                            <select id="cstep" class="select form-control" onchange="window.open('/admin/mentorship/assign/'+this.options[this.selectedIndex].value,'_self');">
                                                @foreach(\App\Cycle::get() as $cycle)
                                                    <option value="{{$cycle->id}}" {{$cycle->id==$id?'selected':''}}>{{$cycle->title}} {{__('cycles.from')}} {{$cycle->start->format('d-m')}} {{__('cycles.to')}} {{$cycle->end->format('d-m-Y')}}</option>
                                                @endforeach
                                                    @if(!$id)
                                                        <option>  {{__('cycles.No records saved')}} - ({{__('cycles.Manage Cycle')}}).</option>
                                                    @endif
                                            </select>
                                        <div class="input-group-append">
                                    <a class="btn btn-success" href="/admin/cycles/{{$id}}">
                                         <i class="bx bx-pencil"></i> <span class="align-middle ml-25">{{__('cycles.Manage Cycle')}}</span>
                                    </a>
                                            <a class="btn btn-primary" href="/admin/mentorship/view/{{$id}}">
                                                <i class="bx bx-chat"></i> <span class="align-middle ml-25">{{__('cycles.Manage sessions')}}</span>
                                            </a>
                                        </div>
                                    </fieldset>
                                    <br />
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

        <section>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h4 class="card-title align-items-center">
                                <i class='bx bx-card font-medium-4 mr-1'></i>{{__('cycles.Mentors')}}
                            </h4>
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
                            <div class="card ">
                                <form action= "/admin/mentorship/assign/{{$id}}" method="POST" enctype="multipart/form-data">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="cycle" value="{{$id}}">
                                <div class="table-responsive">
                                    <table class="table" id="mentorstable">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>{{__('cycles.Name/Title')}}</th>
                                            <th>{{__('cycles.Bio')}}</th>
                                            <th>{{__('cycles.Specialization')}}</th>
                                            <th>Linkedin</th>
                                            <th>{{__('cycles.Rate')}}</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($mentors as $mentor)
                                            <tr>
                                                <td>
                                                    <div class="checkbox">
                                                    <input type='checkbox' id="checkbox{{$mentor->id}}" class="checkbox-input"
                                                           {{ in_array($mentor->id,$clist) ? 'checked' :'' }}
                                                           name='users[]' value="{{$mentor->id}}">
                                                    <label for="checkbox{{$mentor->id}}">
                                                    <div class="media align-items-center">
                                                        <a class="media-left mr-50 ml-50">
                                                            <img src="/191014/{{$mentor->img_url??'../images/placeholder.jpg'}}" alt="avatar" class="rounded-circle" height="40" width="40">
                                                        </a>
                                                        <div class="media-body">
                                                            <h6 class="media-heading mb-0">{{$mentor->{'first_name_'.$l} }} {{$mentor->{'last_name_'.$l} }}</h6>
                                                            <span class="font-small-2">{{$mentor->{'title_'.$l} }}</span>
                                                        </div>
                                                    </div>
                                                    </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{$mentor->bio->{'bio_'.$l} ?? '-' }}
                                                </td>
                                                <td>
                                                    {{$mentor->bio->{'specialization_'.$l} ?? '-' }}
                                                </td>
                                                <td>
                                                    @if ($mentor->bio->linkedin ??0)
                                                        <a title="Linkedin URL" target="_blank" href="{{$mentor->bio->linkedin}}" class="btn btn-icon rounded-circle btn-light-primary">
                                                            <i class="bx  bxl-linkedin"></i></a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span>{!! str_repeat('<i class="bx bxs-star" style="color: #fc960f;"></i>',$mentor->mrating()) !!}</span>
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

                                <button type="submit" class="btn btn-primary" >
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">{{__('cycles.Save')}}</span>
                                </button>
                                </form>
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

@stop
@section('pagescripts')
    <script src="/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="/js/jquery.datetimepicker.full.min.js"></script>

        <script type="text/javascript">
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

                $('#checkAll').click(function () {
                    $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
                });
            });
        </script>

    <script>
            $('.date').datetimepicker({timepicker:true,format:'Y-m-d H:i'});
    </script>
@stop