@php
    $roles = App\Models\Role::all();
@endphp
<div class="ol-card p-3">
    <div class="ol-card-body">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('admin.user.store') }}" method="post" id="ajaxForm" enctype="multipart/form-data">@csrf
                    <div class="fpb7 mb-2">
                        <input type="hidden" name="role_id" value="{{ $role_id }}" />
                        <label class="form-label ol-form-label" for="name">{{ get_phrase('Name') }}</label>
                        <input class="form-control ol-form-control" type="text" id="name" name="name" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="email">{{ get_phrase('Email') }}</label>
                        <input class="form-control ol-form-control" type="email" id="email" name="email" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="password">{{ get_phrase('Password') }}</label>
                        <input class="form-control ol-form-control" type="password" id="password" name="password" required>
                    </div>
                    <div class="fpb-7 mb-3">
                        <label class="form-label ol-form-label" for="role_id">{{ 'User Type' }}</label>
                        <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="role_id" id="role_id" required>
                            <option value="">{{ get_phrase('Select an role') }}</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="photo">{{ get_phrase('Photo') }}</label>
                        <input class="form-control ol-form-control" type="file" id="photo" name="photo">
                    </div>
                    <div class="fpb7 mb-2">
                        <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Add user') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('ajax')
@include('script')
