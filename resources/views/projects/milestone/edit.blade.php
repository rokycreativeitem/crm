<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.milestone.update', $milestone->id) }}" method="post"
            id="ajaxForm">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="fpb7 mb-2">
                        <input type="hidden" name="project_id" value="{{ $milestone->project_id }}" />
                        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
                        <input class="form-control ol-form-control" type="text" id="title" name="title"
                            value="{{ $milestone->title }}">
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label"
                            for="description">{{ get_phrase('Description') }}</label>
                        <input class="form-control ol-form-control" type="text" id="description" name="description"
                            value="{{ $milestone->description }}">
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="task_id">{{ get_phrase('Select Tasks') }}</label>
                        <div class="d-flex flex-column">
                            @php
                                $tasks = App\Models\Task::all();
                                $assignedTasks = json_decode($milestone->tasks, true) ?? [];
                            @endphp
                            @foreach ($tasks as $task)
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="task_{{ $task->id }}"
                                        name="tasks[]" value="{{ $task->id }}"
                                        {{ in_array($task->id, $assignedTasks) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="task_{{ $task->id }}">
                                        {{ $task->title }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
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
