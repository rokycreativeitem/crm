<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.project.store') }}" method="post" id="ajaxForm"> @csrf
            <div class="row">
                <div class="col-12">
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
                        <input class="form-control ol-form-control" type="text" id="title" name="title" required>
                    </div>
                    <div class="fpb-7 mb-3">
                        <label class="form-label ol-form-label">{{ get_phrase('Select Client') }}</label>
                        <select class="form-select avalynx-select" name="client_id" required>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="code">{{ get_phrase('Code') }}</label>
                        <input class="form-control ol-form-control" type="text" id="code" name="code" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="description">{{ get_phrase('Description') }}</label>
                        <textarea class="form-control ol-form-control" id="description" name="description" required></textarea>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="category_id">{{ get_phrase('Category') }}</label>
                        <select class="form-select avalynx-select" name="category_id" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="staffs">{{ get_phrase('Staffs') }}</label>
                        <div class="d-flex flex-wrap">
                            @foreach ($staffs as $staff)
                                <div class="form-check me-2">
                                    <input type="checkbox" class="form-check-input" id="staffs_{{ $staff->id }}" name="staffs[]" value="{{ $staff->id }}">
                                    <label class="form-check-label" for="staffs_{{ $staff->id }}">
                                        {{ $staff->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="budget">{{ get_phrase('Budget') }}</label>
                        <input class="form-control ol-form-control" type="number" id="budget" name="budget" required>
                    </div>

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="status">{{ get_phrase('Status') }}</label>
                        <select class="form-control ol-form-control ol-niceSelect" id="status" name="status" required>
                            <option value="in_progress">{{ get_phrase('In Progress') }}</option>
                            <option value="not_started">{{ get_phrase('Not Started') }}</option>
                            <option value="completed">{{ get_phrase('Completed') }}</option>
                        </select>
                    </div>
                    <div class="fpb7 mb-3">
                        <label class="form-label ol-form-label" for="progress">{{ get_phrase('Progress') }}</label>
                        <div id="progress-slider"></div>
                        <div class="d-flex align-items-center mt-3 gap-2">
                            <p class="progress-range">
                                {{ get_phrase('Value') }}:
                            </p>
                            <input type="number" id="progress-input" name="progress" class="form-control ol-form-control progress-range-input " min="0" max="100" readonly>%
                        </div>
                    </div>

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="note">{{ get_phrase('Note') }}</label>
                        <textarea class="form-control ol-form-control" id="note" name="note" required></textarea>
                    </div>

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="privacy">{{ get_phrase('Privacy') }}</label>
                        <select class="form-control ol-form-control ol-niceSelect" data-toggle="select2" id="privacy" name="privacy" required>
                            <option value="">{{ get_phrase('Select Privacy') }}</option>
                            <option value="public">{{ get_phrase('Public') }}</option>
                            <option value="private">{{ get_phrase('Private') }}</option>
                        </select>
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
@include('init_js')
@include('projects.budget_range')
