@extends('layouts.admin')
@section('style')
    <style>
        .section {
            padding: 0 30px;
        }
        .bg-light {
            background-color: #92989e2e !important;
        }
        .bg-light .card-header, .bg-light .card-footer {
            background-color: #32181817;
            font-size: 1.2em;
        }
        hr{
            margin: 0 0 15px;
        }
    </style>
@stop
@section('title', __('admin.Builder') )
@section('subTitle', __('admin.Edit form'))
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <section id="kanban-wrapper">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header" style="padding-bottom: 15px;">
                                <h4 class="card-title">{{__('builder.Forms builder')}}</h4>
                            </div>
                            <hr>
                            <div class="card-body">
                                <span>{{__('builder.Select from')}}:</span>
                                <fieldset class="form-group">
                                    <div style="width: 70%;float: {{$l=='ar'?'right':'left'}};">
                                    <select class="select2 form-control" id="FormSelect"  onchange="window.open('/admin/show-builder/'+this.options[this.selectedIndex].value,'_self');">
                                        @foreach(App\BuilderForm::all() as $form)
                                        <option value="{{$form->id}}" {{$title->id==$form->id?"selected":""}}>{{$form->form_name}}</option>
                                        @endforeach
                                    </select></div>
                                    &nbsp;&nbsp;
                                    <span>
                                    <button class="btn btn-primary" onclick="DoChange(0,{{$title->id}},'{{$title->form_name}}')">
                                        <i class="bx bx-edit"></i> <span class="align-middle ml-25">{{__('builder.Edit')}}</span>
                                    </button>
                                    <button class="btn btn-info" onclick="DoChange(1,{{$title->id}},'{{$title->form_name}}')">
                                        <i class="bx bx-copy" ></i> <span class="align-middle ml-25">{{__('builder.Copy')}}</span>
                                    </button>
                                    <button class="btn btn-success" onclick="DoChange(2,0,null)">
                                        <i class="bx bx-star" ></i> <span class="align-middle ml-25">{{__('builder.New')}}</span>
                                    </button>
                                    <button class="btn btn-danger" onclick="DoChange(3,{{$title->id}},null)">
                                        <i class="bx bx-trash"></i> <span class="align-middle ml-25">{{__('builder.Delete')}}</span>
                                    </button>
                                    </span>
                                </fieldset>
                            </div>
                        </div>
                    </div>
            <div class="col-xl-12 col-md-12 col-sm-12">
                <div class="card">
                        <div class="card-header" style="padding-bottom: 0px;">
                            <p>{{__('builder.Drag')}}<a href="/admin/show-form/{{$title->id}}"> ({{__('builder.Preview')}})</a>.</p>
                        </div>
<hr>
                    <div class="section">
                        <div class="row" id="builder-app"></div>
                        <div id="modal-root"></div>
                    </div>
                </div>
            </div>
                </div>
            </section>
        </div>
    </div>
</div>
@stop
@section('pagescripts')
    <script>
        document.body.classList.add("menu-collapsed");
        function DoChange(set, id, title) {
            if (set===0)
            {
                title = prompt("{{__('builder.new title')}}",title);
            } else if (set===1) {
                title = prompt("{{__('builder.new copied')}}:", title + ' {{__('builder.Copy.')}}');
            } else if (set===2) {
                title = prompt("{{__('builder.new form')}}");
            }  else if (set===3) {
                title = confirm("{{__('builder.deleting form')}}?")
            }
            if (!title) {return false;}
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "/admin/builder/" + set,
                data: {
                    "id": id,
                    "title" : title,
                },
                success: function (response) {
                    console.log(response);
                    location.href = '/admin/show-builder/'+  response;
                },
                error:function(error){
                    console.log(error);
                    alert("Error Occurred, Try again!");
                }
            });
        }
        window._rav = window._rav || {};
        _rav.save_route = "{{ '/admin/form/'.$title->id.'/save-form' }}";
        _rav.boardData = @json($builder_data);
    </script>
    <script src="{{ asset('js/formbuilder.js') }}"></script>
@stop