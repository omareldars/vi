@extends('layouts.admin')
@section('content')
<style>
    .users-view {
        padding: 0.5rem 0;
    }
    .table-borderless td {
        padding: 0.8rem  ;
    }
</style>
<!-- BEGIN: Content .users-view .table-borderless td -->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <!-- users view start -->
            <section class="users-view">
                <!-- users view media object start -->
                <div class="row">
                    <div class="col-12 col-sm-10">
                        <div class="media mb-2">
                            <a class="mr-1 shadow" data-toggle="modal" data-target="#MessageModal" href="javascript:void(0);">
                                <img src="/191014/{{$company->logo??'../app-assets/images/logo_placeholder.png'}}" alt="Logo" height="100">
                            </a>
                            <div class="media-body pt-25">
                                <h4 class="media-heading"><span class="users-view-name">{{ $company->{'name_'.$l} }}</span></h4>
                                <h5>
                                    {{ $company->state->{'name_'.$l} }}
                                </h5>
                                <h5>
                                    {{$company->city->{'name_'.$l} }}
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-2 px-0 d-flex justify-content-end align-items-center px-1 mb-2">
                        <a href="{{ url()->previous() }}" class="btn btn-sm mr-25 border"><i class="bx bx-arrow-back font-small-3"></i> </a>
                        @if (isset(Auth::user()->company()->first()->id) && $company->id == Auth::user()->company()->first()->id)
                            <a href="/admin/myCompany" class="btn btn-sm mr-25 border"><i class="bx bx-edit font-small-3"></i></a>
                        @else

                        <a data-toggle="modal" data-target="#MessageModal" href="javascript:void(0);" class="btn btn-sm mr-25 border"><i class="bx bx-envelope font-small-3"></i></a>
                        @endif
                    </div>
                </div>
                <!-- users view media object ends -->
                <div class="row">
                    <div class="col-md-12">
                        <!-- users view card details start -->
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="col-12">
                                        <h5 class="mb-1"><i class="bx bx-info-circle"></i> {{__('admin.Contact Info')}}</h5>
                                        <hr>
                                        <table class="table table-borderless table-hover">
                                            <tbody>
                                                <tr>
                                                    <td class="width-200">{{__('admin.Address')}}:</td>
                                                    <td>{{ $company->{'address_'.$l} }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('admin.Phone')}}:</td>
                                                    <td>{{ $company->phone }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('admin.Email')}}:</td>
                                                    <td>{{ $company->email }}</td>
                                                </tr>
                                                @if ($company->website)
                                                <tr>
                                                    <td>{{__('admin.Website')}}:</td>
                                                    <td><a href="{{ strpos($company->website,'http')===0?$company->website:'http://'.$company->website }}" target="_blank" >{{ $company->website }}</a></td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td>{{__('admin.Social Links')}}:</td>
                                                    <td>
                                                        @if ($company->facebook)
                                                            <a href="{{ strpos($company->facebook,"http")===0?$company->facebook:'http://'.$company->facebook }}"
                                                               target='_blank'><i class="bx bxl-facebook-square mr-50"></i>  </a>

                                                        @endif
                                                        @if ($company->twitter)
                                                            <a href="{{ strpos($company->twitter,"http")===0?$company->twitter:'http://'.$company->twitter }}"
                                                               target='_blank'><i class="bx bxl-twitter mr-50"></i>  </a>
                                                        @endif
                                                        @if ($company->youtube)
                                                                <a href="{{ strpos($company->youtube,"http")===0?$company->youtube:'http://'.$company->youtube }}"
                                                                   target='_blank'><i class="bx bxl-youtube mr-50"></i> </a>
                                                            @endif
                                                        @if ($company->linkedin)
                                                            <a href="{{ strpos($company->linkedin,"http")===0?$company->linkedin:'http://'.$company->linkedin }}"
                                                               target='_blank'><i class="bx bxl-linkedin-square mr-50"></i> </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
<br>
                                        <h5 class="mb-1"><i class="bx bx-user"></i> {{__('admin.Contact Person Info')}}</h5>
                                        <hr>
                                        <table class="table table-borderless table-hover mb-0">
                                            <tbody>
                                                <tr>
                                                    <td class="width-200">{{__('admin.Name')}}: </td>
                                                    <td>{{ $company->user->{'first_name_'.$l} }}
                                                        {{ $company->user->{'last_name_'.$l} }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('admin.Phone')}}: </td>
                                                    <td>{{ $company->user->phone }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('admin.Email')}}: </td>
                                                    <td>{{ $company->user->email }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <br>
                                        <h5 class="mb-1"><i class="bx bx-link"></i> {{__('admin.Company profile')}}:</h5>
                                        <hr>
                                        <table class="table table-borderless table-hover">
                                            <tbody>
                                            <tr>
                                                <td class="width-200"> {{__('admin.Sector')}}:</td>
                                                <td>{{ __($company->sector) }}</td>
                                            </tr>
                                                <tr>
                                                    <td class="width-200"> {{__('admin.Established date')}}:</td>
                                                    <td>{{ $company->est_date }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('admin.Idea')}}:</td>
                                                    <td> {{ $company->idea }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('admin.Problem')}}:</td>
                                                    <td> {{ $company->problem }} </td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('admin.solution')}}:</td>
                                                    <td> {{ $company->solution }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('admin.Team number')}}:</td>
                                                    <td> {{ $company->team_num }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('admin.Stage')}}:</td>
                                                    <td> {{ $company->stage }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('admin.raised_fund')}}:</td>
                                                    <td> {{ $company->raised_fund }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('admin.investors')}}:</td>
                                                    <td> {{ $company->investors }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('admin.founder')}}:</td>
                                                    <td> {{ $company->founder }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('admin.Number of employees')}}:</td>
                                                    <td> {{ $company->employees }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @if($company->cycle)
                                        @role('Admin')
                                            <br>
                                            <h5 class="mb-1"><i class="bx bx-link"></i> {{__('admin.Cycle informations')}}:</h5>
                                            <hr>
                                            <table class="table table-borderless table-hover">
                                                <tbody>
                                                <tr>
                                                    <td class="width-200"> {{__('admin.Cycle')}}:</td>
                                                    <td>{{ $company->cycledata->title }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('admin.Current Step')}}:</td>
                                                    <td><b>{{ $company->stepdata->arr??'Step' }}:</b> {{ $company->stepdata->title??' Not Exist' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('admin.Screening result')}}:</td>
                                                    <td>
                                                        @php
                                                        $form = \App\Step::where('cycle_id',$company->cycle)->where('stype',1)->orderBy('arr')->first(['id']);
                                                        $weight=$company->companyWeight($company->id,$form->id,0);
                                                        $judges = $company->judges($company->id,$form->id);
                                                        $judges = \App\User::whereIn('id',$judges)->get();
                                                        @endphp
                                                        <span class="badge badge-light-{{$weight<25?'danger':($weight<50?'warning':'success') }}"> {{$weight}} %</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        {{ __('admin.Screening by')}}:
                                                    </td>
                                                    <td>
                                                        @foreach($judges as $ju)
                                                        ({{$ju->id}}){{$ju->{'first_name_'.$l} }} {{$ju->{'last_name_'.$l} }},
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            @php($fdata=\App\Formdata::where('user_id', $company->user->id)->get())
@if (count($fdata)>0)
                                                <br>
                                                <h5 class="mb-1"><i class="bx bx-link"></i> {{__('admin.Data collected through Cycle')}}:</h5>
                                                <hr>
                                                <table class="table table-borderless table-hover">
                                                    <tbody>
@foreach($fdata as $field)
                                                    <tr>
                                                        <td class="width-200"> {{$field->question}}:</td>
                                                        <td>
                                                            {!! strpos($field->answer,"http")===0? '<a target="_blank" href="'.$field->answer.'"> '. __('admin.Download File').' </a>' : $field->answer !!}
                                                            @php($comments=\App\Formdata::where('field_id', $field->field_id)->where('company_id', $company->id)->first(['comments'])->comments)
                                                             @foreach($comments as $key=>$cc)
                                                            @if ($cc)
                                                                    <div class="warning">{{__('admin.comment')}}({{$key}}): {{$cc}}</div>
                                                            @endif
                                                            @endforeach
                                                            </td>
                                                    </tr>
@endforeach
                                                    </tbody>
                                                </table>
@endif
                                        @endrole
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- users view card details ends -->
                    </div>
                </div>
            </section>
            <!-- users view ends -->
        </div>
    </div>
</div>
<!-- END: Content-->
<div class="modal fade text-left" id="MessageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">{{__('messages.SendMessageTo')}} {{ $company->user->{'first_name_'.$l} }}
                    {{ $company->user->{'last_name_'.$l} }} ({{ $company->{'name_'.$l} }}).</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <form method="post" action="/admin/send_message" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <input type="hidden" name="sender" value="{{Auth::user()->id}}">
                <input type="hidden" name="receiver" value="{{$company->user->id}}">
                <div class="modal-body">
                        <label>{{__('messages.Subject')}}:</label>
                        <div class="form-group">
                            <input name="subject" type="text" placeholder="{{__('messages.Subject')}}" class="form-control" required>
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
@stop
@section('pagescripts')

@stop
