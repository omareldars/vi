@extends('layouts.admin')
@section('title', __('admin.Documentations') )
@section('index_url', route('documentation.index') )
@section('subTitle', __('admin.Edit Document'))
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        @include('admin.includes.heading')
        <div class="content-body">

            <section id="basic-input">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{__('admin.Edit Document')}}</h4>
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
                                        <br>
                                    <form method="post" action="{{route('documentation.update', ['id' => $documentation->id])}}" enctype="multipart/form-data">
                                        {!! csrf_field() !!}
                                        @method('patch')
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-12 col-12">
                                                    <div class="form-label-group">
                                                        <input id="menu_ar" style="direction: rtl;" type="text" value="{{$documentation->menu_ar}}" class="form-control" placeholder="{{__('admin.Arabic Title')}}" name="menu_ar" required>
                                                        <label for="menu_ar">{{__('admin.Arabic Title')}}</label>
                                                    </div>
                                                    <br>
                                                </div>
                                                <div class="col-md-12 col-12">
                                                    <div class="form-label-group">
                                                        <input id="menu_en" style="direction: ltr;" type="text" value="{{$documentation->menu_en}}" class="form-control" placeholder="{{__('admin.English Title')}}" name="menu_en" required>
                                                        <label for="menu_en">{{__('admin.English Title')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-4">
                                                        <div class="form-group">
                                                            <label for="arr">{{__('admin.arrange')}}:</label>
                                                            <input id="arr" type="text" name="arr" class="select form-control" value="{{$documentation->arr}}">
                                                        </div>
                                                    <br>
                                                </div>
                                                <div class="col-md-4 col-4">
                                                    <div class="form-group">
                                                        <label for="role">{{__('admin.Rolefor')}}:</label>
                                                        <select id="role" name="role" class="select form-control">
                                                            <option value="all" {{$documentation->role == 'all' ?'selected':''}}>{{__('admin.All')}}</option>
                                                            <option value="user" {{$documentation->role == 'user' ?'selected':''}}>{{__('admin.Users')}}</option>
                                                            <option value="mentor" {{$documentation->role == 'mentor' ?'selected':''}}>{{__('admin.Mentors')}}</option>
                                                            <option value="judge" {{$documentation->role == 'judge' ?'selected':''}}>{{__('admin.Judgers')}}</option>
                                                            <option value="admin" {{$documentation->role == 'admin' ?'selected':''}}>{{__('admin.Managers')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                @php ($icons = ['bx-bookmark','bx-bar-chart-alt','bx-bell-minus','bx-toggle-right','bx-book','bx-calendar','bx-briefcase','bx-camera','bx-cut','bx-dollar-circle','bx-error-circle','bx-file-find','bx-grid-alt','bx-help-circle','bx-home','bx-info-circle','bx-like','bxl-messenger','bx-notepad','bx-phone','bx-plus-circle','bx-printer','bxs-ambulance','bxs-battery-charging','bxs-brush-alt','bxs-buildings','bxs-calculator','bxs-calendar','bxs-cart','bxs-cog','bxs-credit-card','bxs-edit','bx-selection','bxs-gift','bx-share-alt','bx-show-alt','bxs-inbox','bx-sitemap','bxs-keyboard','bxs-landmark','bxs-magic-wand','bxs-pie-chart','bx-spreadsheet','bxs-save','bxs-store','bx-star','bxs-trash','bxs-user-pin','bxs-vial','bx-user-circle','bx-user-plus','bx-wrench'])
                                                <div class="col-md-4 col-4">
                                                    <div class="form-group">
                                                        <label for="icon">{{__('admin.Icon')}}:</label>
                                                        <select name="icon" class="select2-icons form-control" id="icon">
                                                            @foreach($icons as $icon)
                                                                <option value="{{$icon}}"  data-icon="bx {{$icon}}" {{$documentation->icon == $icon ?'selected':''}}>{{$icon}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-12">
                                                    <div class="form-label-group">
                                                            <textarea class="form-control" id="content_ar" rows="8" name="content_ar" required>
                                                            {!! $documentation->content_ar !!}
                                                            </textarea>
                                                        <label for="content_ar">{{__('admin.Arabic Content')}}</label>
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-12">
                                                    <div class="form-label-group">
                                                            <textarea class="form-control" id="content_en" rows="8" name="content_en" required>
                                                            {!! $documentation->content_en !!}
                                                            </textarea>
                                                        <label for="content_en">{{__('admin.English Content')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-12 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1">{{__('cycles.Submit')}}</button>
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

        </div>
    </div>
</div>
<!-- END: Content-->
@stop
@section('pagescripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.2/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap hr pagebreak nonbreaking anchor insertdatetime advlist lists wordcount textpattern noneditable help charmap quickbars emoticons',
            imagetools_cors_hosts: ['picsum.photos'],
            menubar: 'edit view insert format tools table help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview  print | insertfile image media template link anchor codesample | ltr rtl',
            toolbar_sticky: true,
            autosave_ask_before_unload: true,
            autosave_interval: '30s',
            autosave_prefix: '{path}{query}-{id}-',
            autosave_restore_when_empty: false,
            autosave_retention: '2m',
            image_advtab: true,
            importcss_append: true,
            template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
            template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
            height: 600,
            image_caption: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            noneditable_noneditable_class: 'mceNonEditable',
            toolbar_mode: 'sliding',
            contextmenu: 'link image imagetools table',
            content_style: 'body { font-family:Times New Roman,Arial,sans-serif; font-size:14px }',
            image_title: true,
            automatic_uploads: true,
            images_upload_url: "{{ route('training.upload', ['_token' => csrf_token() ])}}",
            file_picker_types: 'image',
            relative_urls : false,
            remove_script_host : true,
            convert_urls : true,
            file_picker_callback: function(cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.onchange = function() {
                    var file = this.files[0];
                    var reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = function () {
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);
                        cb(blobInfo.blobUri(), { title: file.name });
                    };
                };
                input.click();
            }
        });
        @if($l=='ar')
            tinyMCE.settings['directionality'] = 'rtl';
        @endif
    </script>
@stop
