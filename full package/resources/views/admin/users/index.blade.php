@extends('layouts.admin')
@section('style')
<link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/tables/datatable/datatables.min.css">
@stop
@section('title', __('admin.Users') )
@section('subTitle', __('admin.Users`s List'))
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('admin.Users')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active">{{__('admin.Users`s List')}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-header row">
                @if(session()->has('msg'))

                        <div class="col-md-12">
                            <div class="alert alert-success alert-dismissible mb-2" role="alert">
                                <button type="button" class="close" data-dismiss="alert"
                                        aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-like"></i>
                                    <span>
                                        {{ __('admin.'.session()->get('msg')) }}
                                        {{ Session::forget('msg') }}
                                                        </span>
                                </div>
                            </div>
                        </div>

                @endif
            </div>
            <div class="content-body">
                <!-- users list start -->
                <section class="users-list-wrapper">
                    <div class="users-list-filter px-1">
                        <form>
                            <div class="row border rounded py-2 mb-2">
                                <div class="col-12 col-sm-3 col-lg-3">
                                    <label for="users-list-verified">{{__('admin.HaveCompany')}}</label>
                                    <fieldset class="form-group">
                                        <select class="form-control" id="users-list-verified">
                                            <option value="">{{__('admin.All')}}</option>
                                            <option value="{{__('admin.Yes')}}">{{__('admin.Yes')}}</option>
                                            <option value="{{__('admin.No')}}">{{__('admin.No')}}</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-12 col-sm-3 col-lg-3">
                                    <label for="users-list-role">{{__('admin.Role')}}</label>
                                    <fieldset class="form-group">
                                        <select class="form-control" id="users-list-role">
                                            <option value="">{{__('admin.All')}}</option>
                                            @foreach(App\Role::get() as $role)
                                            <option value="{{$role->name}}">{{__('admin.'.$role->name)}}</option>
                                            @endforeach
                                            <option value="Not Verified">{{__('admin.NotVerified')}}</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-12 col-sm-3 col-lg-3">
                                    <label for="users-list-status">{{__('admin.Gender')}}</label>
                                    <fieldset class="form-group">
                                        <select class="form-control" id="users-list-status">
                                            <option value="">{{__('admin.All')}}</option>
                                            <option value="{{__('admin.Male')}}">{{__('admin.Male')}}</option>
                                            <option value="{{__('admin.Female')}}">{{__('admin.Female')}}</option>
                                        </select>
                                    </fieldset>
                                </div>

                        </form>
                                <div class="col-12 col-sm-3 col-lg-2 offset-sm-2 offset-lg-1 d-flex align-items-center">
                                <a href="{{route('users.create')}}" class="btn btn-block btn-success">
                                    {{ __('admin.Add New')}}
                                </a>
                                </div>
                            </div>

                    </div>
                    <div class="users-list-table">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <!-- datatable start -->
                                    <div class="table-responsive">
                                        <table id="users-list-datatable" class="table">
                                            <thead>
                                            <tr class="table-light">
                                                <th>#</th>
                                                <th>{{__('admin.Name')}}</th>
                                                <th>{{__('admin.Email')}}</th>
                                                <th>{{__('admin.Phone')}}</th>
                                                <th>{{__('admin.Gender')}}</th>
                                                <th>{{__('admin.Role')}}</th>
                                                <th>{{__('admin.HaveCompany')}}</th>
                                                <th>{{__('admin.Date')}}</th>
                                                <th>@can('delete_user'){{__('admin.Delete')}}@endcan</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($users as $user)
                                            <tr>
                                                <td><a href="{{route('users.edit', ['id' => $user->id])}}">{{$user->id}}</a></td>
                                                <td style="font-size: small;"><a href="{{route('users.edit', ['id' => $user->id])}}"> {{$user->{'first_name_'.$l} }} {{$user->{'last_name_'.$l} }}</a></td>
                                                <td style="font-size: small;">{{$user->email}}</td>
                                                <td style="font-size: small;">{{$user->phone}}</td>
                                                <td style="font-size: small;">{{__('admin.'.$user->gender)}}</td>
                                                <td style="font-size: small;">{{$user->email_verified_at?$user->roles->first()->name:'Not Verified'}}</td>
                                                <td style="font-size: small;">{{$user->company?__('admin.Yes'):__('admin.No')}}</td>
                                                <td style="font-size: small;">{{$user->created_at}}</td>
                                                <td style="padding: 0px;font-size: small;">
                                                    @can('delete_user')
                                                         <button id='deleteAction' data-id='{{$user->id}}' data-url="{{route('users.destroy', ['id' => $user->id])}}" type="button" class="btn btn-outline-danger btn-sm"><i class="bx bx-trash"> </i></button>
                                                    @endcan
                                                </td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- datatable ends -->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- users list ends -->
            </div>
        </div>
    </div>
    <!-- END: Content-->

@stop
@section('scripts')
<script src="/app-assets/js/scripts/pages/page-users.js"></script>
<script src="/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
<script src="/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>
<script src="/app-assets/js/scripts/datatables/datatable.js"></script>
<script src="/app-assets/js/scripts/modal/components-modal.js"></script>

<script>
 
    $(document).on("click", "#deleteAction", function (e) {
        var url = $(this).data('url');
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

                $.post(url, {'_method':'DELETE' , '_token':token},
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
