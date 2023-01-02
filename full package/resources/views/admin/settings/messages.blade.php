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
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('admin.Messages')}}</h5>
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
                @if(session()->has('msg'))
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-{{session()->get('class')}} mb-2" role="alert">
                                    <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-{{session()->get('class')=='success'?'like':'error'}}"></i>
                                        <span>
                                                            {{ __('admin.'.session()->get('msg')) }}
                                            {{ Session::forget('msg') }}
                                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            @endif
                <!-- Zero configuration table -->
                <section id="basic-datatable">
<?php $n=1; ?>
@if (count($getmsgs)>0)
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>{{__('messages.SenderName')}}</th>
                                                        <th>{{__('messages.Email')}}</th>
                                                        <th>{{__('messages.Subject')}}</th>
                                                        <th>{{__('messages.Replied')}}</th>
                                                        <th>{{__('messages.ReadOpenDelete')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
												@foreach ($getmsgs as $getmsg)
                                                    <tr {!!$getmsg->read?'id="read'.$getmsg->id.'"':'id="unread'.$getmsg->id.'" style="font-weight:600;"'!!} >
                                                        <td>{{$n++}}</td>
                                                        <td>
                                                            @if ($getmsg->internal_id)
                                                            <a href="/admin/users/{{$getmsg->internal_id}}/edit">{{$getmsg->name}} ({{__('admin.user')}})</a>
                                                            @else
                                                             {{$getmsg->name}}
                                                            @endif
                                                        </td>
                                                        <td>{{$getmsg->email}}</td>
                                                        <td>{{$getmsg->subject}}</td>
                                                        <td>
                                                            {{$getmsg->replyBy?__('Yes'):__('No')}}
                                                        </td>
                                                        <td>
                                                            <a href="javascript:void(0);" onclick="makeread({{$getmsg->id}});"><i id="ico{{$getmsg->id}}" class='bx bxs-{{$getmsg->read?"inbox":"envelope"}}'> </i></a> |
                                                            <a data-toggle="modal" id="msg" data-target="#MessageModal" onclick="OpenModal({{$getmsg->id}})" href="javascript:void(0);"><i class="bx bxs-show"> </i></a> |
                                   <a onclick="return confirm('{{__('Are you sure?')}}');" href="{{URL::to('/admin/deletemsg/'.$getmsg->id ?? null)}}"><i class="bx bx-trash"> </i></a></td>
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
@else
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{__('admin.Messages')}}</h4>
            </div>
            <hr style="margin:-10px 0 5px 0;">
            <div class="card-body">
                <h5>   {{__('messages.NoMessages')}} - <a href="/admin">{{__('admin.Back')}}</a>. </h5>
            </div>
        </div>

@endif
                </section>
                <!--/ Zero configuration table -->
            </div>
        </div>
    </div>
    <!-- END: Content-->
                                        <div class="modal fade" id="MessageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="Title">
														</h5>

                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <i class="bx bx-x"></i>
                                                        </button>
                                                    </div>
                                                    <form action="{{URL::to('admin/msgreply')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                                                    <div class="modal-body">
                                                        <p class="warning" id="replyby"></p>
														<p><b>{{__('messages.Phone')}}: </b> <span id="Phone"></span></p>
														<p><b>{{__('messages.Email')}}: </b>  <span id="Email"></span></p>
														<p><b>{{__('messages.Date')}}: </b>  <span id="Date"></span></p>
                                                        <p><b>{{__('messages.IP')}}: </b><span id="UserIp"></span></p>
                                                        <p><b>{{__('messages.Message')}}:</b></p>  <span id="Message"></span>

                                                        <hr>
                                                        <h6>{{__('messages.Sendreply')}}:</h6>

                                                            {!! csrf_field() !!}
                                                        <input type="hidden" name="remail" value="" id="remail">
                                                        <input type="hidden" name="rname" value="" id="rname">
                                                        <input type="hidden" name="mid" value="" id="mid">
                                                            <label>{{__('messages.Subject')}}</label>
                                                            <div class="form-group">
                                                                <input name="subject" type="text" placeholder="{{__('messages.Subject')}}" class="form-control" required="">
                                                            </div>
                                                            <label>{{__('messages.yourMessage')}}:</label>
                                                            <div class="form-group">
                                                        <textarea class="form-control" name='message' rows="3"
                                                                  placeholder="{{__('messages.Write your message')}}" required></textarea>
                                                            </div>

                                                    </div>



                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary send-btn">
                                                            <i class="bx bx-x d-block d-sm-none"></i>
                                                            <span class="d-none d-sm-inline"> {{__('messages.Send')}}</span>
                                                        </button>
                                                        <a id="DelMe" onclick="return confirm('{{__('Are you sure?')}}');" href="#">
													<button type="button" class="btn btn-light-danger">
                                                            <i class="bx bx-x d-block d-sm-none"></i>
                                                            <span class="d-none d-sm-block">{{__('messages.Delete')}}</span>
                                                        </button></a>
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
    "sEmptyTable":     "ليست هناك بيانات متاحة في الجدول", "sLoadingRecords": "جارٍ التحميل...", "sProcessing":   "جارٍ التحميل...",
	"sLengthMenu":   "أظهر _MENU_ مدخلات", "sZeroRecords":  "لم يعثر على أية سجلات",
	"sInfo":         "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل", "sInfoEmpty":    "يعرض 0 إلى 0 من أصل 0 سجل",
	"sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)", "sInfoPostFix":  "", "sSearch":       "ابحث:", "sUrl":          "",
	"oPaginate": {"sFirst":    "الأول", "sPrevious": "السابق", "sNext":     "التالي", "sLast":     "الأخير"},
	"oAria": {"sSortAscending":  ": تفعيل لترتيب العمود تصاعدياً", "sSortDescending": ": تفعيل لترتيب العمود تنازلياً"}}
        } );});
	</script>
@endif
	<script src="/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
	<script src="/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>
   	<script src="/app-assets/js/scripts/datatables/datatable.js"></script>
	<script src="/app-assets/js/scripts/modal/components-modal.js"></script>
	<script>
        function OpenModal(id){
            var tno = $("#" + 'read' + id);
            var tyes = $("#" + 'unread' + id);
            var ico = $("#" + 'ico' + id);
            tno.css({"font-weight":"unset"});
            tno.attr('id','read' + id);
            tyes.css({"font-weight":"unset"});
            tyes.attr('id','read' + id);
            ico.attr('class','bx bxs-inbox');
            $.ajax({
                type: "GET",
                url: "/admin/openonemsg/" + id,
                success: function (response) {
                    console.log(response);
                    $('#Title').text(response[0]['subject'] + " {{__('messages.From')}}: " + response[0]['name']);
                    $('#Email').text(response[0]['email']);
                    $('#remail').val(response[0]['email']);
                    $('#rname').val(response[0]['name']);
                    $('#mid').val(response[0]['id']);
                    $('#Phone').text(response[0]['phone']);
                    $('#Date').text(response[0]['created_at']);
                    $('#Message').text(response[0]['message']);
                    $('#UserIp').text(response[0]['userip']);
                    if (response[1]['first_name_en']) {
                        $('#replyby').html('<b>'+response[1]['first_name_{{$l}}'] + ' ' + response[1]['last_name_{{$l}}'] + ' {{__('messages.replied with')}} ('+ response[0]['reSubject'] + ' - ' + response[0]['reMessage'] +')</b>');
                    } else {
                        $('#replyby').html('');
                    }
                    $('#DelMe').attr('href','/admin/deletemsg/'+id)
                },
                error:function(error){
                    console.log(error);
                    alert("Error Occurred, Try again!");
                },
            });
        }
	function makeread(id){
        var trrow = $("#" + 'read' + id);
        var trno = $("#" + 'unread' + id);
        var ico = $("#" + 'ico' + id);
        var lnk = 'makeunread';
        if (trno.length) {var lnk = 'makeread';}
         $.ajax({
            type: 'POST',
            url: lnk+'/'+id,
            data: {
                 "_token": "{{ csrf_token() }}",
                 "id": id
             },
             success: function() {
                 $('#id');
                 if (trno.length) {
                     trno.css({"font-weight":"unset"});
                     trno.attr('id','read' + id);
                     ico.attr('class','bx bxs-inbox');
                 }
                 else {
                     trrow.css({"font-weight":600});
                     trrow.attr('id','unread' + id);
                     ico.attr('class','bx bxs-envelope');
                 }
             },
              error: function() { // if error occurred
                    alert("DB Error occurred, please try again");
                },
                }); }
	</script>
@stop
