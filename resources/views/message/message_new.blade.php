<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role().'.message.thread.store') }}" method="post">
            @csrf
            <div class="fpb-7 mb-3">
                <label class="form-label ol-form-label">{{ get_phrase('Select Client') }}</label>
                <select class="form-select ol-select2 from-control" data-toggle="select2" name="receiver_id" required>
                    @foreach (App\Models\User::where('id', '!=', auth()->user()->id)->get() as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>


            <div class="input-group d-flex justify-content-end">
                <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Next') }}</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(".ol-select2").select2({
        dropdownParent: $('#modal')
    });
    $(".ol-niceSelect").niceSelect({
        dropdownParent: $('#modal')
    });
</script>
@include('script')
