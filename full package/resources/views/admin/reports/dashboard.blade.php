@extends('layouts.admin')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Users -->
                <section class="multiple-select2">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{__('admin.Download')}} {{__('admin.UsersReports')}}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form" id="basicForm" action="/reports/users" method="POST" enctype="multipart/form-data">
                                            {!! csrf_field() !!}
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6>{{__('admin.SelType')}}</h6>
                                                    <label for="utype">{{__('admin.SelMulti')}}:</label>
                                                    <div class="form-group">
                                                        <select id="utype" name="type[]" class="select2 form-control" multiple="multiple">
                                                            <option value="2">{{__('admin.Editor')}}</option>
                                                            <option value="3">{{__('admin.Coordinator')}}</option>
                                                            <option value="4">{{__('admin.Page Manager')}}</option>
                                                            <option value="5">{{__('admin.Manager')}}</option>
                                                            <option value="6">{{__('admin.Mentor')}}</option>
                                                            <option value="7">{{__('admin.Judger')}}</option>
                                                            <option value="8">{{__('admin.Registered')}}</option>
                                                            <option value="9">{{__('admin.Pages Editor')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <p>{{__('admin.ChooseGender')}}</p>
                                                        <ul class="list-unstyled mb-0">
                                                            <li class="d-inline-block mr-2 mb-1">
                                                                <fieldset>
                                                                    <div class="radio">
                                                                        <input type="radio" name="gender" value="" id="rad0" checked="">
                                                                        <label for="rad0">{{__('admin.All')}}</label>
                                                                    </div>
                                                                </fieldset>
                                                            </li>
                                                            <li class="d-inline-block mr-2 mb-1">
                                                                <fieldset>
                                                                    <div class="radio">
                                                                        <input type="radio" name="gender" value="Male" id="rad1">
                                                                        <label for="rad1">{{__('admin.Male')}}</label>
                                                                    </div>
                                                                </fieldset>
                                                            </li>
                                                            <li class="d-inline-block mr-2 mb-1">
                                                                <fieldset>
                                                                    <div class="radio">
                                                                        <input type="radio" name="gender" value="Female" id="rad2">
                                                                        <label for="rad2">{{__('admin.Female')}}</label>
                                                                    </div>
                                                                </fieldset>
                                                            </li>
                                                        </ul>
                                                        <fieldset>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" name="details" id="details">
                                                                <label class="custom-control-label" for="details">تفصيلي</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            <div class="card-content">
                                                <div class="card-body">
                                                    <p>{{__('admin.ReportLang')}}</p>
                                                    <ul class="list-unstyled mb-0">
                                                        <li class="d-inline-block mr-2 mb-1">
                                                            <fieldset>
                                                                <div class="radio">
                                                                    <input type="radio" name="lang" value="ar" id="radio1" checked="">
                                                                    <label for="radio1">{{__('admin.Arabic')}}</label>
                                                                </div>
                                                            </fieldset>
                                                        </li>
                                                        <li class="d-inline-block mr-2 mb-1">
                                                            <fieldset>
                                                                <div class="radio">
                                                                    <input type="radio" name="lang" value="en" id="radio2">
                                                                    <label for="radio2">{{__('admin.English')}}</label>
                                                                </div>
                                                            </fieldset>
                                                        </li>
                                                    </ul>
                                                    <button type="submit" class="btn btn-primary">{{__('admin.Download')}}</button>
                                                </div>
                                            </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                </div>
                        </div>
                    </div>
                </section>
                <!-- Users end -->
                <!-- Companies start -->
                <section class="multiple-select2">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{__('admin.Download')}} {{__('admin.Company`s Reports')}} </h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form" id="basicForm2" action="/reports/companies" method="POST" enctype="multipart/form-data">
                                            {!! csrf_field() !!}
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h6>{{__('admin.SelState')}}</h6>
                                                    <label for="state">{{__('admin.SelMultiState')}}:</label>
                                                    <div class="form-group">
                                                        <select name="state[]" id="state" class="select2 form-control" multiple="multiple">
                                                            @foreach(App\State::get() as $type)
                                                                <option value="{{$type->id}}">{{$type->{'name_'.$l} }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <p>{{__('admin.Type')}}</p>
                                                        <ul class="list-unstyled mb-0">
                                                            <li class="d-inline-block mr-2 mb-1">
                                                                <fieldset>
                                                                    <div class="radio">
                                                                        <input type="radio" name="type" value="" id="type0" checked="">
                                                                        <label for="type0">{{__('admin.All')}}</label>
                                                                    </div>
                                                                </fieldset>
                                                            </li>
                                                            <li class="d-inline-block mr-2 mb-1">
                                                                <fieldset>
                                                                    <div class="radio">
                                                                        <input type="radio" name="type" value="new" id="type1">
                                                                        <label for="type1">{{__('admin.New only')}}</label>
                                                                    </div>
                                                                </fieldset>
                                                            </li>
                                                            <li class="d-inline-block mr-2 mb-1">
                                                                <fieldset>
                                                                    <div class="radio">
                                                                        <input type="radio" name="type" value="cycle" id="type2">
                                                                        <label for="type2">{{__('admin.Join Cycle')}}</label>
                                                                    </div>
                                                                </fieldset>
                                                            </li>
                                                            <li class="d-inline-block mr-2 mb-1">
                                                                <fieldset>
                                                                    <div class="radio">
                                                                        <input type="radio" name="type" value="approved" id="type3">
                                                                        <label for="type3">{{__('admin.Approved')}}</label>
                                                                    </div>
                                                                </fieldset>
                                                            </li>
                                                        </ul>
                                                        <fieldset class="float-left">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" name="details" id="details2">
                                                                <label class="custom-control-label" for="details2">تفصيلي</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>

                                                </div>

                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <p>{{__('admin.ReportLang')}}</p>
                                                        <ul class="list-unstyled mb-0">
                                                            <li class="d-inline-block mr-2 mb-1">
                                                                <fieldset>
                                                                    <div class="radio">
                                                                        <input type="radio" name="lang" value="ar" id="r1" checked="">
                                                                        <label for="r1">{{__('admin.Arabic')}}</label>
                                                                    </div>
                                                                </fieldset>
                                                            </li>
                                                            <li class="d-inline-block mr-2 mb-1">
                                                                <fieldset>
                                                                    <div class="radio">
                                                                        <input type="radio" name="lang" value="en" id="r2">
                                                                        <label for="r2">{{__('admin.English')}}</label>
                                                                    </div>
                                                                </fieldset>
                                                            </li>

                                                        </ul>

                                                    </div>
                                                    <button type="submit" class="btn btn-primary">{{__('admin.Download')}}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Companies end -->
                <!-- Services -->
                <section class="multiple-select2">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{__('admin.ServicesReports')}}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form" id="basicForm" action="/reports/services" method="POST" enctype="multipart/form-data">
                                            {!! csrf_field() !!}
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6>{{__('admin.SelCat')}}</h6>
                                                    <label for="cat">{{__('admin.Servcat')}}:</label>
                                                    <div class="form-group">
                                                        <select id="cat" name="cat[]" class="select2 form-control" multiple="multiple">
                                                            @foreach(\App\ServiceCategory::get() as $servcat)
                                                            <option value="{{$servcat->id}}">{{$servcat->{'name_'.$l} }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <p>{{__('admin.ReportLang')}}</p>
                                                        <ul class="list-unstyled mb-0">
                                                            <li class="d-inline-block mr-2 mb-1">
                                                                <fieldset>
                                                                    <div class="radio">
                                                                        <input type="radio" name="lang" value="ar" id="radios1" checked="">
                                                                        <label for="radios1">{{__('admin.Arabic')}}</label>
                                                                    </div>
                                                                </fieldset>
                                                            </li>
                                                            <li class="d-inline-block mr-2 mb-1">
                                                                <fieldset>
                                                                    <div class="radio">
                                                                        <input type="radio" name="lang" value="en" id="radios2">
                                                                        <label for="radios2">{{__('admin.English')}}</label>
                                                                    </div>
                                                                </fieldset>
                                                            </li>
                                                        </ul>
                                                        <button type="submit" class="btn btn-primary">{{__('admin.Download')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Services end -->
                <!-- Mentors -->
                <section class="multiple-select2">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{__('admin.MentorsReports')}}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form" id="basicForm" action="/reports/mentors" method="POST" enctype="multipart/form-data">
                                            {!! csrf_field() !!}
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6>{{__('admin.SelSort')}}</h6>
                                                    <label for="sort">{{__('admin.SortBy')}}:</label>
                                                    <div class="form-group">
                                                        <select id="sort" name="sort" class="select2 form-control" >
                                                                <option value="first_name">{{__('admin.Name')}}</option>
                                                                <option value="id">{{__('admin.Join Date')}}</option>
                                                                <option value="title">{{__('admin.Job')}}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <p>{{__('admin.ReportLang')}}</p>
                                                        <ul class="list-unstyled mb-0">
                                                            <li class="d-inline-block mr-2 mb-1">
                                                                <fieldset>
                                                                    <div class="radio">
                                                                        <input type="radio" name="lang" value="ar" id="radiom1" checked="">
                                                                        <label for="radiom1">{{__('admin.Arabic')}}</label>
                                                                    </div>
                                                                </fieldset>
                                                            </li>
                                                            <li class="d-inline-block mr-2 mb-1">
                                                                <fieldset>
                                                                    <div class="radio">
                                                                        <input type="radio" name="lang" value="en" id="radiom2">
                                                                        <label for="radiom2">{{__('admin.English')}}</label>
                                                                    </div>
                                                                </fieldset>
                                                            </li>
                                                        </ul>
                                                        <button type="submit" class="btn btn-primary">{{__('admin.Download')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Mentors end -->
                <!-- Screening -->
                <section class="multiple-select2">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{__('admin.ScreeningResults')}}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form" id="basicForm" action="/reports/screening" method="POST" enctype="multipart/form-data">
                                            {!! csrf_field() !!}
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="step">{{__('admin.SelStep')}}:</label>
                                                    <div class="form-group">
                                                        <select id="step" name="step" class="select2 form-control">
                                                            @foreach(\App\Step::where('stype',1)->get() as $step)
                                                                <option value="{{$step->id}}">{{$step->title}} - ({{$step->cycle->title}} - {{__('cycles.Start')}} {{$step->from->format('d-m')}})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <p>{{__('admin.ReportLang')}}</p>
                                                        <ul class="list-unstyled mb-0">
                                                            <li class="d-inline-block mr-2 mb-1">
                                                                <fieldset>
                                                                    <div class="radio">
                                                                        <input type="radio" name="lang" value="ar" id="radiost1" checked="">
                                                                        <label for="radiost1">{{__('admin.Arabic')}}</label>
                                                                    </div>
                                                                </fieldset>
                                                            </li>
                                                            <li class="d-inline-block mr-2 mb-1">
                                                                <fieldset>
                                                                    <div class="radio">
                                                                        <input type="radio" name="lang" value="en" id="radiost2">
                                                                        <label for="radiost2">{{__('admin.English')}}</label>
                                                                    </div>
                                                                </fieldset>
                                                            </li>
                                                        </ul>
                                                        <button type="submit" class="btn btn-primary">{{__('admin.Download')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Screening end -->
            </div>
        </div>
    </div>
    <!-- END: Content-->
@stop