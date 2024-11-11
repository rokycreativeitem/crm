<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.timesheet.store') }}" method="post" id="ajaxForm">
            @csrf
            <div class="row">
                <div class="col-12">
                    <input type="hidden" name="project_id" value="{{ $project_id }}" />
                    {{-- <input type="hidden" name="milestone_id" value="" /> --}}
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
                        <input class="form-control ol-form-control" type="text" id="title" name="title"
                            required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label"
                            for="timestamp_start">{{ get_phrase('Start Date') }}</label>
                        <input class="form-control ol-form-control" type="datetime-local" id="timestamp_start"
                            name="timestamp_start" value="2024-09-01T08:30" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="timestamp_end">{{ get_phrase('End Date') }}</label>
                        <input class="form-control ol-form-control" type="datetime-local" id="timestamp_end"
                            name="timestamp_end" value="2024-09-01T08:30" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Submit') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@include('script')
@include('ajax')
