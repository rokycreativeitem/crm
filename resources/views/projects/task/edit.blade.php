<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.task.update', $task->id) }}" method="post" id="ajaxTaskForm">
            @csrf
            <div class="row">
                <div class="col-12">
                    <input type="hidden" name="project_id" value="{{ $task->project_id }}" />
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
                        <input class="form-control ol-form-control" type="text" id="title" name="title"
                            value="{{ $task->title }}">
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="status">{{ get_phrase('Status') }}</label>
                        <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="status"
                            id="status">
                            <option value="not_started" {{ $task->status == 'not_started' ? 'selected' : '' }}>
                                {{ get_phrase('Not Started') }}</option>
                            <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>
                                {{ get_phrase('In Progress') }}</option>
                            <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>
                                {{ get_phrase('Completed') }}</option>
                        </select>
                    </div>
                    <div class="fpb7 mb-3">
                        <label class="form-label ol-form-label" for="progress">{{ get_phrase('Progress') }}</label>
                        <input type="number" class="form-control" id="progress" name="progress"
                            placeholder="Enter progress in %" value="{{ $task->progress }}" required>
                    </div>

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="team">{{ get_phrase('Team') }}</label>
                        <div class="d-flex flex-wrap">
                            @php
                                $assigned_staffs = json_decode($task->team, true) ?? [];
                            @endphp
                            @foreach ($staffs as $staff)
                                <div class="form-check pe-2">
                                    <input type="checkbox" class="form-check-input" id="staffs_{{ $staff->id }}"
                                        name="team[]" value="{{ $staff->id }}"
                                        {{ in_array($staff->id, $assigned_staffs) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="staffs_{{ $staff->id }}">
                                        {{ $staff->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="start_date">{{ get_phrase('Start Date') }}</label>
                        <input class="form-control ol-form-control" type="datetime-local" id="start_date" name="start_date" value="{{ date('Y-m-d H:i:s', $task->start_date) }}" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="end_date">{{ get_phrase('End Date') }}</label>
                        <input class="form-control ol-form-control" type="datetime-local" id="end_date" name="end_date" value="{{ date('Y-m-d H:i:s', $task->end_date) }}" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <button type="button" onclick="handleAjaxFormSubmission('ajaxTaskForm')" class="btn ol-btn-primary">{{ get_phrase('Update') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
