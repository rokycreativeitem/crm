<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.milestone.store') }}" method="post" id="ajaxForm">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="fpb7 mb-2">
                        <input type="hidden" name="project_id" value="{{ $project_id }}" />
                        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
                        <input class="form-control ol-form-control" type="text" id="title" name="title" placeholder="{{ get_phrase('Name') }}">
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="description">{{ get_phrase('Description') }}</label>
                        <textarea class="form-control ol-form-control" name="description" id="description" cols="30" rows="5"placeholder="{{ get_phrase('Type here...') }}"></textarea>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="task_id">{{ get_phrase('Select Tasks') }}</label>
                        <div class="d-flex flex-row flex-wrap align-items-center">
                            @php
                                $tasks = App\Models\Task::all();
                            @endphp
                            @foreach ($tasks as $task)
                                <div class="form-check me-3">
                                    <input type="checkbox" class="form-check-input" id="task_{{ $task->id }}" name="tasks[]" value="{{ $task->id }}">
                                    <label class="form-check-label" for="task_{{ $task->id }}">
                                        {{ $task->title }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
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
