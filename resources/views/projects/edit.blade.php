<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.project.update', $project->code) }}" method="post"
            id="ajaxForm">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
                        <input class="form-control ol-form-control" type="text" id="title" name="title"
                            value="{{ $project->title }}" required>
                    </div>
                    <div class="fpb-7 mb-3">
                        <label class="form-label ol-form-label">{{ get_phrase('Select Client') }}</label>
                        <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="client_id"
                            required>
                            <option value="">{{ get_phrase('Select a client') }}</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}"
                                    {{ $project->client_id == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="code">{{ get_phrase('Code') }}</label>
                        <input class="form-control ol-form-control" type="text" id="code" name="code"
                            value="{{ $project->code }}" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label"
                            for="description">{{ get_phrase('Description') }}</label>
                        <textarea class="form-control ol-form-control" id="description" name="description" required>{{ $project->description }}</textarea>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label"
                            for="category_id">{{ get_phrase('Category ID') }}</label>
                        <input class="form-control ol-form-control" type="number" id="category_id" name="category_id"
                            value="{{ $project->category_id }}" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="staffs">{{ get_phrase('Staffs') }}</label>
                        <div class="d-flex flex-column">
                            @php
                                $assigned_staffs = json_decode($project->staffs, true) ?? [];
                            @endphp
                            @foreach ($staffs as $staff)
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="staffs_{{ $staff->id }}"
                                        name="staffs[]" value="{{ $staff->id }}"
                                        {{ in_array($staff->id, $assigned_staffs) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="staffs_{{ $staff->id }}">
                                        {{ $staff->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="budget">{{ get_phrase('Budget') }}</label>
                        <input class="form-control ol-form-control" type="number" id="budget" name="budget"
                            value="{{ $project->budget }}" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="status">{{ get_phrase('Status') }}</label>
                        <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="status"
                            id="status">
                            <option value="not_started" {{ $project->status == 'not_started' ? 'selected' : '' }}>
                                {{ get_phrase('Not Started') }}</option>
                            <option value="in_progress" {{ $project->status == 'in_progress' ? 'selected' : '' }}>
                                {{ get_phrase('In Progress') }}</option>
                            <option value="completed" {{ $project->status == 'completed' ? 'selected' : '' }}>
                                {{ get_phrase('Completed') }}</option>
                        </select>
                    </div>
                    <div class="fpb7 mb-3">
                        <label class="form-label ol-form-label" for="progress">{{ get_phrase('Progress') }}</label>
                        <input type="number" class="form-control" id="progress" name="progress"
                            placeholder="Enter progress in %" value="{{ old('progress', $project->progress) }}"
                            required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="note">{{ get_phrase('Note') }}</label>
                        <textarea class="form-control ol-form-control" id="note" name="note" required>{{ $project->note }}</textarea>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="privacy">{{ get_phrase('Privacy') }}</label>
                        <input class="form-control ol-form-control" type="text" id="privacy" name="privacy"
                            value="{{ $project->privacy }}" required>
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
@include('script')
