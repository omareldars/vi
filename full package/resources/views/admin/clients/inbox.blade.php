@extends('layouts.admin')

@section('content')
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/tables/datatable/datatables.min.css">
  <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('messages.ReceivedMessages')}}</h5>
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
                <!-- Zero configuration table -->
                <section id="basic-datatable">
                        <div class="row">
                            @php($n=1)
                            @if (count($received)>0)
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header"><br>
                                        <h4>{{__('messages.ReceivedMessages')}}</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body card-dashboard">
                                            <div class="table-responsive">
                                                <table class="table zero-configuration">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>{{__('messages.SenderName')}}</th>
                                                        <th>{{__('messages.Subject')}}</th>
                                                        <th>{{__('messages.Date')}}</th>
                                                        <th>{{__('messages.Read')}}</th>
                                                        <th>{{__('messages.Reply')}}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($received as $received)
                                                        <tr {!!$received->read?'':'style="font-weight:600;" id="read'.$received->id.'"'!!}>
                                                            <td>{{$n++}}</td>
                                                            <td>{{ $received->{'first_name_'.$l}.' '.$received->{'last_name_'.$l} }}</td>
                                                            <td>{{$received->subject}}</td>
                                                            <td>{{$received->created_at}}</td>
                                                            <td><span {!!$received->read?'':'id="No'.$received->id.'"'!!}>{{$received->read?__('messages.Yes'):__('messages.No')}}</span></td>
                                                            <td><a data-toggle="modal" id="msg" onclick="OpenModal({{$received->id}});" data-target="#MessageModal" href="javascript:void(0);"><i class="bx bxl-telegram"> </i></a>
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
                            @else
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header border-bottom">
                                            <h4 class="card-title">{{__('messages.ReceivedMessages')}}</h4>
                                        </div>
                                        <div class="card-body">
                                            <h6>   {{__('messages.No Received Messages')}} - <a href="/admin">{{__('admin.Back')}}</a>. </h6>
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
                    <h5 class="modal-title" id="exampleModalScrollableTitle"> (<span id="from"> </span>)
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p><b>{{__('messages.Date')}}: </b> <span id="date"></span></p>
                    <p><b>{{__('messages.Message')}}:</b></p>  <span id="message"></span>
                </div>
                <form method="post" action="/admin/send_message" enctype="multipart/form-data">
                    <div class="modal-body">
                        <p><b>{{__('messages.SendReply')}}:</b></p>
                        {!! csrf_field() !!}
                        <input type="hidden" name="sender" value="{{Auth::user()->id}}">
                        <input type="hidden" id="receiver" name="receiver" >
                        <input type="hidden" id="messgeId" name="messgeId" >
                        <input type="hidden" id='subject' name="subject" value="">
                        <div class="form-group">
                            <textarea class="form-control" name='message' rows="4"
                                      placeholder="{{__('messages.Write your message')}}" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">{{__('messages.Send')}}</span>
                        </button>
                        <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">{{__('messages.Close')}}</span>
                        </button>
                    </div>
                </form>
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
<script>
    function OpenModal(id){
        $.ajax({
            type: "GET",
            url: "/admin/openmsg",
            data:{"id":id,"type":1},
            success: function (response) {
                var trrow = $("#" + 'read' + id);
                var trno = $("#" + 'No' + id);
                trrow.css({"font-weight":"unset"});
                trno.html('{{__('messages.Yes')}}');
                $('#from').text("'"+ response['subject'] +"' {{__('messages.From')}}: " + response['first_name_{{$l=='ar'?'ar':'en'}}'] + " "  + response['last_name_{{$l=='ar'?'ar':'en'}}']);
                $('#date').text(response['created_at']);
                $('#message').text(response['message']);
                $('#receiver').val(response['sender']);
                $('#messgeId').val(response['id']);
                $('#subject').val("Reply to: " + (response['subject']).replace('Reply to:',''));
            },
            error:function(error){
                console.log(error);
                alert("Error Occurred, Try again!");
            },
        });
    }
</script>
	<script src="/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
	<script src="/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>
   	<script src="/app-assets/js/scripts/datatables/datatable.js"></script>
@stop
