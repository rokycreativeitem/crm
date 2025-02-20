<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.event.update', $event->id) }}" method="post" id="ajaxEventForm">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
                        <input class="form-control ol-form-control" type="text" id="title" name="title" value="{{ $event->title }}">
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="start_date">{{ get_phrase('Start Date') }}</label>
                        <input class="form-control ol-form-control" type="datetime-local" id="start_date" name="start_date" value="{{ date($event->start_date) }}" required>
                    </div>
                    <div class="fpb7 mb-4">
                        <label class="form-label ol-form-label" for="end_date">{{ get_phrase('End Date') }}</label>
                        <input class="form-control ol-form-control" type="datetime-local" id="end_date" name="end_date" value="{{ date($event->end_date) }}" required>
                    </div>
                    <div class="fpb7 mb-2 d-flex gap-3 justify-content-end">
                        @if (has_permission('event.delete'))
                        <a href="javascript:void(0)" onclick="confirmModal('{{route(get_current_user_role().'.event.delete',['id'=>$event->id])}}')" class="btn ol-btn-danger">{{ get_phrase('Delete') }}</a>
                        @endif
                        <button type="button" onclick="handleAjaxFormSubmission('ajaxEventForm')" class="btn ol-btn-primary">{{ get_phrase('Update') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>