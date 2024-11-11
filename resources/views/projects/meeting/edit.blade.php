<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.meeting.update', $meeting->id) }}" method="post"
            id="">
            @csrf
            <div class="row">
                <div class="col-12">
                    <input type="hidden" name="project_id" value="{{ $meeting->project_id }}" />
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
                        <input class="form-control ol-form-control" type="text" id="title" name="title"
                            value="{{ $meeting->title }}">
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="timestamp_meeting">{{ get_phrase('Time') }}</label>
                        <input type="datetime-local" class="form-control ol-form-control" id="timestamp_meeting"
                            name="timestamp_meeting" value="{{ $meeting->timestamp_meeting }}">
                    </div>
                    <div class="fpb7 mb-2">
                        <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Submit') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@include('ajax')
