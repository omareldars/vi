@extends('layouts.admin')
@section('content')
  <!-- BEGIN: Content-->
  <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('messages.SentMessages')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active">{{__('messages.ShowMessages')}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!--/ Zero configuration table -->
                <section id="basic-datatable">
                    @php($n=1)
                        <div class="row">
                            @if (count($sent)>0)
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header"><br>
                                        <h4>{{__('messages.SentMessages')}}</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body card-dashboard">
                                            <div class="table-responsive">
                                                <table class="table zero-configuration">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>{{__('messages.ReceivedName')}}</th>
                                                        <th>{{__('messages.Subject')}}</th>
                                                        <th>{{__('messages.Date')}}</th>
                                                        <th>{{__('messages.Read')}}</th>
                                                        <th>{{__('messages.OpenDelete')}}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($sent as $sent)
                                                        <tr {!!$sent->read?'':'style="font-weight:600;" id="read'.$sent->id.'"'!!}>
                                                            <td>{{$n++}}</td>
                                                            <td>{{ $sent->{'first_name_'.$l}.' '.$sent->{'last_name_'.$l} }}</td>
                                                            <td>{{$sent->subject}}</td>
                                                            <td>{{$sent->created_at}}</td>
                                                            <td><span {!!$sent->read?'':'id="No'.$sent->id.'"'!!}>{{$sent->read?__('messages.Yes'):__('messages.No')}}</span></td>
                                                            <td><a onclick="OpenModal({{$sent->id}})" data-toggle="modal" id="msg" data-target="#MessageModal" href="javascript:void(0);"><i class="bx bxs-show"> </i></a> |
                                                                <a onclick="delme({{$sent->id}})" href="javascript:void(0);"><i class="bx bx-trash"> </i></a></td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header border-bottom">
                                            <h4 class="card-title">{{__('messages.SentMessages')}}</h4>
                                        </div>
                                        <div class="card-body">
                                            <h6>   {{__('messages.No Sent Messages')}} - <a href="/admin">{{__('admin.Back')}}</a>. </h6>
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
  <div class="modal fade" id="MessageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalScrollableTitle"> (<span id="from"></span>)
                  </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <i class="bx bx-x"></i>
                  </button>
              </div>
              <div class="modal-body">
                  <p><b>{{__('messages.Date')}}: </b> <span id="date"></span></p>
                  <p><b>{{__('messages.Message')}}:</b></p> <span id="message"></span>
              </div>
              <div class="modal-footer">

                  <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                      <i class="bx bx-x d-block d-sm-none"></i>
                      <span class="d-none d-sm-block">{{__('messages.Close')}}</span>
                  </button>
              </div>
          </div>
      </div>
  </div>
@stop
@section('scripts')
@if($l=='ar')
<script type="text/javascript">
    $(document).ready(function() {
        $('.zero-configuration').DataTable({
"language": {"sEmptyTable":     "ليست هناك بيانات متاحة في الجدول", "sLoadingRecords": "جارٍ التحميل...", "sProcessing":   "جارٍ التحميل...", "sLengthMenu":   "أظهر _MENU_ مدخلات",
"sZeroRecords":  "لم يعثر على أية سجلات","sInfo":         "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل", "sInfoEmpty":    "يعرض 0 إلى 0 من أصل 0 سجل", "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
"sInfoPostFix":  "", "sSearch":"ابحث:", "sUrl":"", "oPaginate": {"sFirst":    "الأول", "sPrevious": "السابق", "sNext":     "التالي", "sLast":     "الأخير"},
"oAria": {"sSortAscending":  ": تفعيل لترتيب العمود تصاعدياً", "sSortDescending": ": تفعيل لترتيب العمود تنازلياً"}}});});
	</script>
@endif
	<script src="/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
	<script src="/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>
   	<script src="/app-assets/js/scripts/datatables/datatable.js"></script>
	<script src="/app-assets/js/scripts/modal/components-modal.js"></script>
	<script>
        function OpenModal(id){
            $.ajax({
                type: "GET",
                url: "/admin/openmsg",
                data:{"id":id,"type":2},
                success: function (response) {
                    $('#from').text("'"+ response['subject'] +"' {{__('To')}}: " + response['first_name_{{$l=='ar'?'ar':'en'}}'] + " "  + response['last_name_{{$l=='ar'?'ar':'en'}}']);
                    $('#date').text(response['created_at']);
                    $('#message').text(response['message']);
                },
                error:function(error){
                    console.log(error);
                    alert("Error Occurred, Try again!");
                },
            });
        }
    function delme(id) {
        var url = '/admin/messages/delete';
        var id = id;
        var token = '{{ csrf_token() }}';
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
                    $.post(url, {'id':id , '_token':token},
                        function(response){
                            Swal.fire(
                                '{{__('admin.Deleted')}}!',
                                '{{__('admin.FileDeleted')}}.',
                                'success'
                            );
                            location.reload();
                        }
                    ).fail(
                        function(error) {
                                Swal.fire(
                                    'Error!',
                                    'Delete fail.',
                                    'error'
                                );
                            console.log(error);
                        }
                    );
                }else{
                    console.log('Canceled')
                }
            })
    }
	</script>
@stop
