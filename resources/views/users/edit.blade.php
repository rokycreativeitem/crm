@php
    $roles = App\Models\Role::all();
@endphp
<div class="ol-card p-3">
    <div class="ol-card-body">
        <div class="row">
            <div class="col-12">
                <form action="{{ route(get_current_user_role() . '.user.update', $user->id) }}" method="post" enctype="multipart/form-data" id="ajaxForm">@csrf
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="name">{{ get_phrase('Name') }}</label>
                        <input class="form-control ol-form-control" type="text" id="name" name="name" value="{{ $user->name }}" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="email">{{ get_phrase('Email') }}</label>
                        <input class="form-control ol-form-control" type="email" id="email" name="email" value="{{ $user->email }}" required>
                    </div>
                    <div class="fpb-7 mb-3">
                        <label class="form-label ol-form-label" for="role_id">{{ 'User Type' }}</label>
                        <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="role_id" id="role_id" required>
                            <option value="">{{ get_phrase('Select a role') }}</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ $role->id == $user->role_id ? 'selected' : '' }}>
                                    {{ $role->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="file">{{ get_phrase('Photo') }}</label>
                        <input class="form-control ol-form-control" type="file" id="photo" name="photo">
                    </div>

                    <div class="fpb7 mb-2">
                        <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Edit user') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('ajax')
