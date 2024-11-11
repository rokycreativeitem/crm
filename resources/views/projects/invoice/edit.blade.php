<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.invoice.update', $payment->id) }}" method="post"
            id="ajaxForm">
            @csrf
            <div class="row">
                <div class="col-12">
                    <input type="hidden" name="project_id" value="{{ $payment->project_id }}" />
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
                        <input class="form-control ol-form-control" type="text" id="title" name="title"
                            value="{{ $payment->title }}">
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="payment">{{ get_phrase('Payment') }}</label>
                        <input class="form-control ol-form-control" type="number" id="payment" name="payment"
                            value="{{ $payment->payment }}">
                    </div>
                    <div class="fpb7 mb-2">
                        <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Submit') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@include('ajax')
