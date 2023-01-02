@extends('layouts.admin')
@section('content')
  <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0">{{__('messages.NewMessage')}}</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/admin"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active">{{__('messages.SendMessages')}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section>
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header border-bottom">

                                    <h4 class="card-title d-flex align-items-center">
                                        <i class='bx bx-message-dots font-medium-4 mr-1'></i>{{__('messages.SendMessages')}}</h4>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li>
                                                <a data-action="close">
                                                    <i class="bx bx-x"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
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
                                    <form method="post" action="/admin/sendmessage" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            {!! csrf_field() !!}
                                    <h4 class="card-title d-flex align-items-center">
                                        <i class='bx bx-user-plus font-medium-4 mr-1'></i>{{__('messages.SelectUsers')}}</h4>
                                            <ul class="list-unstyled mb-0">
                                                <li class="d-inline-block mr-2 mb-1">
                                                    <fieldset>
                                                        <div class="radio radio-shadow">
                                                            <input value="0" type="radio" id="radioshadow1" name="type" checked="" onclick="menus(0)">
                                                            <label for="radioshadow1">{{__('messages.PortalManagers')}}</label>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                @if($users)
                                                <li class="d-inline-block mr-2 mb-1">
                                                    <fieldset>
                                                        <div class="radio radio-shadow">
                                                            <input value="1" type="radio" id="radioshadow2" name="type" onclick="menus(1)" >
                                                            <label for="radioshadow2">{{__('messages.CycleUsers')}}</label>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                @endif
                                                @if($mentors)
                                                <li class="d-inline-block mr-2 mb-1">
                                                    <fieldset>
                                                        <div class="radio radio-shadow">
                                                            <input value="2" type="radio" id="radioshadow3" name="type" onclick="menus(2)">
                                                            <label for="radioshadow3">{{__('messages.Mentors')}}</label>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                @endif
                                            </ul>
                                            <div class="form-group" style="display: none;" id="users">
                                                @if($users)
                                                <select class="select2 form-control" name="users[]" multiple>
                                                    @foreach($users as $user)
                                                        <option value="{{$user->user->id}}">{{$user->user->{'first_name_'.$l} .' '.$user->user->{'last_name_'.$l} .' - ('. $user->{'name_'.$l}.')' }}</option>
                                                    @endforeach
                                                </select>
                                                 @endif
                                            </div>
                                            <div class="form-group" style="display: none;" id="mentors">
                                                @if($mentors)
                                                <select class="select2 form-control" name="mentors[]" multiple>
                                                    @foreach($mentors as $mentor)
                                                        <option value="{{$mentor->id}}">{{$mentor->{'first_name_'.$l} .' '.$mentor->{'last_name_'.$l} }}</option>
                                                    @endforeach
                                                </select>
                                                @endif
                                            </div>
                                            <label>{{__('messages.Subject')}}</label>
                                            <div class="form-group">
                                                <input name="subject" type="text" placeholder="{{__('messages.Subject')}}" class="form-control" required="">
                                            </div>
                                            <label>{{__('messages.yourMessage')}}:</label>
                                            <div class="form-group">
                            <textarea class="form-control" name='message' rows="8"
                                      placeholder="{{__('messages.Write your message')}}" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary send-btn">
                                                <i class="bx bx-send mr-25"></i>
                                                <span class="d-none d-sm-inline"> {{__('messages.Send')}}</span>
                                            </button>
                                        </div>
                                    </form>
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
@section('scripts')
<script>
    function menus(menu) {
        if (menu===1) {
            $('#users').show();
            $('#mentors').hide();
        } else if (menu===2) {
            $('#users').hide();
            $('#mentors').show();
        } else {
            $('#users').hide();
            $('#mentors').hide();
        }
    }
</script>

@stop
