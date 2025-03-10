<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.timesheet.store') }}" method="post" id="ajaxTimeSheetForm">
            @csrf
            <div class="row">
                <div class="col-12">
                    <input type="hidden" name="project_id" value="{{ $project_id }}" />
                    {{-- <input type="hidden" name="milestone_id" value="" /> --}}
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
                        <input class="form-control ol-form-control" type="text" id="title" name="title"
                            required placeholder="{{get_phrase('Enter Title')}}">
                    </div>
                    <div class="fpb7 mb-2">
                        <label for="staff" class="form-label">{{ get_phrase('Assign staff') }}</label>
                        <select class="form-control ol-form-control ol-select2 ol-modal-select2" id="staff" name="staff" required>
                            <option value="all">{{ get_phrase('Select staff') }}</option>
                            @foreach ($staffs as $staff)
                                <option value="{{$staff->id}}"> {{$staff->name}} </option>
                            @endforeach
                        </select>
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
                        <button type="button" onclick="handleAjaxFormSubmission('ajaxTimeSheetForm')" class="btn ol-btn-primary">{{ get_phrase('Submit') }}</button>
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
