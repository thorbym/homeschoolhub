@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    Click to filter:&nbsp
                    @foreach ($data['categories'] as $category)
                        <a href="#" id="{{ $category->category }}" class="btn" style="background-color: {{ $category->colour }}">{{ $category->category }}</a>&nbsp&nbsp
                    @endforeach
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<form action="{{ route('event') }}" method="POST">
    {{ csrf_field() }}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h4>Event</h4>
                    <br />

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input required type="text" class="form-control" name="title" id="title">
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" rows="3" name="description" id="description"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="link">Link</label>
                        <input required type="text" class="form-control" name="link" id="link">
                    </div>

                    <div class="form-group">
                        <label for="catchup_link">Watch later</label>
                        <input required type="text" class="form-control" name="catchup_link" id="catchup_link">
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col">
                                <label for="start">Start time</label>
                                <input required type="text" class="timepicker form-control" name="start_time" id="start_time">
                            </div>
                            <div class="col">
                                <label for="end">End time</label>
                                <input required type="text" class="timepicker form-control" name="end_time" id="end_time">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="days">Days</label>
                        <select required multiple class="form-control" name="days_of_week[]" id="days">
                            <option value="1">Monday</option>
                            <option value="2">Tuesday</option>
                            <option value="3">Wednesday</option>
                            <option value="4">Thursday</option>
                            <option value="5">Friday</option>
                            <option value="6">Saturday</option>
                            <option value="0">Sunday</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select class="form-control" name="category_id" id="category_id">
                            @foreach ($data['categories'] as $category)
                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="minimum_age">Minimum age</label>
                                <input required type="number" class="form-control" name="minimum_age" id="minimum_age" min=0 max=16>
                            </div>
                            <div class="col">
                                <label for="maximum_age">Maximum age</label>
                                <input required type="number" class="form-control" name="maximum_age" id="maximum_age" min=0 max=16>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="dfe_approved" id="dfe_approved">
                            <label class="form-check-label" for="dfe_approved">DfE approved</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="requires_supervision" id="requires_supervision">
                            <label class="form-check-label" for="requires_supervision">Supervision required</label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

<script>

    var isAdmin = @json(Auth::user()->isAdmin());
    var events = @json($data['events']);

    document.addEventListener('DOMContentLoaded', function() {

        // timepicker for modal
        $('.timepicker').timepicker({
            timeFormat: 'HH:mm',
            minTime: '07:00',
            maxTime: '18:00',
            interval: 30,
            zindex: 9999999
        });

        // fullcalendar stuff
        var calendarEl = document.getElementById('calendar');

        var calendar = new Calendar.Calendar(calendarEl, {
            defaultView: 'timeGridDay',
            minTime: "07:00:00",
            maxTime: "18:00:00",
            header: {
                left: 'prev,next',
                center: 'title',
                right: 'timeGridDay,timeGridWeek'
            },
            plugins: [ timeGridPlugin, isAdmin ? interaction : '' ],
            events: events,
            editable: isAdmin ? true : false,
            nowIndicator: true,
            slotEventOverlap: false,
            navLinks: true,
            locale: 'en-gb',
            firstDay: 1,
            allDaySlot: false,
            views: {
                timeGridWeek: {
                    columnHeaderFormat: { weekday: 'short', month: 'short', day: 'numeric', omitCommas: true }
                },
            },
            navLinkDayClick: function(date, jsEvent) {
                calendar.changeView('timeGridDay', date);
            },
            eventRender: function(info) {
                // find the event's category
                var category = info.event.extendedProps.category;
                var colour = info.event.extendedProps.colour;
                //info.event.setProp('eventBackgroundColor', colour);
                $(info.el).css({'background-color': colour, 'border-color': colour});
                // check if the matching filter button is disabled - if yes, don't show the event
                var filterButton = $('a#' + category);
                return !(filterButton.hasClass('disabled'))
            },
            dateClick: function(info) {
                if (isAdmin) {
                    $('#editModal').modal();
                }
            },
            eventClick: function(info) {
                var id = info.event.id;
                axios.get('/event/' + id)
                    .then(function (response) {
                        // do something with the data?
                    })
                    .catch(function (error) {
                        console.log(error);
                });
            },
        });

        calendar.render();

        $("a[class^='btn']").on('click', function(e){
            e.preventDefault();
            var button = $(e.currentTarget);
            if (button.hasClass('disabled')) {
                button.removeClass('disabled').blur();
            } else {
                button.addClass('disabled').css('pointer-events', 'auto').blur();
            }
            calendar.rerenderEvents();
        });

    });
</script>