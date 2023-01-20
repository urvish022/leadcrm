@extends('layouts.app')
@push('styles')
    <style type="text/css">
        .fc-event {
            cursor: pointer;
        }
    </style>
@endpush
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Scheduler</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            @include('flash::message')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-calendar"></i>
                            Scheduler
                        </div>
                        <div class="card-body">
                            <link rel='stylesheet'
                                href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />

                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mail Template Modal -->
    <div class="modal fade bd-example-modal-lg popup" id="myModal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Mail</h4>
                    <button type="button" class="close" onclick="closeMailBoxPopup()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="schedule_id">
                    <div class="alert alert-success" role="alert" id="copied_alert" style="display:none">
                        Data Copied Successfully
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Time: </label>
                        <span id="time"></span>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">To: </label>
                        <a class="copy-text" data-clipboard-target="#emails">
                            <i class="fa fa-clipboard">
                            </i>
                        </a>
                        <input type="text" class="form-control" id="emails" readonly="readonly">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Subject: </label>
                        <a class="copy-text" data-clipboard-target="#subject">
                            <i class="fa fa-clipboard">
                            </i>
                        </a>
                        <input type="text" class="form-control" id="subject" readonly="readonly">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Body: </label>
                        <a class="copy copyi-button" id="copiq_btn">
                            <i class="fa fa-clipboard"></i>
                        </a>
                        </label>
                        {!! Form::textarea('body', '', ['class' => 'form-control my-editor', 'id' => 'myeditorinstance']) !!}
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="delete_btn" onclick="deleteMail()">Delete</button>
                    <button type="button" class="btn btn-default" onclick="closeMailBoxPopup()">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
    <script type="text/javascript">
        $('#myModal').on('hidden.bs.modal', function() {
            closeMailBoxPopup();
        });

        $(document).ready(function() {
            $('#calendar').fullCalendar({
                events: null,
                eventLimit: true,
                views: {
                    timeGrid: {
                        eventLimit: 6
                    }
                },
                eventClick: function(info) {
                    eventClicked(info);
                }
            });

            const dates = getStartEndDate();
            getCalendarData(dates);
            getNextPrevButton();
        });

        function getNextPrevButton() {

            $(".fc-next-button").click(function() {
                const dates = getStartEndDate();
                getCalendarData(dates);
            });

            $(".fc-prev-button").click(function() {
                const dates = getStartEndDate();
                getCalendarData(dates);
            });
        }

        function closeMailBoxPopup() {
            $('#myModal').modal('hide');
            $("#myModal").css("display", "none");
            $('body').css('overflow', 'scroll');
        }

        function getCalendarData(dates) {
            $.ajax({
                url: "/get-scheduler-data",
                dataType: 'json',
                data: dates,
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                success: function(res) {
                    if (res.status) {
                        refreshCalendar(res.data);
                    }
                }
            });
        }

        function refreshCalendar(events)
        {
            $("#calendar").fullCalendar('removeEvents');
            $('#calendar').fullCalendar('addEventSource', events);
        }

        function getStartEndDate() {
            const start = $("#calendar").fullCalendar('getView').start.format();
            const end = $("#calendar").fullCalendar('getView').end.format();

            return {
                start,
                end
            };
        }

        function eventClicked(eventDetail) {
            var info = JSON.parse(eventDetail['extra_information']);

            const emails = info['emails'];
            const subject = info['subject'];
            const body = info['body'];
            const id = info['id'];
            const time = info['schedule_time'];

            var datetime = new Date(time);

            const hour = datetime.getHours();
            const minute = datetime.getMinutes();
            const second = datetime.getSeconds();

            datetime = datetime.toLocaleDateString("en-GB", {
                year: "numeric",
                month: "2-digit",
                day: "2-digit",
            });

            const formatted_date = datetime +" "+ hour +":"+ minute +":"+ second;

            $("#schedule_id").val(id);
            $("#subject").val(subject);
            $("#emails").val(emails);
            $("#time").html(formatted_date);
            tinyMCE.activeEditor.setContent(body);

            $('#myModal').modal('toggle');
            $('#myModal').modal('show');
            $("#myModal").css("display", "block");
            $('body').css('overflow', 'hidden');
        }

        function deleteMail()
        {

            $.ajax({
                url: "/delete-scheduler-data/"+$("#schedule_id").val(),
                dataType: 'json',
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "DELETE",
                success: function(res) {
                    closeMailBoxPopup();
                    const dates = getStartEndDate();
                    getCalendarData(dates);
                    $('#calendar').fullCalendar('rerenderEvents');
                }
            });
        }
    </script>
@endpush
