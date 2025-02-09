<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.project.store') }}" method="post" id="ajaxForm"> @csrf
            <div class="row">
                <div class="col-12">
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
                        <input class="form-control ol-form-control" placeholder="{{get_phrase('Enter title')}}" type="text" id="title" name="title" required>
                    </div>
                    <div class="fpb-7 mb-3">
                        <label class="form-label ol-form-label">{{ get_phrase('Select Client') }}</label>
                        <select class="form-select ol-select2 ol-form-control" name="client_id" required>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="code">{{ get_phrase('Code') }}</label>
                        <input class="form-control ol-form-control" placeholder="{{get_phrase('Enter code')}}" type="text" id="code" name="code" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="description">{{ get_phrase('Description') }}</label>
                        <textarea class="form-control ol-form-control" id="description" name="description" placeholder="{{get_phrase('Enter description')}}" required></textarea>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="category_id">{{ get_phrase('Category') }}</label>
                        <select class="form-select ol-select2 ol-form-control" name="category_id" required>
                            <option value=""> {{get_phrase('Select category')}} </option>
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
                        <input class="form-control ol-form-control" type="number" id="budget" name="budget" placeholder="{{get_phrase('Enter budget')}}" required>
                    </div>

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="status">{{ get_phrase('Status') }}</label>
                        <select class="form-control ol-form-control ol-niceSelect" id="status" name="status" required>
                            <option value="in_progress">{{ get_phrase('In Progress') }}</option>
                            <option value="not_started">{{ get_phrase('Not Started') }}</option>
                            <option value="completed">{{ get_phrase('Completed') }}</option>
                        </select>
                    </div>

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="note">{{ get_phrase('Progress') }}</label>
                        <select class="form-control ol-form-control ol-select2" data-toggle="select2" id="progress" name="progress" required>
                            <option value="">{{ get_phrase('Select progress') }}</option>
                            @php
                                for ($i = 1; $i <= 100; $i++) {
                                    echo "<option value=\"$i\">$i</option>";
                                }
                            @endphp
                        </select>
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
<script>
    $(".ol-select2").select2({
        dropdownParent: $('#ajaxOffcanvas')
    });
    $(".ol-niceSelect").niceSelect({
        dropdownParent: $('#ajaxOffcanvas')
    });
</script>
@include('ajax')
{{-- @include('init_js') --}}
{{-- @include('projects.budget_range') --}}
