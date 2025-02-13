<form action="{{ route(get_current_user_role() . '.addon.ticket.category.store') }}" method="post"
    enctype="multipart/form-data" id="ajaxForm">
    @csrf
    <div class="fpb7 mb-2">
        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
        <input type="text" class="form-control ol-form-control" name="title" id="title"
            placeholder="{{ get_phrase('e.g.Jon Due') }}" required>
    </div>
    <div class="fpb7 mb-2">
        <label class="form-label ol-form-label" for="status">{{ get_phrase('Status') }}</label>
        <select class="form-control ol-form-control" name="status" id="status" required>
            <option value="0"> {{ get_phrase('De Active') }} </option>
            <option value="1"> {{ get_phrase('Active') }} </option>
        </select>
    </div>
    <div class="fpb7 mb-2">
        <button type="submit" class="btn ol-btn-primary"> {{ get_phrase('Save') }} </button>
    </div>


</form>
@include('ajax')
