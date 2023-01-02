@extends('layouts.admin')
@section('vendorstyle')
<link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/pickers/daterange/daterangepicker.css">
<link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/forms/select/select2.min.css">
<link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/editors/quill/quill.snow.css">
<link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/extensions/dragula.min.css">
@stop
@section('style')
<link rel="stylesheet" type="text/css" href="/app-assets/css{{$l=='ar'?'-rtl':''}}/pages/app-todo.css">
@stop
@section('bodyclass') todo-application @stop
@section('content') 
  <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-area-wrapper">
            <div class="sidebar-left">
                <div class="sidebar">
                    <div class="todo-sidebar d-flex">
                        <span class="sidebar-close-icon">
                            <i class="bx bx-x"></i>
                        </span>
                        <!-- todo app menu -->
                        <div class="todo-app-menu">
                            <div class="form-group text-center add-task">
                                <!-- new task button -->
                                <button type="button" class="btn btn-primary add-task-btn btn-block my-1">
                                    <i class="bx bx-plus"></i>
                                    <span>New Task</span>
                                </button>
                            </div>
                            <!-- sidebar list start -->
                            <div class="sidebar-menu-list">
                                <div class="list-group">
                                    <a href="#" class="list-group-item border-0 active">
                                        <span class="fonticon-wrap mr-50">
                                            <i class="livicon-evo" data-options="name: list.svg; size: 24px; style: lines; strokeColor:#5A8DEE; eventOn:grandparent;"></i>
                                        </span>
                                        <span> All</span>
                                    </a>
                                </div>
                                <label class="filter-label mt-2 mb-1 pt-25">Filters</label>
                                <div class="list-group">
                                    <a href="#" class="list-group-item border-0">
                                        <span class="fonticon-wrap mr-50">
                                            <i class="livicon-evo" data-options="name: star.svg; size: 24px; style: lines; strokeColor:#475f7b; eventOn:grandparent;"></i>
                                        </span>
                                        <span>Favourites</span>
                                    </a>
                                    <a href="#" class="list-group-item border-0">
                                        <span class="fonticon-wrap mr-50">
                                            <i class="livicon-evo" data-options="name: check.svg; size: 24px; style: lines; strokeColor:#475f7b; eventOn:grandparent;"></i>
                                        </span>
                                        <span>Done</span>
                                    </a>
                                    <a href="#" class="list-group-item border-0">
                                        <span class="fonticon-wrap mr-50">
                                            <i class="livicon-evo" data-options="name: trash.svg; size: 24px; style: lines; strokeColor:#475f7b; eventOn:grandparent;"></i>
                                        </span>
                                        <span>Deleted</span>
                                    </a>
                                </div>
                                <label class="filter-label mt-2 mb-1 pt-25">Labels</label>
                                <div class="list-group">
                                    <a href="#" class="list-group-item border-0 d-flex align-items-center justify-content-between">
                                        <span>Frontend</span>
                                        <span class="bullet bullet-sm bullet-primary"></span>
                                    </a>
                                    <a href="#" class="list-group-item border-0 d-flex align-items-center justify-content-between">
                                        <span>Backend</span>
                                        <span class="bullet bullet-sm bullet-success"></span>
                                    </a>
                                    <a href="#" class="list-group-item border-0 d-flex align-items-center justify-content-between">
                                        <span>Issue</span>
                                        <span class="bullet bullet-sm bullet-danger"></span>
                                    </a>
                                    <a href="#" class="list-group-item border-0 d-flex align-items-center justify-content-between">
                                        <span>Design</span>
                                        <span class="bullet bullet-sm bullet-warning"></span>
                                    </a>
                                    <a href="#" class="list-group-item border-0 d-flex align-items-center justify-content-between">
                                        <span>Wireframe</span>
                                        <span class="bullet bullet-sm bullet-info"></span>
                                    </a>
                                </div>
                            </div>
                            <!-- sidebar list end -->
                        </div>
                    </div>
                    <!-- todo new task sidebar -->
                    <div class="todo-new-task-sidebar">
                        <div class="card shadow-none p-0 m-0">
                            <div class="card-header border-bottom py-75">
                                <div class="task-header d-flex justify-content-between align-items-center">
                                    <h5 class="new-task-title mb-0">New Task</h5>
                                    <button class="mark-complete-btn btn btn-light-primary btn-sm">
                                        <i class="bx bx-check align-middle"></i>
                                        <span class="mark-complete align-middle">Mark Complete</span>
                                    </button>
                                    <span class="dropdown mr-50">
                                        <i class='bx bx-paperclip cursor-pointer mr-50'></i>
                                        <a href="#" class="dropdown-toggle" id="todo-sidebar-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <i class='bx bx-dots-vertical-rounded'></i>
                                        </a>
                                        <span class="dropdown-menu dropdown-menu-right" aria-labelledby="todo-sidebar-dropdown">
                                            <a href="#" class="dropdown-item">Add to another project </a>
                                            <a href="#" class="dropdown-item">Create follow up task</a>
                                            <a href="#" class="dropdown-item">Print</a>
                                        </span>
                                    </span>
                                </div>
                                <button type="button" class="close close-icon">
                                    <i class="bx bx-x"></i>
                                </button>
                            </div>
                            <!-- form start -->
                            <form id="compose-form" class="mt-1">
                                <div class="card-content">
                                    <div class="card-body py-0 border-bottom">
                                        <div class="form-group">
                                            <!-- text area for task title -->
                                            <textarea name="title" class="form-control task-title" cols="1" rows="2" placeholder="Write a Task Name" required>
            </textarea>
                                        </div>
                                        <div class="assigned d-flex justify-content-between">
                                            <div class="form-group d-flex align-items-center mr-1">
                                                <!-- users avatar -->
                                                <div class="avatar">
                                                    <img src="#" class="avatar-user-image d-none" alt="#" width="38" height="38">
                                                    <div class="avatar-content">
                                                        <i class='bx bx-user font-medium-4'></i>
                                                    </div>
                                                </div>
                                                <!-- select2  for user name  -->
                                                <div class="select-box mr-1">
                                                    <select class="select2-users-name form-control" id="select2-users-name">
                                                        <optgroup label="Backend">
                                                            <option value="David Smith">David Smith</option>
                                                            <option value="John Doe">John Doe</option>
                                                            <option value="James Smith">James Smith</option>
                                                            <option value="Maria Garcia">Maria Garcia</option>
                                                        </optgroup>
                                                        <optgroup label="Frontend">
                                                            <option value="Maria Rodrigu">Maria Rodrigu</option>
                                                            <option value="Marry Smith">Marry Smith</option>
                                                            <option value="Maria Hern">Maria Hern</option>
                                                            <option value="Jamesh J">Jamesh Jackson</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex align-items-center position-relative">
                                                <!-- date picker -->
                                                <div class="date-icon mr-50">
                                                    <button type="button" class="btn btn-icon btn-outline-secondary round">
                                                        <i class='bx bx-calendar-alt'></i>
                                                    </button>
                                                </div>
                                                <div class="date-picker">
                                                    <input type="text" class="pickadate form-control px-0" placeholder="Due Date">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body border-bottom task-description">
                                        <!--  Quill editor for task description -->
                                        <div class="snow-container border rounded p-50">
                                            <div class="compose-editor mx-75"></div>
                                            <div class="d-flex justify-content-end">
                                                <div class="compose-quill-toolbar pb-0">
                                                    <span class="ql-formats mr-0">
                                                        <button class="ql-bold"></button>
                                                        <button class="ql-link"></button>
                                                        <button class="ql-image"></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tag d-flex justify-content-between align-items-center pt-1">
                                            <div class="flex-grow-1 d-flex align-items-center">
                                                <i class="bx bx-tag align-middle mr-25"></i>
                                                <select class="select2-assign-label form-control" multiple="multiple" id="select2-assign-label" disabled>
                                                    <optgroup label="Tags">
                                                        <option value="Frontend">Frontend</option>
                                                        <option value="Backend">Backend</option>
                                                        <option value="Issue">Issue</option>
                                                        <option value="Design">Design</option>
                                                        <option value="Wireframe">Wireframe</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                            <div class="ml-25">
                                                <i class="bx bx-plus-circle cursor-pointer add-tags"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pb-1">
                                        <div class="d-flex align-items-center mb-1">
                                            <div class="avatar mr-75">
                                                <img src="/app-assets/images/portrait/small/avatar-s-3.jpg" alt="charlie" width="38" height="38">
                                            </div>
                                            <div class="avatar-content">
                                                Charlie created this task
                                            </div>
                                            <small class="ml-75 text-muted">13 days ago</small>
                                        </div>
                                        <!-- quill editor for comment -->
                                        <div class="snow-container border rounded p-50 ">
                                            <div class="comment-editor mx-75"></div>
                                            <div class="d-flex justify-content-end">
                                                <div class="comment-quill-toolbar pb-0">
                                                    <span class="ql-formats mr-0">
                                                        <button class="ql-bold"></button>
                                                        <button class="ql-link"></button>
                                                        <button class="ql-image"></button>
                                                    </span>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-primary comment-btn">
                                                    <span>Comment</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mt-1 d-flex justify-content-end">
                                            <button type="button" class="btn btn-primary add-todo">Add Task</button>
                                            <button type="button" class="btn btn-primary update-todo">Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- form start end-->
                        </div>
                    </div>

                </div>
            </div>
            <div class="content-right">
                <div class="content-overlay"></div>
                <div class="content-wrapper">
                    <div class="content-header row">
                    </div>
                    <div class="content-body">
                        <div class="app-content-overlay"></div>
                        <div class="todo-app-area">
                            <div class="todo-app-list-wrapper">
                                <div class="todo-app-list">
                                    <div class="todo-fixed-search d-flex justify-content-between align-items-center">
                                        <div class="sidebar-toggle d-block d-lg-none">
                                            <i class="bx bx-menu"></i>
                                        </div>
                                        <fieldset class="form-group position-relative has-icon-left m-0 flex-grow-1">
                                            <input type="text" class="form-control todo-search" id="todo-search" placeholder="Search Task">
                                            <div class="form-control-position">
                                                <i class="bx bx-search"></i>
                                            </div>
                                        </fieldset>
                                        <div class="todo-sort dropdown mr-1">
                                            <button class="btn dropdown-toggle sorting" type="button" id="sortDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-filter"></i>
                                                <span>Sort</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="sortDropdown">
                                                <a class="dropdown-item ascending" href="#">Ascending</a>
                                                <a class="dropdown-item descending" href="#">Descending</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="todo-task-list list-group">
                                        <!-- task list start -->
                                        <ul class="todo-task-list-wrapper list-unstyled" id="todo-task-list-drag">
                                            <li class="todo-item" data-name="David Smith">
                                                <div class="todo-title-wrapper d-flex justify-content-sm-between justify-content-end align-items-center">
                                                    <div class="todo-title-area d-flex">
                                                        <i class='bx bx-grid-vertical handle'></i>
                                                        <div class="checkbox">
                                                            <input type="checkbox" class="checkbox-input" id="checkbox1">
                                                            <label for="checkbox1"></label>
                                                        </div>
                                                        <p class="todo-title mx-50 m-0 truncate">Effective Hypnosis Quit Smoking Methods</p>
                                                    </div>
                                                    <div class="todo-item-action d-flex align-items-center">
                                                        <div class="todo-badge-wrapper d-flex">
                                                            <span class="badge badge-light-primary badge-pill">Frontend</span>
                                                        </div>
                                                        <div class="avatar ml-1">
                                                            <img src="/app-assets/images/portrait/small/avatar-s-1.jpg" alt="avatar" height="30" width="30">
                                                        </div>
                                                        <a class='todo-item-favorite ml-75'><i class="bx bx-star"></i></a>
                                                        <a class='todo-item-delete ml-75'><i class="bx bx-trash"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="todo-item" data-name="John Doe">
                                                <div class="todo-title-wrapper d-flex justify-content-sm-between justify-content-end align-items-center">
                                                    <div class="todo-title-area d-flex">
                                                        <i class='bx bx-grid-vertical handle'></i>
                                                        <div class="checkbox">
                                                            <input type="checkbox" class="checkbox-input" id="checkbox2">
                                                            <label for="checkbox2"></label>
                                                        </div>
                                                        <p class="todo-title mx-50 m-0 truncate">How To Protect Your Computer Very Useful Tips</p>
                                                    </div>
                                                    <div class="todo-item-action d-flex align-items-center">
                                                        <div class="todo-badge-wrapper d-flex"></div>
                                                        <div class="avatar ml-1">
                                                            <img src="/app-assets/images/portrait/small/avatar-s-2.jpg" alt="avatar" height="30" width="30">
                                                        </div>
                                                        <a class='todo-item-favorite ml-75 warning'><i class="bx bx-star bxs-star"></i></a>
                                                        <a class='todo-item-delete ml-75'><i class="bx bx-trash"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="todo-item" data-name="James Smith">
                                                <div class="todo-title-wrapper d-flex justify-content-sm-between justify-content-end align-items-center">
                                                    <div class="todo-title-area d-flex">
                                                        <i class='bx bx-grid-vertical handle'></i>
                                                        <div class="checkbox">
                                                            <input type="checkbox" class="checkbox-input" id="checkbox14">
                                                            <label for="checkbox14"></label>
                                                        </div>
                                                        <p class="todo-title mx-50 m-0 truncate">It is a good idea to think of your PC as an office.</p>
                                                    </div>
                                                    <div class="todo-item-action d-flex align-items-center">
                                                        <div class="todo-badge-wrapper d-flex">
                                                            <span class="badge badge-light-primary badge-pill">Frontend</span>
                                                        </div>
                                                        <div class="avatar ml-1">
                                                            <img src="/app-assets/images/portrait/small/avatar-s-3.jpg" alt="avatar" height="30" width="30">
                                                        </div>
                                                        <a class='todo-item-favorite ml-75'><i class="bx bx-star"></i></a>
                                                        <a class='todo-item-delete ml-75'><i class="bx bx-trash"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="todo-item" data-name="Maria Garcia">
                                                <div class="todo-title-wrapper d-flex justify-content-sm-between justify-content-end align-items-center">
                                                    <div class="todo-title-area d-flex">
                                                        <i class='bx bx-grid-vertical handle'></i>
                                                        <div class="checkbox">
                                                            <input type="checkbox" class="checkbox-input" id="checkbox4">
                                                            <label for="checkbox4"></label>
                                                        </div>
                                                        <p class="todo-title mx-50 m-0 truncate">Don't Let The Outtakes Take You Out</p>
                                                    </div>
                                                    <div class="todo-item-action d-flex align-items-center">
                                                        <div class="todo-badge-wrapper d-flex">
                                                            <span class="badge badge-light-danger badge-pill ml-50">Issue</span>
                                                            <span class="badge badge-light-success badge-pill ml-50">Backend</span>
                                                        </div>
                                                        <div class="avatar ml-1">
                                                            <img src="/app-assets/images/portrait/small/avatar-s-4.jpg" alt="avatar" height="30" width="30">
                                                        </div>
                                                        <a class='todo-item-favorite ml-75 warning'><i class="bx bx-star bxs-star"></i></a>
                                                        <a class='todo-item-delete ml-75'><i class="bx bx-trash"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="todo-item" data-name="Maria Rodrigu">
                                                <div class="todo-title-wrapper d-flex justify-content-sm-between justify-content-end align-items-center">
                                                    <div class="todo-title-area d-flex">
                                                        <i class='bx bx-grid-vertical handle'></i>
                                                        <div class="checkbox">
                                                            <input type="checkbox" class="checkbox-input" id="checkbox5">
                                                            <label for="checkbox5"></label>
                                                        </div>
                                                        <p class="todo-title mx-50 m-0 truncate">Sony laptops are among the most well known laptops on today</p>
                                                    </div>
                                                    <div class="todo-item-action d-flex align-items-center">
                                                        <div class="todo-badge-wrapper d-flex"></div>
                                                        <div class="avatar ml-1">
                                                            <img src="/app-assets/images/portrait/small/avatar-s-5.jpg" alt="avatar" height="30" width="30">
                                                        </div>
                                                        <a class='todo-item-favorite ml-75'><i class="bx bx-star"></i></a>
                                                        <a class='todo-item-delete ml-75'><i class="bx bx-trash"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="todo-item" data-name="Marry Smith">
                                                <div class="todo-title-wrapper d-flex justify-content-sm-between justify-content-end align-items-center">
                                                    <div class="todo-title-area d-flex">
                                                        <i class='bx bx-grid-vertical handle'></i>
                                                        <div class="checkbox">
                                                            <input type="checkbox" class="checkbox-input" id="checkbox6">
                                                            <label for="checkbox6"></label>
                                                        </div>
                                                        <p class="todo-title mx-50 m-0 truncate">Success Steps For Your Personal Or Business Life</p>
                                                    </div>
                                                    <div class="todo-item-action d-flex align-items-center">
                                                        <div class="todo-badge-wrapper d-flex"></div>
                                                        <div class="avatar ml-1">
                                                            <img src="/app-assets/images/portrait/small/avatar-s-6.jpg" alt="avatar" height="30" width="30">
                                                        </div>
                                                        <a class='todo-item-favorite ml-75'><i class="bx bx-star"></i></a>
                                                        <a class='todo-item-delete ml-75'><i class="bx bx-trash"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="todo-item" data-name="Maria Hern">
                                                <div class="todo-title-wrapper d-flex justify-content-sm-between justify-content-end align-items-center">
                                                    <div class="todo-title-area d-flex">
                                                        <i class='bx bx-grid-vertical handle'></i>
                                                        <div class="checkbox">
                                                            <input type="checkbox" class="checkbox-input" id="checkbox7">
                                                            <label for="checkbox7"></label>
                                                        </div>
                                                        <p class="todo-title mx-50 m-0 truncate">Believing Is The Absence Of Doubt</p>
                                                    </div>
                                                    <div class="todo-item-action d-flex align-items-center">
                                                        <div class="todo-badge-wrapper d-flex"></div>
                                                        <div class="avatar ml-1">
                                                            <img src="/app-assets/images/portrait/small/avatar-s-7.jpg" alt="avatar" height="30" width="30">
                                                        </div>
                                                        <a class='todo-item-favorite ml-75'><i class="bx bx-star"></i></a>
                                                        <a class='todo-item-delete ml-75'><i class="bx bx-trash"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="todo-item" data-name="Jamesh Jackson">
                                                <div class="todo-title-wrapper d-flex justify-content-sm-between justify-content-end align-items-center">
                                                    <div class="todo-title-area d-flex">
                                                        <i class='bx bx-grid-vertical handle'></i>
                                                        <div class="checkbox">
                                                            <input type="checkbox" class="checkbox-input" id="checkbox8">
                                                            <label for="checkbox8"></label>
                                                        </div>
                                                        <p class="todo-title mx-50 m-0 truncate">Are You Struggling In Life</p>
                                                    </div>
                                                    <div class="todo-item-action d-flex align-items-center">
                                                        <div class="todo-badge-wrapper d-flex">
                                                            <span class="badge badge-light-danger badge-pill ml-50">Issue</span>
                                                            <span class="badge badge-light-success badge-pill ml-50">Backend</span>
                                                        </div>
                                                        <div class="avatar ml-1">
                                                            <img src="/app-assets/images/portrait/small/avatar-s-8.jpg" alt="avatar" height="30" width="30">
                                                        </div>
                                                        <a class='todo-item-favorite ml-75'><i class="bx bx-star"></i></a>
                                                        <a class='todo-item-delete ml-75'><i class="bx bx-trash"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="todo-item" data-name="David Smith">
                                                <div class="todo-title-wrapper d-flex justify-content-sm-between justify-content-end align-items-center">
                                                    <div class="todo-title-area d-flex">
                                                        <i class='bx bx-grid-vertical handle'></i>
                                                        <div class="checkbox">
                                                            <input type="checkbox" class="checkbox-input" id="checkbox9">
                                                            <label for="checkbox9"></label>
                                                        </div>
                                                        <p class="todo-title mx-50 m-0 truncate">Hypnotherapy For Motivation Getting The Drive Back</p>
                                                    </div>
                                                    <div class="todo-item-action d-flex align-items-center">
                                                        <div class="todo-badge-wrapper d-flex"></div>
                                                        <span class=" badge badge-circle badge-light-primary">DS</span>
                                                        <a class='todo-item-favorite ml-75 warning'><i class="bx bx-star bxs-star"></i></a>
                                                        <a class='todo-item-delete ml-75'><i class="bx bx-trash"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="todo-item" data-name="John Doe">
                                                <div class="todo-title-wrapper d-flex justify-content-sm-between justify-content-end align-items-center">
                                                    <div class="todo-title-area d-flex">
                                                        <i class='bx bx-grid-vertical handle'></i>
                                                        <div class="checkbox">
                                                            <input type="checkbox" class="checkbox-input" id="checkbox10">
                                                            <label for="checkbox10"></label>
                                                        </div>
                                                        <p class="todo-title mx-50 m-0 truncate">Fix Responsiveness</p>
                                                    </div>
                                                    <div class="todo-item-action d-flex align-items-center">
                                                        <div class="todo-badge-wrapper d-flex">
                                                            <span class="badge badge-light-warning badge-pill ml-50">Design</span>
                                                            <span class="badge badge-light-primary badge-pill ml-50">Frontend</span>
                                                            <span class="badge badge-light-secondary badge-pill ml-50" data-tag="ISSUE,BACKEND" data-toggle="tooltip" data-placement="bottom" title="ISSUE,BACKEND">
                                                                <i class='bx bx-dots-horizontal-rounded font-small-1'></i>
                                                            </span>
                                                        </div>
                                                        <div class="avatar ml-1">
                                                            <img src="/app-assets/images/portrait/small/avatar-s-10.jpg" alt="avatar" height="30" width="30">
                                                        </div>
                                                        <a class='todo-item-favorite ml-75'><i class="bx bx-star"></i></a>
                                                        <a class='todo-item-delete ml-75'><i class="bx bx-trash"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="todo-item" data-name="James Smith">
                                                <div class="todo-title-wrapper d-flex justify-content-sm-between justify-content-end align-items-center">
                                                    <div class="todo-title-area d-flex">
                                                        <i class='bx bx-grid-vertical handle'></i>
                                                        <div class="checkbox">
                                                            <input type="checkbox" class="checkbox-input" id="checkbox11">
                                                            <label for="checkbox11"></label>
                                                        </div>
                                                        <p class="todo-title mx-50 m-0 truncate">Buying Used Electronic Test Equipment.</p>
                                                    </div>
                                                    <div class="todo-item-action d-flex align-items-center">
                                                        <div class="todo-badge-wrapper d-flex"></div>
                                                        <div class="avatar ml-1">
                                                            <img src="/app-assets/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="30" width="30">
                                                        </div>
                                                        <a class='todo-item-favorite ml-75'><i class="bx bx-star"></i></a>
                                                        <a class='todo-item-delete ml-75'><i class="bx bx-trash"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="todo-item" data-name="Marry Smith">
                                                <div class="todo-title-wrapper d-flex justify-content-sm-between justify-content-end align-items-center">
                                                    <div class="todo-title-area d-flex">
                                                        <i class='bx bx-grid-vertical handle'></i>
                                                        <div class="checkbox">
                                                            <input type="checkbox" class="checkbox-input" id="checkbox12">
                                                            <label for="checkbox12"></label>
                                                        </div>
                                                        <p class="todo-title mx-50 m-0 truncate">Get The Boot A Birds Eye Look Into Mcse Boot Camps</p>
                                                    </div>
                                                    <div class="todo-item-action d-flex align-items-center">
                                                        <div class="todo-badge-wrapper d-flex">
                                                            <span class="badge badge-light-warning badge-pill">Design</span>
                                                        </div>
                                                        <div class="avatar ml-1">
                                                            <img src="/app-assets/images/portrait/small/avatar-s-12.jpg" alt="avatar" height="30" width="30">
                                                        </div>
                                                        <a class='todo-item-favorite ml-75'><i class="bx bx-star"></i></a>
                                                        <a class='todo-item-delete ml-75'><i class="bx bx-trash"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="todo-item" data-name="Maria Garcia">
                                                <div class="todo-title-wrapper d-flex justify-content-sm-between justify-content-end align-items-center">
                                                    <div class="todo-title-area d-flex">
                                                        <i class='bx bx-grid-vertical handle'></i>
                                                        <div class="checkbox">
                                                            <input type="checkbox" class="checkbox-input" id="checkbox13">
                                                            <label for="checkbox13"></label>
                                                        </div>
                                                        <p class="todo-title mx-50 m-0 truncate">Dealing With Technical Support 10 Useful Tips</p>
                                                    </div>
                                                    <div class="todo-item-action d-flex align-items-center">
                                                        <div class="todo-badge-wrapper d-flex">
                                                            <span class="badge badge-light-success badge-pill">Backend</span>
                                                        </div>
                                                        <div class="avatar ml-1">
                                                            <img src="/app-assets/images/portrait/small/avatar-s-13.jpg" alt="avatar" height="30" width="30">
                                                        </div>
                                                        <a class='todo-item-favorite ml-75'><i class="bx bx-star"></i></a>
                                                        <a class='todo-item-delete ml-75'><i class="bx bx-trash"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="todo-item" data-name="Maria Rodrigu">
                                                <div class="todo-title-wrapper d-flex justify-content-sm-between justify-content-end align-items-center">
                                                    <div class="todo-title-area d-flex">
                                                        <i class='bx bx-grid-vertical handle'></i>
                                                        <div class="checkbox">
                                                            <input type="checkbox" class="checkbox-input" id="checkbox15">
                                                            <label for="checkbox15"></label>
                                                        </div>
                                                        <p class="todo-title mx-50 m-0 truncate">How Hypnosis Can Help You</p>
                                                    </div>
                                                    <div class="todo-item-action d-flex align-items-center">
                                                        <div class="todo-badge-wrapper d-flex"></div>
                                                        <span class="badge badge-circle badge-light-success">MR</span>
                                                        <a class='todo-item-favorite ml-75 warning'><i class="bx bx-star bxs-star"></i></a>
                                                        <a class='todo-item-delete ml-75'><i class="bx bx-trash"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="todo-item" data-name="David Smith">
                                                <div class="todo-title-wrapper d-flex justify-content-sm-between justify-content-end align-items-center">
                                                    <div class="todo-title-area d-flex">
                                                        <i class='bx bx-grid-vertical handle'></i>
                                                        <div class="checkbox">
                                                            <input type="checkbox" class="checkbox-input" id="checkbox16">
                                                            <label for="checkbox16"></label>
                                                        </div>
                                                        <p class="todo-title mx-50 m-0 truncate">Effective Hypnosis Quit Smoking Methods</p>
                                                    </div>
                                                    <div class="todo-item-action d-flex align-items-center">
                                                        <div class="todo-badge-wrapper d-flex">
                                                            <span class="badge badge-light-primary badge-pill">Frontend</span>
                                                        </div>
                                                        <div class="avatar ml-1">
                                                            <img src="/app-assets/images/portrait/small/avatar-s-1.jpg" alt="avatar" height="30" width="30">
                                                        </div>
                                                        <a class='todo-item-favorite ml-75'><i class="bx bx-star"></i></a>
                                                        <a class='todo-item-delete ml-75'><i class="bx bx-trash"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="todo-item" data-name="John Doe">
                                                <div class="todo-title-wrapper d-flex justify-content-sm-between justify-content-end align-items-center">
                                                    <div class="todo-title-area d-flex">
                                                        <i class='bx bx-grid-vertical handle'></i>
                                                        <div class="checkbox">
                                                            <input type="checkbox" class="checkbox-input" id="checkbox17">
                                                            <label for="checkbox17"></label>
                                                        </div>
                                                        <p class="todo-title mx-50 m-0 truncate">How To Protect Your Computer Very Useful Tips</p>
                                                    </div>
                                                    <div class="todo-item-action d-flex align-items-center">
                                                        <div class="todo-badge-wrapper d-flex"></div>
                                                        <div class="avatar ml-1">
                                                            <img src="/app-assets/images/portrait/small/avatar-s-2.jpg" alt="avatar" height="30" width="30">
                                                        </div>
                                                        <a class='todo-item-favorite ml-75'><i class="bx bx-star"></i></a>
                                                        <a class='todo-item-delete ml-75'><i class="bx bx-trash"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <!-- task list end -->
                                        <div class="no-results">
                                            <h5>No Items Found</h5>
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
@stop
	
@section('scripts') 
	<script src="/app-assets/vendors/js/pickers/daterange/moment.min.js"></script>
    <script src="/app-assets/vendors/js/pickers/daterange/daterangepicker.js"></script>
    <script src="/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="/app-assets/vendors/js/editors/quill/quill.min.js"></script>
    <script src="/app-assets/vendors/js/extensions/dragula.min.js"></script>
@stop
@section('pagescripts') 
    <script src="/app-assets/js/scripts/pages/app-todo.js"></script>
@stop