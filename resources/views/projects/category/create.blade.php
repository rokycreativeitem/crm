
<form action="{{route(get_current_user_role().'.project.category.store')}}" method="post" enctype="multipart/form-data" id="crud_form">
    @csrf
    <div class="fpb7 mb-2">
        <label class="form-label ol-form-label" for="name">{{ get_phrase('Name') }}</label>
        <input type="text" class="form-control ol-form-control" name="name" id="name" placeholder="{{get_phrase('e.g.Jon Due')}}">
    </div>
    <div class="fpb7 mb-2">
        <label class="form-label ol-form-label" for="parent">{{ get_phrase('Parent Category') }}</label>
        <select class="form-control ol-form-control" name="parent" id="parent">
            <option value="0"> {{get_phrase('Select Category')}} </option>
            @foreach ($categories as $parent)
                <option value="{{$parent->id}}"> {{$parent->name}} </option>
            @endforeach
        </select>
    </div>
    <div class="fpb7 mb-2">
        <label class="form-label ol-form-label" for="status">{{ get_phrase('Status') }}</label>
        <select class="form-control ol-form-control" name="status" id="status">
            <option value="0"> {{get_phrase('De Active')}} </option>
            <option value="1"> {{get_phrase('Active')}} </option>
        </select>
    </div>
    <div class="fpb7 mb-2">
        <button type="submit" class="btn btn-primary"> {{get_phrase('Save')}} </button>
    </div>


</form>
@include('ajax')