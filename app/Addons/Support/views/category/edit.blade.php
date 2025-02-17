<form action="{{ route(get_current_user_role() . '.addon.ticket.category.update', ['id' => $category->id]) }}"
    method="post" enctype="multipart/form-data" id="ajaxForm">
    @csrf
    <div class="fpb7 mb-2">
        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
        <input type="text" class="form-control ol-form-control" name="title" id="title"
            value="{{ $category->title }}">
    </div>
    <div class="fpb7 mb-2">
        <label class="form-label ol-form-label" for="status">{{ get_phrase('Status') }}</label>
        <select class="form-control ol-form-control" name="status" id="status">
            <option value="0" {{ $category->status == 0 ? 'selected' : '' }}> {{ get_phrase('De Active') }}
            </option>
            <option value="1" {{ $category->status == 1 ? 'selected' : '' }}> {{ get_phrase('Active') }}
            </option>
        </select>
    </div>
    <div class="fpb7 mb-2">
        <button type="submit" class="btn ol-btn-primary"> {{ get_phrase('Update') }} </button>
    </div>


</form>
@include('ajax')
