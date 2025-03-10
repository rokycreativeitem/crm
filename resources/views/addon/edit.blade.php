<div class="ol-card mt-3">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.addon.store',['id'=>$addon->id]) }}" method="post" id="ajaxForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="install">
            <div class="row">
                <div class="col-12">
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="code">{{ get_phrase('Purchase Code') }}</label>
                        <input class="form-control ol-form-control" type="text" id="code" name="code" value="{{$addon->purchase_code}}">
                    </div>
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="file">{{ get_phrase('Zip File') }}</label>
                        <input class="form-control ol-form-control" type="file" id="file" name="file">
                    </div>
                    <div class="fpb7 mb-2">
                        <button type="submit" class="btn mt-3 ol-btn-primary">{{ get_phrase('Update') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

