<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route('admin.message.thread.store') }}" method="post">
            @csrf
            <div class="fpb-7 mb-3">
                <label class="form-label ol-form-label">{{ get_phrase('Select Client') }}</label>
                <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="receiver_id" required>
                    <option value="">{{ get_phrase('Select a client') }}</option>
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

@include('ajax')
@include('script')
