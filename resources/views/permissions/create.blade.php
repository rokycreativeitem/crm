<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.permission.store') }}" method="POST" id="ajaxForm"> @csrf
            <div class="row">
                <div class="col-12">
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
                        <input class="form-control ol-form-control" type="text" id="title" name="title"
                            required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="route">{{ get_phrase('Route') }}</label>
                        <input class="form-control ol-form-control" type="text" id="route" name="route"
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
