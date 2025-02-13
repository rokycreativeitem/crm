<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.addon.ticket.store') }}" method="post"
            enctype="multipart/form-data" id="">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="subject">{{ get_phrase('Subject') }}</label>
                        <input class="form-control ol-form-control" type="text" id="subject"
                            placeholder="Enter your subject here" name="subject" required>
                    </div>

                    @if (get_current_user_role() == 'admin')
                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label">{{ get_phrase('Select Client') }}</label>
                            <select class="form-control ol-form-control ol-select2" name="client_id" required>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    @if (get_current_user_role() == 'admin')
                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label">{{ get_phrase('Select Staff') }}</label>
                            <select class="form-control ol-form-control ol-select2" name="staff_id" required>
                                @foreach ($staffs as $staff)
                                    <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="status">{{ get_phrase('Status') }}</label>
                        <select class="form-control ol-form-control ol-select2" data-toggle="select2" id="status"
                            name="status" required>
                            <option value="">{{ get_phrase('Select') }}</option>
                            <option value="in_progress">{{ get_phrase('In Progress') }}</option>
                            <option value="not_started">{{ get_phrase('Not Started') }}</option>
                            <option value="completed">{{ get_phrase('Completed') }}</option>
                        </select>
                    </div>

                    {{-- <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="priority">{{ get_phrase('Priority') }}</label>
                        <input class="form-control ol-form-control" type="text" id="priority"
                            placeholder="Enter your priority here" name="priority" required>
                    </div> --}}

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="priority_id">{{ get_phrase('priority') }}</label>
                        <select class="form-control ol-form-control ol-select2" name="priority_id" required>
                            <option value=""> {{ get_phrase('select priority') }} </option>
                            @foreach ($priorities as $priority)
                                <option value="{{ $priority->id }}">{{ $priority->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="category_id">{{ get_phrase('Category') }}</label>
                        <select class="form-control ol-form-control ol-select2" name="category_id" required>
                            <option value=""> {{ get_phrase('select category') }} </option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
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
