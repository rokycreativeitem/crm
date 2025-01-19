<form action="{{ route(get_current_user_role() . '.project.category.store', ['id' => $category->id]) }}" method="post" enctype="multipart/form-data" id="ajaxForm">
    @csrf
    <div class="fpb7 mb-2">
        <label class="form-label ol-form-label" for="name">{{ get_phrase('Name') }}</label>
        <input type="text" class="form-control ol-form-control" name="name" id="name" value="{{ $category->name }}">
    </div>
    <div class="fpb7 mb-2">
        <label class="form-label ol-form-label" for="parent">{{ get_phrase('Parent Category') }}</label>
        <select class="form-select avalynx-select" name="parent" id="parent">
            @foreach ($categories as $parent)
                <option value="{{ $parent->id }}" {{ $category->parent == $parent->id ? 'selected' : '' }}> {{ $parent->name }} </option>
            @endforeach
        </select>
    </div>
    <div class="fpb7 mb-2">
        <label class="form-label ol-form-label" for="status">{{ get_phrase('Status') }}</label>
        <select class="form-control ol-form-control" name="status" id="status">
            <option value="0" {{ $category->status == 0 ? 'selected' : '' }}> {{ get_phrase('De Active') }} </option>
            <option value="1" {{ $category->status == 1 ? 'selected' : '' }}> {{ get_phrase('Active') }} </option>
        </select>
    </div>
    <div class="fpb7 mb-2">
        <button type="submit" class="btn ol-btn-primary"> {{ get_phrase('Update') }} </button>
    </div>


</form>
@include('ajax')
