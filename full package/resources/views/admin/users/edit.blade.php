@extends('layouts.admin')
@section('title', __('admin.Users') )
@section('index_url', route('users.index') )
@section('subTitle', __('admin.Edit user'))
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        @include('admin.includes.heading')
        <div class="content-body">
            <!-- BuilderForm start -->
            <section id="basic-input">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('admin.Edit user')}}

                                        <a data-toggle="modal" data-target="#MessageModal" href="javascript:void(0);" class="btn btn-sm border float-right"><i class="bx bx-envelope font-small-3"></i></a>

                                </h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    @if(session()->has('msg'))
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="alert alert-warning alert-danger mb-2" role="alert">
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
                                    <form method="post" action="{{route('users.update', ['id' => $user->id])}}"
                                        enctype="multipart/form-data">
                                        {!! csrf_field() !!}
                                        @method('patch')
                                        <div class="row">
                                            <div class="col-md-12">

                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{ __('admin.English Name')}}</label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input value="{{ $user->first_name_en}}"
                                                                name="first_name_en" type="text" class="form-control"
                                                                id="first_name_en" style="direction: ltr;"
                                                                placeholder="{{ __('admin.First Name') }}" required
                                                                autocomplete="first_name_en" autofocus />
                                                        </div>
                                                        <div class="col-md-6">

                                                            <input value="{{ $user->last_name_en }}" name="last_name_en"
                                                                type="text" class="form-control" id="last_name_en" style="direction: ltr;"
                                                                placeholder="{{ __('admin.Last Name') }}" required
                                                                autocomplete="last_name_en" />
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{__('admin.Arabic Name')}}</label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input value="{{ $user->first_name_ar }}"
                                                                name="first_name_ar" type="text" class="form-control"
                                                                id="first_name_ar" style="direction: rtl;"
                                                                placeholder="{{ __('admin.First Name') }}" required
                                                                autocomplete="first_name_ar" autofocus />
                                                        </div>
                                                        <div class="col-md-6">

                                                            <input value="{{ $user->last_name_ar }}" name="last_name_ar"
                                                                type="text" class="form-control" id="last_name_ar" style="direction: rtl;"
                                                                placeholder="{{ __('admin.Last Name') }}" required
                                                                autocomplete="last_name_ar" />
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <ul class="list-unstyled mb-0">
                                                        <li class="d-inline-block mr-2 mb-1">
                                                            <fieldset>
                                                                <div class="radio">
                                                                    <input type="radio" name="gender" value="Male" id="g1" {{ $user->gender=='Male' ? 'checked=""' :''}} >
                                                                    <label for="g1">{{__('Male')}}</label>
                                                                </div>
                                                            </fieldset>
                                                        </li>
                                                        <li class="d-inline-block mr-2 mb-1">
                                                            <fieldset>
                                                                <div class="radio">
                                                                    <input type="radio" name="gender" value="Female" id="g2" {{ $user->gender=='Female' ? 'checked=""' :''}}>
                                                                    <label for="g2">{{__('Female')}}</label>
                                                                </div>
                                                            </fieldset>
                                                        </li>
                                                    </ul>
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label class="text-bold-600"
                                                        for="exampleInputEmail1">{{ __('admin.Email') }}</label>
                                                    <input value="{{ $user->email }}" name="email" type="email"
                                                        class="form-control" id="email" style="direction: ltr;"
                                                        placeholder="{{ __('admin.E-Mail') }}" required
                                                        autocomplete="email">
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label class="text-bold-600"
                                                        for="phone">{{ __('admin.Phone') }}</label>
                                                    <input type="text" class="form-control" id="phone" style="direction: ltr;"
                                                        placeholder="{{ __('admin.Phone') }}" value="{{ $user->phone }}" name="phone"
                                                        required autocomplete="new-phone">
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label class="text-bold-600"
                                                           for="title_ar">{{ __('admin.JobTitleAr') }}</label>
                                                    <input type="text" class="form-control" id="title_ar" style="direction: rtl;"
                                                           placeholder="{{ __('admin.JobTitleAr') }}" value="{{ $user->title_ar }}" name="title_ar"
                                                            autocomplete="title_ar">
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label class="text-bold-600"
                                                           for="title_en">{{ __('admin.JobTitleEn') }}</label>
                                                    <input type="text" class="form-control" id="title_en" style="direction: ltr;"
                                                           placeholder="{{ __('admin.JobTitleEn') }}" value="{{ $user->title_en }}" name="title_en"
                                                            autocomplete="title_en">
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label for="state_id">{{ __('admin.State')}}</label>
                                                    <select class="form-control"
                                                            id="state_id" name='state_id'>
                                                        <option value="">{{ __('admin.State')}}</option>
                                                        @foreach(\App\State::get() as $state)
                                                            <option value="{{$state->id}}" {{($state->id==$user->state_id)? 'selected':''}}>{{$state->{'name_'.$l} }}</option>
                                                        @endforeach
                                                    </select>
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label for="city_id">{{ __('admin.City')}}</label>
                                                    <select class="form-control"
                                                            id="city_id" name='city_id'>
                                                        <option value="">{{ __('admin.City')}}</option>
                                                        @php $name = 'name_'.$l; @endphp
                                                        @if($user->city_id)
                                                            <option value="{{$user->city_id}}" selected>{{$user->city->{'name_'.$l} }}</option>
                                                        @endif
                                                    </select>
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{ __('admin.Role')}}</label>
                                                    @if(isset($user->roles->first()->name))
                                                        @php $currentRole = $user->roles->first()->name; @endphp
                                                    @else
                                                        @php $currentRole = ''; @endphp
                                                    @endif
                                                    <select class="select2 form-control" required
                                                        id="role" name='role'>
                                                        <option value="">{{ __('admin.Roles')}}</option>
                                                        @foreach($roles as $role)
                                                            <option value="{{$role->name}}"
                                                                {{ ($role->name == $currentRole)? "selected":"" }} >
                                                                {{ __('admin.'.$role->name) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{ __('admin.HaveCompany')}}</label>
                                                    @if ($user->company)
                                                    <a href="/admin/companyProfile/{{$user->company->id}}" class="btn btn-sm border float-right">{{ __('admin.CompanyProfile') }}</a>
                                                    @endif
                                                        <ul class="list-unstyled mb-0">
                                                        <li class="d-inline-block mr-2 mb-1">
                                                            <fieldset>
                                                                <div class="radio">
                                                                    <input type="radio" name="HaveCompany" value="1" id="h1" {{$user->HaveCompany?'checked=""':''}}>
                                                                    <label for="h1">{{__('Yes')}}</label>
                                                                </div>

                                                            </fieldset>
                                                        </li>
                                                        <li class="d-inline-block mr-2 mb-1">
                                                            <fieldset>
                                                                <div class="radio">
                                                                    <input type="radio" name="HaveCompany" value="" id="h2" {{$user->HaveCompany?'':'checked=""'}}>
                                                                    <label for="h2">{{__('No')}}</label>
                                                                </div>
                                                            </fieldset>
                                                        </li>
                                                    </ul>
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{ __('admin.Verified')}}</label>
                                                    <ul class="list-unstyled mb-0">
                                                        <li class="d-inline-block mr-2 mb-1">
                                                            <fieldset>
                                                                <div class="radio">
                                                                    <input type="radio" name="email_verified_at" value="{{$user->email_verified_at?$user->email_verified_at:now()}}" id="v1" {{$user->email_verified_at?'checked=""':''}}>
                                                                    <label for="v1">{{__('Yes')}}</label>
                                                                </div>
                                                            </fieldset>
                                                        </li>
                                                        <li class="d-inline-block mr-2 mb-1">
                                                            <fieldset>
                                                                <div class="radio">
                                                                    <input type="radio" name="email_verified_at" value="" id="v2" {{$user->email_verified_at?'':'checked=""'}}>
                                                                    <label for="v2">{{__('No')}}</label>
                                                                </div>
                                                            </fieldset>
                                                        </li>
                                                    </ul>
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label for="basicInput">{{ __('admin.Image')}}</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"
                                                                  id="inputGroupFileAddon01">Upload</span>
                                                        </div>
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="img_url"
                                                                   name="img_url" accept="image/*"
                                                                   aria-describedby="inputGroupFileAddon00">
                                                            <label class="custom-file-label"
                                                                   for="inputGroupFile00">{{ __('admin.SelectFile') }}</label>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit"
                                                    class="btn btn-primary mr-1 mb-1">{{__('admin.Update')}}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                        <img style='width: 100%;' class="img-responsive pad" src="/191014/{{$user->img_url??'../images/placeholder.jpg' }}" alt="{{ $user->name_en }}">
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
                                <h4 class="card-title">{{__('admin.Change The account`s password')}}</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form method="post" action="{{route('update_account_password')}}"
                                        enctype="multipart/form-data">
                                        {!! csrf_field() !!}
                                        <div class="row">
                                            <div class="col-md-12">

                                                <fieldset class="form-group">
                                                    <label class="text-bold-600"
                                                        for="password">{{ __('admin.Password') }}</label>
                                                    <input type="password" class="form-control" id="password"
                                                        placeholder="{{ __('admin.Password') }}" name="password"
                                                        required autocomplete="new-password">
                                                        <input type="hidden" name='id' value='{{$user->id}}'>
                                                </fieldset>
                                                <fieldset class="form-group">
                                                    <label class="text-bold-600"
                                                        for="password-confirm">{{ __('admin.Confirm') }}</label>
                                                    <input type="password" class="form-control" id="password-confirm"
                                                        placeholder="{{ __('admin.Password') }}" name="password_confirmation"
                                                        required autocomplete="new-password">
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit"
                                                    class="btn btn-primary mr-1 mb-1">{{__('admin.Update')}}</button>
                                            </div>
                                        </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- BuilderForm end -->
        </div>
    </div>
</div>
<!-- END: Content-->
<div class="modal fade text-left" id="MessageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">{{ __('messages.SendMessageTo') }} {{$user->{'first_name_'.$l} }}
                    {{ $user->{'last_name_'.$l} }}.</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <form method="post" action="/admin/send_message" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <input type="hidden" name="sender" value="{{Auth::user()->id}}">
                <input type="hidden" name="receiver" value="{{$user->id}}">
                <div class="modal-body">
                    <label>{{ __('messages.Subject') }}:</label>
                    <div class="form-group">
                        <input name="subject" type="text" placeholder="{{ __('messages.Subject') }}" class="form-control" required>
                    </div>
                    <label>{{ __('messages.Message') }}: </label>
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
    <script>
        $(document).ready(function() {
            $('#state_id').change(function() {
                var $city = $('#city_id');
                var currentCity = '{{ ($user->company)? $user->company->city_id:0 }}';
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
@stop
