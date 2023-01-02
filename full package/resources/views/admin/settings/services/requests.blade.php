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
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('cycles.Services requests')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active">{{__('cycles.Show new requests')}}
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
                            @if (count($received)>0)
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header"><br>
                                        @if ($countold)
                                        <a href="/admin/requests/old" class="btn btn-primary glow">{{__('cycles.Show old records')}}</a>
                                            @endif
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body card-dashboard">
                                            <div class="table-responsive">
                                                <table class="table zero-configuration">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>{{__('cycles.SenderName')}}</th>
                                                        <th>{{__('cycles.Service')}}</th>
                                                        <th>{{__('cycles.Comments')}}</th>
                                                        <th>{{__('cycles.Date/Time')}}</th>
                                                        <th>{{__('cycles.Actions')}}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($received as $n=>$rec)
                                                        <tr>
                                                            <td>{{$n+1}}</td>
                                                            <td>
                                                                    <div class="media align-items-center">
                                                                        <a class="media-left mr-50" href="/admin/companyProfile/{{$rec->user->company->id}}">
                                                                            <img src="/191014/{{$rec->user->img_url??'../images/placeholder.jpg'}}" alt="avatar" class="rounded-circle" height="40" width="40">
                                                                        </a>
                                                                        <a href="/admin/companyProfile/{{$rec->user->company->id}}">
                                                                            <div class="media-body">
                                                                                <h6 class="media-heading mb-0">{{ $user = $rec->user->{'first_name_'.$l}.' '.$rec->user->{'last_name_'.$l} }}</h6>
                                                                                <span class="font-small-2">{{$rec->user->{'title_'.$l} }}
                                                                                    @if($rec->user->company)
                                                                                    - {{$rec->user->company->{'name_'.$l} }}
                                                                                    @endif
                                                                                </span>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                          </td>
                                                            <td>{{ $rec->service->{'name_'.$l} }}</td>
                                                            <td>{{$rec->comment??'-'}}</td>
                                                            <td>{{$rec->date_time}}</td>
                                                            <td>
                                                                <button onclick="reply({{$rec->id}},'{{ $user }}','{{ $rec->service->{'name_'.$l} }}');" type="button" class="btn btn-icon rounded-circle btn-light-success mr-1" >
                                                                    <i class="bx bx-edit-alt"></i></button>
                                                                <button onclick="OpenModal({{$rec->user_id}},'{{ $user }}','{{ $rec->service->{'name_'.$l} }}');" type="button" class="btn btn-icon rounded-circle btn-light-primary mr-1" >
                                                                    <i class="bx bxl-telegram"></i></button>
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
                                        <div class="card-header">
                                            <h4 class="card-title">{{__('cycles.No Received Requests')}}</h4>
                                            @if ($countold)
                                                <br>
                                                <a href="/admin/requests/old" class="btn btn-primary glow">{{__('cycles.Show old records')}}</a>
                                            @endif
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
    <div class="modal fade text-left" id="MessageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">{{__('messages.SendMessageTo')}} <span id="uname"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <form method="post" action="/admin/send_message" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <input type="hidden" name="sender" value="{{Auth::user()->id}}">
                    <input type="hidden" name="receiver" id="rid" value="">
                    <div class="modal-body">
                        <label>{{__('messages.Subject')}}:</label>
                        <div class="form-group">
                            <input id="subject" name="subject" type="text" placeholder="{{__('messages.Subject')}}" class="form-control" required>
                        </div>
                        <label>{{__('messages.Message')}}: </label>
                        <div class="form-group">
                            <textarea class="form-control" id="message" name='message' rows="8"
                                      placeholder="{{__('messages.Write your message')}}" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">{{__('messages.Close')}}</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">{{__('messages.Send')}}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

  <!-- Send response -->
  <div class="modal fade text-left" id="ReplyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel33">{{__('cycles.Response to')}} <span id="rname"></span></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <i class="bx bx-x"></i>
                  </button>
              </div>
                  <input type="hidden" name="sender" value="{{Auth::user()->id}}">
                  <input type="hidden" name="receiver" id="resid" value="">
                  <div class="modal-body">
                      <label>{{__('cycles.Add a comment')}}:</label>
                      <div class="form-group">
                            <textarea class="form-control" id="admin_comment" name='admin_comment' rows="4"
                                      placeholder="{{__('cycles.Write a response comment')}}" ></textarea>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-success" data-dismiss="modal" onclick="approve('Yes')">
                          <i class="bx bx-x d-block d-sm-none"></i>
                          <span class="d-none d-sm-block">{{__('cycles.Approve')}}</span>
                      </button>
                      <button type="button" class="btn btn-danger ml-1" onclick="approve('No')">
                          <i class="bx bx-check d-block d-sm-none"></i>
                          <span class="d-none d-sm-block">{{__('cycles.Disapprove')}}</span>
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
    function OpenModal(id,name,title) {
        $('#uname').html(name);
        $('#rid').val(id);
        $('#subject').val('{{__('cycles.Your request')}} - '+title);
        $('#MessageModal').modal('show');
    }
    function reply(id,name,title) {
        $('#rname').html('"'+title +'" {{__('cycles.Request from')}} '+ name);
        $('#resid').val(id);
        $('#ReplyModal').modal('show');
    }
    function approve(stat) {
        let comment = $('#admin_comment').val();
        let id =  $('#resid').val();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST", url: "/admin/requests/approve",
            data: {"id": id, "stat": stat, "comment": comment },
            success: function (response) {
                location.reload();
            },
            error: function (error) {
                console.log(error);
                alert("Error Occurred, Try again!");
            }
        });
    }
</script>
<script src="/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
<script src="/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>
<script src="/app-assets/js/scripts/datatables/datatable.js"></script>
@stop
