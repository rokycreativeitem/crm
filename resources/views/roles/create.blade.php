<div class="ol-card p-3">
    <div class="ol-card-body">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('admin.roles.store') }}" method="POST">@csrf
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="name">{{ 'Name' }}</label>
                        <input class="form-control ol-form-control" type="text" id="name" name="title" required>
                    </div>
                    <div class="fpb7 mb-2">
                        <button type="submit" class="btn ol-btn-primary">{{ 'Add role' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('ajax')
