<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.task.update', $task->id) }}" method="post" id="ajaxForm">
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
                            placeholder="Enter progress in %" value="{{ old('progress', $task->progress) }}" required>
                    </div>

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="team">{{ get_phrase('Team') }}</label>
                        <div class="d-flex flex-column">
                            @php
                                $assigned_staffs = json_decode($task->team, true) ?? [];
                            @endphp
                            @foreach ($staffs as $staff)
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="team_{{ $staff->id }}"
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
                        <input class="form-control ol-form-control" type="text" id="start_date" name="start_date"
                            value="{{ date('d-m-Y', $task->start_date) }}" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="end_date">{{ get_phrase('End Date') }}</label>
                        <input class="form-control ol-form-control" type="text" id="end_date" name="end_date"
                            value="{{ date('d-m-Y', $task->end_date) }}" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Update') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@include('ajax')
