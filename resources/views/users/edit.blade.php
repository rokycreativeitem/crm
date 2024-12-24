<div class="ol-card p-3">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.user.update', $user->id) }}" method="post" enctype="multipart/form-data" id="ajaxForm">@csrf
            <div class="row">
                <div class="col-12">
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="name">{{ get_phrase('Name') }}</label>
                        <input class="form-control ol-form-control" type="text" id="name" name="name" value="{{ $user->name }}" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="email">{{ get_phrase('Email') }}</label>
                        <input class="form-control ol-form-control" type="email" id="email" name="email" value="{{ $user->email }}" required>
                    </div>
                    <div class="fpb-7 mb-2">
                        <label class="form-label ol-form-label" for="role_id">{{ get_phrase('User Type') }}</label>
                        <div class="d-flex flex-row flex-wrap align-items-center">
                            @php
                                $roles = App\Models\Role::all();
                            @endphp
                            @foreach ($roles as $role)
                                <div class="radio-check form-check me-3">
                                    <input type="radio" class="radio-input form-check-input" id="role_{{ $role->id }}" name="role_id" value="{{ $role->id }}" @checked($user->role_id == $role->id)>
                                    <label class="form-check-label" for="role_{{ $role->id }}">
                                        {{ $role->title }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="file">{{ get_phrase('Photo') }}</label>
                        <input class="form-control ol-form-control" type="file" id="photo" name="photo">
                    </div>

                    <div class="fpb7 mb-2">
                        <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Edit user') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@include('script')
@include('ajax')
