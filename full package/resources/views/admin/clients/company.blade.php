@extends('layouts.admin')
@section('title', __('admin.My company') )
@section('subTitle', __('admin.Edit the Company information'))
@section('content')
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.min.css">
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        @include('admin.includes.heading')
        <div class="content-body">
            <form method="post" action="{{route('update_my_company')}}" enctype="multipart/form-data">
            <!-- BuilderForm start -->
            <section id="basic-input">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('admin.Edit the Company information')}}</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    @if(session()->has('msg'))
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="alert alert-{{Session::get('class')}} alert-dismissible  mb-2" role="alert">
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <div class="d-flex align-items-center">
                                                    <i class="bx bx-error"></i>
                                                    <span>
                                                        {{ __('admin.'.session()->get('msg')) }}
                                                        {{ Session::forget('msg') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <!-- Validation messages -->
                                    @if(count($errors) >0)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach($errors->all() as $error)
                                                    <li>{{ $error }} </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                        {!! csrf_field() !!}
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-label-group mt-75">
                                                    <input style="direction: ltr" value="{{($client->company)? $client->company->name_en:old('name_en')}}"
                                                        name="name_en" type="text" class="form-control"
                                                        id="name_en"
                                                        placeholder="{{ __('admin.English Name') }} *" required
                                                        autocomplete="name_en" />
                                                    <label for="name_en">{{ __('admin.English Name')}} *</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                        <div class="form-label-group mt-75">
                                                    <input style="direction: rtl;" value="{{($client->company)? $client->company->name_ar:old('name_ar')}}"
                                                        name="name_ar" type="text" class="form-control"
                                                        id="name_ar"
                                                        placeholder="{{ __('admin.Arabic Name') }} *" required
                                                        autocomplete="name_ar" />
                                                    <label for="name_ar">{{__('admin.Arabic Name')}} *</label>

                                                </div>
                                            </div>
                                            @php
                                                $name = 'name_'.$l;
                                                if($client->company) {$stateID = $client->company->state_id;} else {$stateID=0;}
                                            @endphp
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="state_id">{{ __('admin.State')}} *</label>
                                                        <select class="form-control" required
                                                            id="state_id" name='state_id'>
                                                            <option value="">{{ __('admin.State')}}</option>
                                                            @foreach($states as $state)
                                                                <option value="{{$state->id}}" {{($state->id==$stateID)? 'selected':''}}>{{$state->$name}}</option>
                                                            @endforeach
                                                        </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="city_id">{{ __('admin.City')}} *</label>
                                                        <select class="form-control" required
                                                            id="city_id" name='city_id'>
                                                            <option value="">{{ __('admin.City')}} </option>
                                                            @php $name = 'name_'.$l; @endphp
                                                            @if(isset($client->company) &&  $client->company->city_id != null)
                                                                <option value="{{$client->company->city_id}}" selected> {{$client->company->city->{'name_'.$l} }}</option>
                                                            @endif
                                                        </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="sector">{{ __('admin.Sector')}} *</label>
                                                    <select id="selectsector" class="form-control" required onchange="ssector(this.options[this.selectedIndex].value)" name='sector'>
                                                        <option value="{{($client->company)? $client->company->sector:''}}">{{($client->company)? __($client->company->sector): __('admin.Select Sector') }}</option>
                                                        <option value="Industrial">{{ __('Industrial')}}</option>
                                                        <option value="Agriculture">{{ __('Agriculture')}}</option>
                                                        <option value="Commercial">{{ __('Commercial')}}</option>
                                                        <option value="Technology">{{ __('Technology')}}</option>
                                                        <option value="Other">{{ __('Other')}}</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="address_en">{{ __('admin.English Address')}} *</label>
                                                    <textarea style="direction: ltr" class="form-control" id="address_en" name='address_en'
                                                        required placeholder="{{__('admin.English Address')}} *"
                                                        >{{($client->company)? $client->company->address_en:old('address_en')}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="address_ar">{{ __('admin.Arabic Address')}} *</label>
                                                    <textarea style="direction: rtl;" class="form-control" id="address_ar" name='address_ar'
                                                        required placeholder="{{__('admin.Arabic Address')}} *"
                                                        >{{($client->company)? $client->company->address_ar:old('address_ar')}}</textarea>
                                                    <br>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-label-group">
                                                    <input type="text" class="form-control" id="phone"
                                                        placeholder="{{ __('admin.Phone') }}*" value="{{($client->company)? $client->company->phone : old('phone')}}" name="phone" required 
                                                         autocomplete="new-phone">
                                                    <label for="phone">{{ __('admin.Phone') }}*</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-label-group">
                                                    <input type="text" class="form-control" id="fax"
                                                           placeholder="{{ __('admin.Fax') }}" value="{{($client->company)? $client->company->fax:old('fax')}}" name="fax"
                                                            autocomplete="new-fax">
                                                    <label for="fax">{{ __('admin.Fax') }}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-label-group mt-75">
                                                    <input type="text" class="form-control" id="est_date"
                                                            value="{{($client->company)? $client->company->est_date:old('est_date')}}" name="est_date" >
                                                    <label for="est_date">{{ __('admin.est_date') }}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-label-group mt-75">
                                                    <input type="number" class="form-control" id="team_num"
                                                           placeholder="{{ __('admin.team_num') }}" value="{{($client->company)? $client->company->team_num:old('team_num')}}" name="team_num"
                                                            autocomplete="new-team_num">
                                                    <label for="team_num">{{ __('admin.team_num') }}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-label-group mt-75">
                                                    <input type="text" class="form-control" id="stage"
                                                           placeholder="{{ __('admin.stage') }}" value="{{($client->company)? $client->company->stage:old('stage')}}" name="stage"
                                                           autocomplete="new-stage">
                                                    <label for="stage">{{ __('admin.stage') }}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-label-group mt-75">
                                                    <input type="number" class="form-control" id="raised_fund"
                                                           placeholder="{{ __('admin.raised_fund_egp') }}" value="{{($client->company)? $client->company->raised_fund:old('raised_fund')}}" name="raised_fund"
                                                           autocomplete="raised_fund">
                                                    <label for="raised_fund">{{ __('admin.raised_fund_egp') }}</label>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-12">
                                                <div class="form-label-group mt-75">
                                                    <input style="direction: ltr" type="email" class="form-control" id="email"
                                                           placeholder="{{ __('admin.E-mail') }} *"
                                                           value="{{($client->company)? $client->company->email:old('email')}}"
                                                           name="email"
                                                           required autocomplete="new-email">
                                                    <label for="email">{{ __('admin.E-mail') }} *</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="form-label-group mt-75">
                                                    <input type="text" class="form-control" id="investors"
                                                           placeholder="{{ __('admin.investors') }}"
                                                           value="{{($client->company)? $client->company->investors:old('investors')}}"
                                                           name="investors"
                                                           autocomplete="new-investors">
                                                    <label for="investors">{{ __('admin.investors') }}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="form-label-group mt-75">
                                                    <input type="text" class="form-control" id="founder"
                                                           placeholder="{{ __('admin.founder') }}"
                                                           value="{{($client->company)? $client->company->founder:old('founder')}}"
                                                           name="founder"
                                                           autocomplete="new-founder">
                                                    <label for="founder">{{ __('admin.founder') }}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="idea">{{ __('admin.idea')}}</label>
                                                    <textarea class="form-control" id="idea" name='idea' placeholder="{{__('admin.idea')}}">{{($client->company)? $client->company->idea:old('idea')}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="problem">{{ __('admin.problem')}}</label>
                                                    <textarea class="form-control" id="problem" name='problem' placeholder="{{__('admin.problem')}}">{{($client->company)? $client->company->problem:old('problem')}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="problem">{{ __('admin.solution')}}</label>
                                                    <textarea class="form-control" id="solution" name='solution' placeholder="{{__('admin.solution')}}">{{($client->company)? $client->company->solution:old('solution')}}</textarea>
                                                </div>
                                            </div>

                                            </div>

                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit"
                                                    class="btn btn-primary mr-1 mb-1">{{__('admin.Update')}}</button>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- BuilderForm end -->
            <!-- BuilderForm start -->
            <section id="basic-input">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('More Details')}}</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                        <div class="row">

                                            <div class="col-md-12 col-12">
                                                @if (isset($client->company->logo))
                                                    <img src="/191014/{{$client->company->logo}}" alt="Company logo" height="80px">
                                                @endif
                                                    <div class="form-group mt-75">
                                                        <label for="basicInput">{{ __('admin.Logo')}}</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                            <span class="input-group-text"
                                                                  id="inputGroupFileAddon01">{{ __('admin.Upload')}}</span>
                                                            </div>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="img_url"
                                                                       name="img_url" accept="image/*" style="direction: ltr;"
                                                                       aria-describedby="inputGroupFileAddon00">
                                                                <label class="custom-file-label"
                                                                       for="inputGroupFile00">{{ __('admin.Select image file')}}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="col-md-12 col-12 mt-75">
                                                <div class="form-label-group">
                                                    <input style="direction: ltr" type="text" class="form-control" id="facebook"
                                                           placeholder="{{ __('admin.Website') }}"
                                                           value="{{($client->company)? $client->company->website:old('website')}}"
                                                           name="website"
                                                           autocomplete="website">
                                                    <label for="facebook">{{ __('admin.website') }}</label>
                                            </div>
                                            </div>
                                                 <div class="col-md-12 col-12 mt-75">
                                                    <div class="form-label-group">
                                                    <input style="direction: ltr" type="text" class="form-control" id="facebook"
                                                           placeholder="{{ __('admin.Facebook') }}"
                                                           value="{{($client->company)? $client->company->facebook:old('facebook')}}"
                                                           name="facebook"
                                                           autocomplete="facebook">
                                                        <label for="facebook">{{ __('admin.Facebook') }}</label>
                                                    </div>
                                                 </div>
                                            <div class="col-md-12 col-12 mt-75">
                                                <div class="form-label-group">
                                                    <input style="direction: ltr" type="text" class="form-control" id="twitter"
                                                           placeholder="{{ __('admin.Twitter') }}"
                                                           value="{{($client->company)? $client->company->twitter:old('twitter')}}"
                                                           name="twitter"
                                                           autocomplete="twitter">
                                                    <label for="twitter">{{ __('admin.Twitter') }}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12 mt-75">
                                                <div class="form-label-group">
                                                    <input style="direction: ltr" type="text" class="form-control" id="linkedin"
                                                           placeholder="{{ __('admin.Linkedin') }}"
                                                           value="{{($client->company)? $client->company->linkedin:old('linkedin')}}"
                                                           name="linkedin"
                                                           autocomplete="new-linkedin">
                                                    <label for="linkedin">{{ __('admin.Linkedin') }}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12 mt-75">
                                                <div class="form-label-group">
                                                    <label for="">{{ __('admin.Youtube') }}</label>
                                                    <input style="direction: ltr" type="text" class="form-control" id="youtube"
                                                           placeholder="{{ __('admin.Youtube') }}"
                                                           value="{{($client->company)? $client->company->youtube:old('youtube')}}"
                                                           name="youtube"
                                                           autocomplete="new-youtube">
                                                    <label for="youtube">{{ __('admin.Youtube') }}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12 mt-75">
                                                <div class="form-group">
                                                    <label for="google_map">{{ __('admin.Google Map') }}</label>
                                                    <textarea style="direction: ltr" class="form-control height-100" id="google_map" name='google_map'
                                                              placeholder="{{__('admin.Google Map full URL')}}"
                                                    >{{($client->company)? $client->company->google_map:old('google_map')}}</textarea>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit"
                                                        class="btn btn-primary mr-1 mb-1">{{__('admin.Update')}}</button>
                                            </div>
                                        </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- BuilderForm end -->
            </form>
        </div>
    </div>
</div>
<!-- END: Content-->
@stop
@section('pagescripts')
<script src="/js/jquery.datetimepicker.full.min.js"></script>
<script>
$(document).ready(function() {
  	$('#est_date').datetimepicker({timepicker:false,format:'Y-m-d'});
    $('#state_id').change(function() {
        var $city = $('#city_id');
        var currentCity = '{{ ($client->company)? $client->company->city_id:0 }}';
        var selected = '';

        $.ajax({
            url: "{{ route('cities.index') }}",
            data: {
                state_id: $(this).val()
            },
            success: function(data) {
                $city.html('<option value="" >{{ __('admin.City')}}</option>');
                $.each(data, function(id, value) {
                    if(currentCity == id){
                        selected = 'selected';
                    }else{
                        selected = '';
                    }

                    $city.append('<option value="'+id+' '+selected+'">'+value+'</option>');
                });
                $('#city').show(150);
            }
        });
    });
});
</script>
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#logo').filemanager(['image']);
    function ssector(selection) {
        if (selection === 'other') {
            let other = prompt('{{__('Enter your company sector name')}}');
            if (other) {
            let newItem = "<option selected value='" + other + "'>" + other + "</option>";
            $('#selectsector').append(newItem);
            } else {
             $('#selectsector').val('Industrial');
            }
        }
    }
</script>
@stop
