<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.event.store') }}" method="post" id="ajaxForm">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
                        <input class="form-control ol-form-control" type="text" id="title" name="title">
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="start_date">{{ get_phrase('Start Date') }}</label>
                        <input class="form-control ol-form-control" type="datetime-local" id="start_date"
                            name="start_date" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="end_date">{{ get_phrase('End Date') }}</label>
                        <input class="form-control ol-form-control" type="datetime-local" id="end_date" name="end_date"
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

@include('ajax')
