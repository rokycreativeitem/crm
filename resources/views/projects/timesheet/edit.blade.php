<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.timesheet.update', $timesheet->id) }}" method="post"
            id="ajaxTimeSheetForm">
            @csrf
            <div class="row">
                <div class="col-12">
                    <input type="hidden" name="project_id" value="{{ $timesheet->project_id }}" />
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="title">Title</label>
                        <input class="form-control ol-form-control" type="text" id="title" name="title"
                            value="{{ $timesheet->title }}">
                    </div>
                    <div class="fpb7 mb-2">
                        <label for="user" class="form-label">{{ get_phrase('Assign staff') }}</label>
                        <select class="form-control ol-form-control ol-modal-select2" id="staff" name="staff" required>
                            <option value="all">{{ get_phrase('Select staff') }}</option>
                            @foreach ($staffs as $staff)
                                <option value="{{$staff->id}}" {{$staff->id == $timesheet->staff ? 'selected':''}}> {{$staff->name}} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label"
                            for="timestamp_start">{{ get_phrase('Start Date') }}</label>
                        <input class="form-control ol-form-control" type="datetime-local" id="timestamp_start"
                            name="timestamp_start" value="{{ $timesheet->timestamp_start }}" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="timestamp_end">{{ get_phrase('End Date') }}</label>
                        <input class="form-control ol-form-control" type="datetime-local" id="timestamp_end"
                            name="timestamp_end" value="{{ $timesheet->timestamp_end }}" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <button type="button" onclick="handleAjaxFormSubmission('ajaxTimeSheetForm')" class="btn ol-btn-primary">{{get_phrase('Submit')}}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(".ol-modal-select2").select2({
        dropdownParent: $('#ajaxOffcanvas')
    });
</script>
