@extends('layouts.admin')
@section('vendorstyle')
@stop
@section('style')
<link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/tables/datatable/datatables.min.css">
<link rel="stylesheet" type="text/css" href="/app-assets/css{{$l=='ar'?'-rtl':''}}/pages/search.css">
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
@stop
@section('title', __('admin.Dashboard') )
@section('subTitle', __('admin.Services directory'))
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('admin.directory')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active">{{__('admin.Search')}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="search-bar-wrapper">
                    <form id="search" method="get">
                    <!-- Search Bar -->
                    <div class="search-bar">
                        <!-- input search -->
                            <fieldset class="search-input form-group position-relative">
                                <input name="find" value="{{Request::get('find')}}" type="search" class="form-control rounded-right form-control-lg shadow pl-2" id="searchbar" placeholder="{{__('admin.Search')}}">
                                <button class="btn btn-primary search-btn rounded" type="submit">
                                    <span class="d-none d-sm-block">{{__('admin.Search')}}</span>
                                    <i class="bx bx-search d-block d-sm-none"></i>
                                </button>
                            </fieldset>
                        <!--/ input search -->
                    </div>
                    <div class="row search-menu">
                        <div class="col-12">
                            <!-- search menu tab -->
                            <ul class="list-unstyled mb-0">
                                <li class="d-inline-block mr-2 mb-1">
                                    <fieldset>
                                        <div class="radio">
                                            <input type="radio" name="type" id="c0" value="" {{Request::get('type')?'':'checked=""'}}>
                                            <label for="c0">{{__('admin.All')}}</label>
                                        </div>
                                    </fieldset>
                                </li>
                                @foreach(App\ServiceCategory::get() as $cat)
                                <li class="d-inline-block mr-2 mb-1">
                                    <fieldset>
                                        <div class="radio">
                                            <input type="radio" name="type" id="c{{$cat->id}}" value="{{$cat->id}}" {{Request::get('type')==$cat->id ?'checked=""':''}}>
                                            <label for="c{{$cat->id}}">{{$cat->{'name_'.$l} }}</label>
                                        </div>
                                    </fieldset>
                                </li>
                                @endforeach
                            </ul>
                            <!--/ search menu tab -->
                        </div>
                    </div>
                    <!-- Search Bar end -->
                    </form>
                    <!-- search result section -->
                    <div id="searchResults" class="py-0 search-results">
                        <div class="row">
                            <div class="col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ __('admin.Service')}}</th>
                                                    <th>{{ __('admin.Description')}}</th>
                                                    <th>{{ __('admin.Price')}}</th>
                                                    <th>{{ __('admin.Rate')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($services as $num=>$row)
                                                <tr>
                                                     <td>{{$num+1}}</td>
                                                     <td><a href="#" onclick="openservice({{$row->id}})">{{ $row->{'name_'.$l} }}</a></td>
                                                     <td>{{ substr(strip_tags($row->{'description_'.$l}),0,40) }}...</td>
                                                     <td>{{ $row->price }} EGP</td>
                                                     <td>{!!$row->totalRate()?str_repeat('<i class="bx bxs-star" style="color: #fc960f;"></i>',$row->totalRate()):''!!}</td>
                                                </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div> <!-- end of table -->
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- END: Content-->
    <!--Service Modal -->
    <div class="modal fade text-left" id="service-data" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="title"></h3>
                    <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="content-left">
                        <input type="hidden" id="sid" >
                        <p id="description"> </p>
                        <div>
                            <span class="text-bold-700">{{__('admin.Price')}}: </span>
                            <span id="price"></span>
                        </div>
                        <br>
                        <div class="form-group" id="showdates">
                            <label>{{__('admin.Request Date/ Time')}}:</label>
                            <input class='date width-200 form-control' type="text" name="datetime" id="date" value="" required autocomplete="off">
                        </div>
                        <br>
                        <fieldset class="form-label-group" style="display: none;" id="textarea" >
                            <textarea id="mycomment" class="form-control" rows="3" placeholder="{{__('admin.Add your note')}}"></textarea>
                            <label for="mycomment">{{__('admin.Add your note')}}</label>
                        </fieldset>

                        <div class=" d-inline-block mr-2 mb-1">
                            <input type="checkbox" id="checkboxGlow1" onclick="$('#textarea').toggle()">
                            <label for="checkboxGlow1">{{__('admin.Add comment')}}</label>
                        </div>
                    </div>
                    <div class="content-right">
                    <div id="simg"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success glow mr-auto ml-0" type="button" onclick="requestserv()">{{__('admin.Make a request')}}</button>
                    <button type="button" class="btn btn-light-primary" data-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">{{__('admin.Close')}}</span>
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
                        "oPaginate": {"sFirst":    "الأول", "sPrevious": "السابق", "sNext":     "التالي", "sLast":     "الأخير"},
                        "oAria": {"sSortAscending":  ": تفعيل لترتيب العمود تصاعدياً", "sSortDescending": ": تفعيل لترتيب العمود تنازلياً"}}} );});
        </script>
@endif
<script src="/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
<script src="/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>
<script src="/app-assets/js/scripts/datatables/datatable.js"></script>
<script src="/js/jquery.datetimepicker.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
        $('#date').datetimepicker({format:'Y-m-d H:i',onGenerate:function( ct ){
            jQuery(this).find('.xdsoft_date')
                .toggleClass('xdsoft_disabled');
        },
        maxDate:'{{date('Y/m/d',strtotime("-1 days"))}}',
        timepicker:true});
        function openservice(id) {
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                type: "POST", url: "/admin/directory/"+id,
                success: function (response) {
                    let img ='<img class="img-fluid" src="/191014/'+response.img_url+'">';
                    $('#title').text(response.name_{{$l}});
                    $('#description').html(response.description_{{$l}});
                    $('#simg').html(img);
                    $('#sid').val(response.id);
                    $('#price').html(response.price+' {{__('EGP')}}');
                    $('#service-data').modal('show');
                },
                error: function (error) {
                    console.log(error);
                    alert("Error Occurred, Try again!");
                }
            });
        }
        function requestserv() {
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            let id = $('#sid').val();
            let comment =  $('#mycomment').val();
            let datetime = $('#date').val();
          	if (!datetime) {
              alert ('{{__('admin.Adddatefirst')}}');
              return false;
            }
            console.log(id+'-'+comment);
            $.ajax({
                type: "POST", url: "/admin/servicerequest",
                data: {"id": id, "comment": comment,"datetime":datetime, },
                success: function (response) {
                    console.log(response);
                    $('#service-data').modal('hide');
                    displayMessage('{{__('admin.request sent')}}');
                },
                error: function (error) {
                    console.log(error);
                    alert("Error Occurred, Try again!");
                }
            });
        }
        function displayMessage(message) {
            toastr.success(message, '{{__('admin.Service request')}}');
        }

</script>

@stop
@section('pagescripts')
@stop