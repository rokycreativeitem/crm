<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.addon.ticket.update', $ticket->id) }}" method="post"
            id="">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="subject">{{ get_phrase('Subject') }}</label>
                        <input class="form-control ol-form-control" type="text" id="subject" name="subject"
                            value="{{ $ticket->subject }}" required>
                    </div>
                    @if (get_current_user_role() == 'admin')
                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label">{{ get_phrase('Select Client') }}</label>
                            <select class="form-control ol-form-control ol-select2" data-toggle="select2"
                                name="client_id" required>
                                <option value="">{{ get_phrase('Select a client') }}</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}"
                                        {{ $ticket->client_id == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    @if (get_current_user_role() == 'admin')
                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label">{{ get_phrase('Select staff') }}</label>
                            <select class="form-control ol-form-control ol-select2" data-toggle="select2"
                                name="staff_id" required>
                                <option value="">{{ get_phrase('Select a staff') }}</option>
                                @foreach ($staffs as $staff)
                                    <option value="{{ $staff->id }}"
                                        {{ $ticket->staff_id == $staff->id ? 'selected' : '' }}>
                                        {{ $staff->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="status">{{ get_phrase('Status') }}</label>
                        <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="status"
                            id="status">
                            <option value="not_started" {{ $ticket->status == 'not_started' ? 'selected' : '' }}>
                                {{ get_phrase('Not Started') }}</option>
                            <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>
                                {{ get_phrase('In Progress') }}</option>
                            <option value="completed" {{ $ticket->status == 'completed' ? 'selected' : '' }}>
                                {{ get_phrase('Completed') }}</option>
                        </select>
                    </div>

                    {{-- <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="priority">{{ get_phrase('Priority') }}</label>
                        <textarea class="form-control ol-form-control" id="priority" name="priority" required>{{ $ticket->priority }}</textarea>
                    </div> --}}
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="priority_id">{{ get_phrase('Priority') }}</label>
                        <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="priority_id"
                            required>
                            <option value=""> {{ get_phrase('select priority') }} </option>
                            @foreach ($priorities as $priority)
                                <option value="{{ $priority->id }}"
                                    {{ $ticket->priority_id == $priority->id ? 'selected' : '' }}>
                                    {{ $priority->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="category_id">{{ get_phrase('Category') }}</label>
                        <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="category_id"
                            required>
                            <option value=""> {{ get_phrase('select category') }} </option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $ticket->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->title }}
                                </option>
                            @endforeach
                        </select>
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
