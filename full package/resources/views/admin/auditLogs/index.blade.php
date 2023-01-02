@extends('layouts.admin')
@section('style')
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/tables/datatable/datatables.min.css">
@stop
@section('title', __('audit.Portal Log') )
@section('subTitle', __('audit.Log viewer'). (count($auditLogs)>0 ?" (".$TotalRec.__('audit.record of').count($auditLogs).")":"") )
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
    @include('admin.includes.heading')
        <div class="content-body">
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
@can ('manage_log')
@if (count($auditLogs)>0)           <a href="/reports/audit-log" class="btn btn-primary glow">{{__('audit.Download all records')}}</a>
                                    <a href="#" id="deleteAll" data-url="/admin/audit-logs/0" class="btn btn-danger glow">{{__('audit.Empty Log table')}}</a> @endif
@endcan
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table zero-configuration">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ __('audit.description')}}</th>
                                                    <th>{{ __('audit.subject_id')}}</th>
                                                    <th>{{ __('audit.subject_type')}}</th>
                                                    <th>{{ __('audit.user_id')}}</th>
                                                    <th>{{ __('audit.host')}}</th>
                                                    <th>{{ __('audit.created_at')}}</th>
                                                    <th>{{ __('audit.More')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($auditLogs as $key => $auditLog)
                                                    <tr>
                                                        <td>
                                                            {{ $auditLog->id ?? '' }}
                                                        </td>
                                                        <td>
                                                            {{ $auditLog->description ?? '' }}
                                                        </td>
                                                        <td>
                                                            {{ $auditLog->subject_id ?? '' }}
                                                        </td>
                                                        <td>
                                                            {{ $auditLog->subject_type ?? '' }}
                                                        </td>
                                                        <td>
                                                            {{ $auditLog->user_id ?? '' }}
                                                        </td>
                                                        <td>
                                                            {{ $auditLog->host ?? '' }}
                                                        </td>
                                                        <td>
                                                            {{ $auditLog->created_at ?? '' }}
                                                        </td>
                                                        <td>
                                                                <a class="btn btn-xs btn-primary" href="{{ route('audit-logs.show', $auditLog->id) }}">
                                                                    {{ __('audit.View') }}
                                                                </a>
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
                </div>
            </section>
        </div>
    </div>
</div>
@stop
@section('scripts')
@if($l=='ar')
<script type="text/javascript">
    $(document).ready(function() {
        $('.zero-configuration').DataTable({
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
        } );
    });
	</script>
@endif
<script src="/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
<script src="/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>
<script src="/app-assets/js/scripts/datatables/datatable.js"></script>
<script>
    $(document).on("click", "#deleteAll", function (e) {
        var url = $(this).data('url');
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        Swal.fire({
            title: '{{__('Are you sure?')}}',
            text: '{{__("You will not be able to recover records again")}}!',
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "{{__('Yes, delete it')}}",
            cancelButtonText: "{{__('No')}}!",
        })
            .then((result) => {
                if (result.value) {

                    $.post(url, {'_method':'DELETE'},
                        function(response){
                            Swal.fire(
                                '{{__('Deleted!')}}',
                                '{{__('All log records has been deleted.')}}',
                                'success'
                            );
                            location.reload();
                        }
                    ).fail(
                        function(error) {
                            console.log(error);
                        }
                    );
                }else{
                    console.log('Canceled')
                }
            })
    });
</script>
@stop
