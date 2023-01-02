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
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('cycles.all courses')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
									<li class="breadcrumb-item active">{{__('cycles.all Training courses')}}
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
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-xl-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header" style="padding-bottom: 15px;">
                        <h4 class="card-title">{{__('cycles.Training courses')}}</h4>
                    </div>
                    <hr>
                    <div class="card-body">
                        <span>{{__('cycles.Select course')}}</span>
                        <fieldset class="input-group">
                            <select id="ccycle" class="select form-control" onchange="window.open('/admin/training/all/'+this.options[this.selectedIndex].value,'_self');">
                                @foreach($courses as $course)
                                    <option value="{{$course->id}}" {{$course->id==$id?'selected':''}}>{{$course->title}}</option>
                                @endforeach
                                    @if(count($courses)==0)
                                        <option>  {{__('cycles.No records saved')}} - ({{__('cycles.New')}}).</option>
                                    @endif
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-primary" onclick="edit({{$id??0}})">
                                    <i class="bx bx-edit"></i> <span class="align-middle ml-25">{{__('cycles.Edit')}}</span>
                                </button>
                                <button class="btn btn-success" onclick="edit(0)">
                                    <i class="bx bx-star" ></i> <span class="align-middle ml-25">{{__('cycles.New')}}</span>
                                </button>
                                @if (isset($course))
                                <button class="btn btn-danger" onclick="deleteme({{$id??0}},1)">
                                    <i class="bx bx-trash"></i> <span class="align-middle ml-25">{{__('cycles.Delete')}}</span>
                                </button>
                                 @endif
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
            @if (isset($course))
            <a class="btn btn-primary glow" href="/admin/training/addcontent/{{$id}}" >{{__('cycles.Add new content')}}</a>
                @endif
        </div>
            <div class="card-body">
            <div class="card-text">
                <div class="table-responsive">
                    <table class="table mb-0" id="userstable">
                        <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>{{__('cycles.Title')}}</th>
                            <th>{{__('cycles.Created at')}}</th>
                            <th>{{__('cycles.Added By')}}</th>
                            <th>{{__('cycles.Edit/Delete')}}</th>
                        </tr>
                        </thead>
                        <tbody>
@foreach($contents as $content)
                            <tr>
                                <td>{{$content->arr}}</td>
                                <td>{{$content->title}}</td>
                                <td>{{$content->created_at}}</td>
                                <td>{{$content->user->{'first_name_'.$l} }} {{$content->user->{'last_name_'.$l} }}</td>
                                <td>
                                    <a title="Edit" href="/admin/training/editcontent/{{$content->id}}" class="btn btn-icon rounded-circle btn-light-success">
                                        <i class="bx bx-edit"></i></a>
                                    <button title="Delete" onclick="deleteme({{$content->id}},0)" type="button" class="btn btn-icon rounded-circle btn-light-danger">
                                        <i class="bx bx-trash"></i></button>
                                    <a title="Edit" href="/admin/training/viewcontent/{{$content->id}}" class="btn btn-icon rounded-circle btn-light-primary">
                                        <i class="bx bx-show"></i></a>
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
            </div>
        </div>
    </div>
    <!-- END: Content-->
<div class="modal fade text-left" id="edittraining" tabindex="-1" role="dialog" aria-labelledby="sendrequest" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" action="/admin/training/store" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('cycles.Modify training course')}} </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                  	<input type="hidden" name="id" value="" id="id">
                    <div style="text-align: center;" class="form-group" id="showimage">
                    </div>
                    <label>{{__('cycles.Course Title')}}</label>
                    <div class="form-group">
                        <input id="title" name="title" type="text" placeholder="Title" class="form-control" required>
                    </div>
                    <label>{{__('cycles.Add a description')}}:</label>
                    <div class="form-group">
                            <textarea class="form-control" id="dsc" name='dsc' rows="4"
                                      placeholder="{{__('cycles.Write your description here')}}." ></textarea>
                    </div>
                        <div class="form-group">
                            <label>{{__('cycles.Image')}}</label>
                            <div class="custom-file">
                                <input type="file" class="form-control" name="image" id="image" accept='image/*'>
                                <label class="custom-file-label" for="image">{{__('cycles.Browse')}}</label>
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary ml-1" >
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">{{__('Submit')}}</span>
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
            $('#userstable').DataTable({
                "responsive": true, "searching": true, "lengthChange": false, "paging": true, "bInfo": false,
                "columnDefs": [
                    {"orderable": false, "targets":  [4]},
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
            $('.date').datetimepicker({timepicker:true,format:'Y-m-d H:i'});
            function edit(id) {
                if (id===0) {
                    $('#id').val('');
                    $('#title').val('');
                    $('#dsc').val('');
                    $('#showimage').html('')
                    $('#edittraining').modal('show');
                } else {
                    $.ajax({
                        type: "GET", url: "/admin/training/edit/"+id,
                        success: function (response) {
                        $('#id').val(id);
                        $('#title').val(response.title);
                        $('#dsc').val(response.dsc);
                        if (response.image) {
                            $('#showimage').html('<img style="height: 200px;" class="img-responsive" src="/191014/' + response.image + '" >');
                        }
                        $('#edittraining').modal('show');
                        },
                        error: function (error) {
                            console.log(error);
                            alert("Error Occurred, Try again!");
                        }});
            }}

            function deleteme(id,type) {
                let url = '/admin/training/delcontent/'+id;
                if (type===1) {url = '/admin/training/delete/'+id;}
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
                                        'success'
                                    );
                                    if (type===1) {window.location.href='/admin/training/all';} else {location.reload();}
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
            }
    </script>
@stop