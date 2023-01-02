@extends('layouts.admin')
@section('bodyclass') calendar-application @stop
@section('content')
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    @if ($l=='ar')
<style>
    .fc-left {
        direction: rtl;
    }
    .toast-top-right {
        right:auto;
        left:12px;
    }
</style>
    @endif
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="calendar-wrapper position-relative">
                    <div class="card">
                        <div class="card-body">
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
    <div class="modal fade text-left" id="viewevent" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                         <h6 id="body"></h6>
                        <br>
                        <h7 id="start"></h7>
                        <h7 id="end"></h7>
                    </div>
                    <div class="modal-footer">
                        <a id="edit" href="#" class="btn btn-light-primary" style="display: none;" >
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">{{__('admin.Edit')}}</span>
                        </a>
                        <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">{{__('admin.Close')}}</span>
                        </button>
                    </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @if ($l=='ar')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/locale/ar.js"></script>
    @endif
    <script>
        $(document).ready(function () {
            var SITEURL = "{{ url('/') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var calendar = $('#calendar').fullCalendar({
                customButtons: {
                    AddNew: {
                        text: '{{$l=='ar'?'إضافة جديد!':'Add New!'}}',
                        click: function() {
                            /// add
                            var title = prompt('{{$l=='ar'?'ادخل عنوان لحدث اليوم':'Today, event title'}}:');
                            if (title) {
                                var start = new Date().toISOString().split("T")[0];
                                var end = start;
                                var allDay= 1;
                                $.ajax({
                                    url: SITEURL + "/admin/calendarAjax",
                                    data: {
                                        title: title,
                                        start: start,
                                        end: end,
                                        allDay: allDay,
                                        type: 'add'
                                    },
                                    type: "POST",
                                    success: function (data) {
                                        displayMessage("{{__('admin.Event Created Successfully')}}");
                                        calendar.fullCalendar('renderEvent',
                                            {
                                                id: data.id,
                                                title: title,
                                                start: start,
                                                end: end,
                                                editable: true,
                                                allDay: allDay
                                            },true);
                                        calendar.fullCalendar('unselect');
                                    }
                                });
                            }
                            //// end
                        }
                    },
                    AllEvents: {
                        text: '{{$l=='ar'?'الأحداث':'Events!'}}',
                        click: function() {
                           window.open('/admin/allevents','_Self')
                        }
                    }
                },
                header: {
                    left: 'prev,next today AddNew',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay @can('manage_events') AllEvents @endcan '
                },
                events: SITEURL + "/admin/calendar",
                eventTextColor:'#fff',
                displayEventTime: true,
                editable: false,
                eventRender: function (event, element, view) {
                    if (event.isallDay === true) {
                        event.allDay = true;
                    } else {
                        event.allDay = false;
                    }
                },
                selectable: true,
                selectHelper: true,
                select: function (start, end, allDay) {
                    var title = prompt('{{$l=='ar'?'عنوان الحدث':'Event Title'}}:');
                    if (title) {
                        if ($.fullCalendar.formatDate(start, "HH:mm")===$.fullCalendar.formatDate(end, "HH:mm")) {
                            var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
                            var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
                            var allDay= 1;
                        }
                        else {
                            var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm");
                            var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm");
                            var allDay= null;
                        }
                        @if ($l=='ar')
                            start = start.replace(/[٠-٩]/g, (digit) => "٠١٢٣٤٥٦٧٨٩".indexOf(digit));
                        end = end.replace(/[٠-٩]/g, (digit) => "٠١٢٣٤٥٦٧٨٩".indexOf(digit));
                        @endif
                        $.ajax({
                            url: SITEURL + "/admin/calendarAjax",
                            data: {
                                title: title,
                                start: start,
                                end: end,
                                allDay: allDay,
                                type: 'add'
                            },
                            type: "POST",
                            success: function (data) {
                                displayMessage("{{__('admin.Event Created Successfully')}}");
                                calendar.fullCalendar('renderEvent',
                                    {
                                        id: data.id,
                                        calendarId:1,
                                        title: title,
                                        start: start,
                                        end: end,
                                        editable: true,
                                        allDay: allDay
                                    },true);
                                calendar.fullCalendar('unselect');
                            }
                        });
                    }
                },
                eventDrop: function (event, delta) {
                    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm");
                    if (event.end) {
                        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm");
                    } else {var end=start;}
                    var allDay = null;
                    if (event.allDay===true) {
                        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                        if (event.end) {
                        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
                        } else {var end=start;}
                        var allDay = 1;}
                        @if ($l=='ar')
                     start = start.replace(/[٠-٩]/g, (digit) => "٠١٢٣٤٥٦٧٨٩".indexOf(digit));
                     end = end.replace(/[٠-٩]/g, (digit) => "٠١٢٣٤٥٦٧٨٩".indexOf(digit));
                        @endif

                    $.ajax({
                        url: SITEURL + '/admin/calendarAjax',
                        data: {
                            title: event.title,
                            start: start,
                            end: end,
                            id: event.id,
                            allDay: allDay,
                            type: 'update'
                        },
                        type: "POST",
                        success: function (response) {
                            displayMessage("{{__('admin.Event Updated Successfully')}}");
                        }
                    });
                },
                eventResize: function (event, delta) {
                    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm");
                    if (event.end) {
                        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm");
                    } else {var end=start;}
                    var allDay = null;
                    if (event.allDay===true) {
                        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                        if (event.end) {
                            var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
                        } else {var end=start;}
                        var allDay = 1;}
                    @if ($l=='ar')
                        start = start.replace(/[٠-٩]/g, (digit) => "٠١٢٣٤٥٦٧٨٩".indexOf(digit));
                        end = end.replace(/[٠-٩]/g, (digit) => "٠١٢٣٤٥٦٧٨٩".indexOf(digit));
                    @endif

                    $.ajax({
                        url: SITEURL + '/admin/calendarAjax',
                        data: {
                            title: event.title,
                            start: start,
                            end: end,
                            id: event.id,
                            allDay: allDay,
                            type: 'update'
                        },
                        type: "POST",
                        success: function (response) {
                            displayMessage("{{__('admin.Event Updated Successfully')}}");
                        }
                    });
                },
                eventClick: function (event) {
                    if (event.calendarId==='e') {
                        window.open('/event/'+event.id, "_blank");
                        return false;
                    }
                    else if (event.calendarId==='s') {
                        window.open('/admin/mentorship/mine', "_self");
                        return false;
                    }
                    else if (event.calendarId==='p') {
                        openmodal(event.calendarId,event.id);
                        return false;
                    }
                    else if (event.calendarId==='t') {
                        window.open('/admin/training/my', "_self");
                        return false;
                    } else {
                        openmodal(event.calendarId,event.id);
                        return false;
                    }
                }
            });
        });
        function displayMessage(message) {
            toastr.success(message, '{{__('admin.Calendar')}}');
        }
        function openmodal(modal,id) {
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                type: "POST", url: "/admin/calendar/view",data: {"type" : modal,"id" : id},
                success: function (response) {
                    $('#title').html(response.title);
                    $('#body').html(response.body);
                    $('#start').html("<b>{{__('admin.Start')}}: </b> "+ response.start );
                    $('#end').html("<b>{{__('admin.End')}}: </b> "+ response.end);
                    if ( response.user_id === {{Auth::id()}} ) {
                        $('#edit').show();
                        $('#edit').attr('href','/admin/calendar/'+id+'/edit')
                    }
                    $('#viewevent').modal('show');
                },
                error: function (error) {
                    console.log(error);
                    alert("Error Occurred, Try again!");
                }
            });
        }
    </script>
@stop