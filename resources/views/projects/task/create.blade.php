<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.task.store') }}" method="post" id="ajaxForm">
            @csrf
            <div class="row">
                <div class="col-12">
                    <input type="hidden" name="project_id" value="{{ $project_id }}" />
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
                        <input class="form-control ol-form-control" type="text" id="title" name="title">
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="status">{{ get_phrase('Status') }}</label>
                        <select class="form-control ol-form-control ol-select2" data-toggle="select2" id="status"
                            name="status" required>
                            <option value="">
                                {{ get_phrase('Select') }}</option>
                            <option value="in_progress">{{ get_phrase('In Progress') }}</option>
                            <option value="not_started">{{ get_phrase('Not Started') }}</option>
                            <option value="completed">{{ get_phrase('Completed') }}</option>
                        </select>
                    </div>
                    <div class="fpb7 mb-3">
                        <label class="form-label ol-form-label" for="progress">{{ get_phrase('Progress') }}</label>
                        <input type="number" class="form-control" id="progress" name="progress"
                            placeholder="Enter progress in %" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="team">{{ get_phrase('Team') }}</label>
                        <div class="d-flex flex-row flex-wrap align-items-center">
                            @foreach ($staffs as $staff)
                                <div class="form-check me-3">
                                    <input type="checkbox" class="form-check-input" id="team_{{ $staff->id }}"
                                        name="team[]" value="{{ $staff->id }}">
                                    <label class="form-check-label" for="team_{{ $staff->id }}">
                                        {{ $staff->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="start_date">{{ get_phrase('Start Date') }}</label>
                        <input class="form-control ol-form-control" type="date" id="start_date" name="start_date"
                            required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="end_date">{{ get_phrase('End Date') }}</label>
                        <input class="form-control ol-form-control" type="date" id="end_date" name="end_date"
                            required>
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
