@extends('layouts.admin')
@section('title', __('admin.Profile') )
@section('subTitle', __('admin.Edit your profile information'))
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        @include('admin.includes.heading')
        <div class="content-body">
            <form method="post" action="{{route('update_my_profile')}}"
                  enctype="multipart/form-data">
            <section id="basic-input">
                <div class="row">
                    <div class="col-md-{{$client->img_url?9:12}}">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('admin.Edit your profile information')}}</h4>
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
                                        <div class="row mt-75">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-label-group mt-75">
                                                            <input value="{{ $client->first_name_en}}"
                                                                name="first_name_en" type="text" class="form-control"
                                                                id="first_name_en" style="direction: ltr;"
                                                                placeholder="{{ __('admin.First Name') }}" required
                                                                autocomplete="first_name_en" autofocus />
                                                            <label for="first_name_en">{{__('admin.English Name')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-label-group mt-75">
                                                            <input value="{{ $client->last_name_en }}" name="last_name_en"
                                                                type="text" class="form-control" id="last_name_en" style="direction: ltr;"
                                                                placeholder="{{ __('admin.Last Name') }}" required
                                                                autocomplete="last_name_en" />
                                                        <label for="last_name_en">{{__('admin.Last Name')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-label-group">
                                                        <ul class="list-unstyled mb-0">
                                                            <li class="d-inline-block mr-2 mb-1">
                                                                <fieldset>
                                                                    <div class="radio">
                                                                        <input type="radio" name="gender" value="Male" id="g1" {{ $client->gender=='Male' ? 'checked=""' :''}} >
                                                                        <label for="g1">{{__('Male')}}</label>
                                                                    </div>
                                                                </fieldset>
                                                            </li>
                                                            <li class="d-inline-block mr-2 mb-1">
                                                                <fieldset>
                                                                    <div class="radio">
                                                                        <input type="radio" name="gender" value="Female" id="g2" {{ $client->gender=='Female' ? 'checked=""' :''}}>
                                                                        <label for="g2">{{__('Female')}}</label>
                                                                    </div>
                                                                </fieldset>
                                                            </li>
                                                        </ul>
                                                        </div>
                                                    </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-label-group">
                                                            <input value="{{ $client->first_name_ar }}"
                                                                name="first_name_ar" type="text" class="form-control"
                                                                id="first_name_ar" style="direction: rtl;"
                                                                placeholder="{{ __('admin.First Name') }}" required
                                                                autocomplete="first_name_ar" autofocus />
                                                <label for="first_name_ar">{{__('admin.Arabic Name')}}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-label-group">
                                                            <input value="{{ $client->last_name_ar }}" name="last_name_ar"
                                                                type="text" class="form-control" id="last_name_ar" style="direction: rtl;"
                                                                placeholder="{{ __('admin.Last Name') }}" required
                                                                autocomplete="last_name_ar" />
                                                    <label for="last_name_ar">{{__('admin.Last Name')}}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                    <div class="form-label-group mt-75">
                                                        <input value="{{ $client->title_ar }}" name="title_ar" type="title_ar"
                                                               class="form-control" id="title_ar" style="direction: rtl;"
                                                               placeholder="{{ __('admin.JobTitleAr') }}" required
                                                               autocomplete="title_ar">
                                                        <label for="title_ar">{{__('admin.JobTitleAr')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-label-group mt-75">
                                                        <input value="{{ $client->title_en }}" name="title_en" type="title_en"
                                                               class="form-control" id="title_en" style="direction: ltr;"
                                                               placeholder="{{ __('admin.JobTitleEn') }}" required
                                                               autocomplete="title_en">
                                                        <label for="title_en">{{__('admin.JobTitleEn')}}</label>
                                                    </div>
                                                </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-label-group mt-75">
                                                    <input value="{{ $client->email }}" name="email" type="email"
                                                        class="form-control" id="email" style="direction: ltr;"
                                                        placeholder="{{ __('admin.E-mail') }}" required
                                                        autocomplete="email">
                                                    <label for="email">{{ __('admin.E-mail') }}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                    <div class="form-label-group mt-75">
                                                    <input type="text" class="form-control" id="phone" style="direction: ltr;"
                                                        placeholder="{{ __('admin.Phone') }}" value="{{ $client->phone }}" name="phone"
                                                        required autocomplete="new-phone">
                                                    <label for="phone">{{ __('admin.Phone') }}</label>
                                                    </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="state_id">{{ __('admin.State')}}</label>
                                                    <select class="form-control" required
                                                            id="state_id" name='state_id'>
                                                        <option value="">{{ __('admin.State')}}</option>
                                                        @foreach(\App\State::get() as $state)
                                                            <option value="{{$state->id}}" {{($state->id==$client->state_id)? 'selected':''}}>{{$state->{'name_'.$l} }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="city_id">{{ __('admin.City')}}</label>
                                                    <select class="form-control" required
                                                            id="city_id" name='city_id'>
                                                        <option value="">{{ __('admin.City')}}</option>
                                                        @php $name = 'name_'.$l; @endphp
                                                        @if($client->city_id)
                                                            <option value="{{$client->city_id}}" selected>{{$client->city->{'name_'.$l} }}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="basicInput">{{ __('admin.Image')}}</label>
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
                                                                   for="inputGroupFile00">{{ __('admin.SelectFile')}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="form-group mt-75">
                                                    <label for="basicInput">{{ __('auth.DoYouHaveCompany')}}</label>
                                                    <ul class="list-unstyled mb-0">
                                                        <li class="d-inline-block mr-2 mb-1">
                                                            <fieldset>
                                                                <div class="radio">
                                                                    <input type="radio" name="HaveCompany" value="1" id="h1" {{$client->HaveCompany?'checked=""':''}}>
                                                                    <label for="h1">{{__('Yes')}}</label>
                                                                </div>
                                                            </fieldset>
                                                        </li>
                                                        <li class="d-inline-block mr-2 mb-1">
                                                            <fieldset>
                                                                <div class="radio">
                                                                    <input type="radio" name="HaveCompany" value="" id="h2" {{$client->HaveCompany?'':'checked=""'}}>
                                                                    <label for="h2">{{__('No')}}</label>
                                                                </div>
                                                            </fieldset>
                                                        </li>
                                                    </ul>
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
                    @if($client->img_url)
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <img style="width: 100%;" class="img-responsive pad" src="/191014/{{$client->img_url ??'../images/placeholder.jpg' }}" alt="{{ $client->first_name_en}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </section>
                @role('Mentor')
                <a id="bio">
            <section id="basic-input">
                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('admin.addbio')}}</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-12 col-12">
                                            <label>{{__('admin.arbio')}}: </label>
                                            <div class="form-group">
                            <textarea class="form-control" id="bio_ar" name='bio_ar' rows="3" dir="rtl"
                                      placeholder="{{__('admin.writebioar')}}">{{$client->bio->bio_ar??''}}</textarea>
                                            </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                            <label>{{__('admin.enbio')}}: </label>
                                            <div class="form-group">
                            <textarea class="form-control" id="bio_en" name='bio_en' rows="3" dir="ltr"
                                      placeholder="{{__('admin.writebioen')}}">{{$client->bio->bio_en??''}}</textarea>
                                            </div>
                                            </div>
                                            <br>
                                            <div class="col-md-12 col-12">
                                                <div class="form-label-group">
                                                    <input value="{{ $client->bio?$client->bio->specialization_ar:'' }}" name="specialization_ar" type="text"
                                                           class="form-control" id="specialization_ar" style="direction: rtl;"
                                                           placeholder="{{ __('admin.arspec') }}"
                                                           autocomplete="specialization_ar">
                                                    <label for="specialization_ar">{{ __('admin.arspec') }}</label>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="col-md-12 col-12">
                                                <div class="form-label-group">
                                                    <input value="{{ $client->bio?$client->bio->specialization_en:'' }}" name="specialization_en" type="text"
                                                           class="form-control" id="specialization_en" style="direction: ltr;"
                                                           placeholder="{{ __('admin.enspec') }}"
                                                           autocomplete="specialization_en">
                                                    <label for="specialization_en">{{ __('admin.enspec') }}</label>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="col-md-12 col-12">
                                                <div class="form-label-group">
                                                    <input value="{{ $client->bio?$client->bio->linkedin:'' }}" name="linkedin" type="text"
                                                           class="form-control" id="linkedin" style="direction: ltr;"
                                                           placeholder="{{ __('admin.Linkedin')}} - https://linkedin.com/in/yourname"
                                                           autocomplete="linkedin">
                                                    <label for="linkedin">{{ __('admin.Linkedin') }}</label>
                                                </div>
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
                @endrole
            </form>
            <section id="basic-input">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('admin.Change your account password')}}</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form method="post" action="{{route('update_my_profile_password')}}"
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
        </div>
    </div>
</div>
<!-- END: Content-->
@stop
@section('pagescripts')
    <script>
        $(document).ready(function() {
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
                            $city.append('<option value="'+id+'" selected >'+value+'</option>');
                        });
                        $('#city').show(150);
                    }
                });
            });
        });
    </script>
@stop
