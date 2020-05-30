<div class="modal-dialog" role="document">
    <form action="{{ url('/event') }}" method="POST">
    {{ csrf_field() }}
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
                    <textarea required class="form-control" rows="3" name="description" id="description"></textarea>
                </div>

                <div class="form-group">
                    <label for="live_youtube_link">LIVE YouTube Link</label>
                    <input  type="text" class="form-control" name="live_youtube_link" id="live_youtube_link">
                </div>

                <div class="form-group">
                    <label for="live_facebook_link">LIVE Facebook Link</label>
                    <input type="text" class="form-control" name="live_facebook_link" id="live_facebook_link">
                </div>

                <div class="form-group">
                    <label for="live_instagram_link">LIVE Instgram Link</label>
                    <input type="text" class="form-control" name="live_instagram_link" id="live_instagram_link">
                </div>

                <div class="form-group">
                    <label for="live_web_link">LIVE Web Link</label>
                    <input type="text" class="form-control" name="live_web_link" id="live_web_link">
                </div>

                <div class="form-group">
                    <label for="youtube_link">YouTube Link</label>
                    <input type="text" class="form-control" name="youtube_link" id="youtube_link">
                </div>

                <div class="form-group">
                    <label for="facebook_link">Facebook Link</label>
                    <input type="text" class="form-control" name="facebook_link" id="facebook_link">
                </div>

                <div class="form-group">
                    <label for="instagram_link">Instagram Link</label>
                    <input type="text" class="form-control" name="instagram_link" id="instagram_link">
                </div>

                <div class="form-group">
                    <label for="web_link">Web Link</label>
                    <input type="text" class="form-control" name="web_link" id="web_link">
                </div>

                <div class="form-group">
                    <div class="form-row">
                        <div class="col">
                            <label for="start">Start time</label>
                            <input type="text" class="timepicker form-control" name="start_time" id="start_time">
                        </div>
                        <div class="col">
                            <label for="end">End time</label>
                            <input type="text" class="timepicker form-control" name="end_time" id="end_time">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="days">Days</label>
                    <select multiple class="form-control" name="days_of_week[]" id="days_of_week">
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
                    <select required class="form-control" name="category_id" id="category_id">
                        @foreach ($categories as $category)
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
    </form>
</div>
<script type="text/javascript">

    $(document).ready(function() {

        // timepicker for modal
        $('.timepicker').timepicker({
            timeFormat: 'HH:mm',
            minTime: '07:00',
            maxTime: '18:00',
            interval: 30,
            zindex: 9999999
        });

    });
</script>