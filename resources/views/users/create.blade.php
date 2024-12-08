<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route('admin.user.store') }}" method="post" id="ajaxForm" enctype="multipart/form-data">@csrf
            <div class="row">
                <div class="col-12">
                    <div class="fpb7 mb-2">
                        <input type="hidden" name="role_id" value="{{ $role_id }}" />
                        <label class="form-label ol-form-label" for="name">{{ get_phrase('Name') }}</label>
                        <input class="form-control ol-form-control" type="text" id="name" name="name" placeholder="{{ get_phrase('Name') }}" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="email">{{ get_phrase('Email') }}</label>
                        <input class="form-control ol-form-control" type="email" id="email" name="email" placeholder="{{ get_phrase('Email') }}" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="password">{{ get_phrase('Password') }}</label>
                        <input class="form-control ol-form-control" type="password" id="password" name="password" placeholder="{{ get_phrase('Password') }}" required>
                    </div>
                    <div class="fpb-7 mb-2">
                        <label class="form-label ol-form-label" for="role_id">{{ get_phrase('User Type') }}</label>
                        <div class="d-flex flex-row flex-wrap align-items-center">
                            @foreach ($roles as $role)
                                <div class="form-check me-3">
                                    <input type="checkbox" class="form-check-input" id="role_{{ $role->id }}" name="role[]" value="{{ $role->id }}">
                                    <label class="form-check-label" for="role_{{ $role->id }}">
                                        {{ $role->title }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="photo">{{ get_phrase('Photo') }}</label>
                        <input class="form-control ol-form-control" type="file" id="photo" name="photo">
                    </div>
                    <div class="fpb7 mb-2">
                        <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Add user') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@include('script')
@include('ajax')
