<form action="{{ route('temp.update', ['id' => $template->id]) }}" enctype="multipart/form-data" method="post" class="mt-4">
    @csrf
    @foreach (json_decode($template->template) as $key => $item)
        <div class="fpb-7 mb-3">
            <label class="mb-2">{{ ucwords($key) . ' ' . get_phrase('Template') }}</label>
            <textarea name="template[{{ $key }}]" id="template_{{ $key }}" cols="30" rows="10" class="form-control email_template ol-form-control" required>{{ $item }}</textarea>
        </div>
    @endforeach
    <button class="btn ol-btn-primary" type="submit"> {{ get_phrase('Update') }} </button>
</form>

<script>
    $('.email_template').summernote({
        height: 180,
        minHeight: null,
        maxHeight: null,
        focus: true,
        toolbar: [
            ['color', ['color']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['para', ['ul', 'ol']],
            ['table', ['table']],
            ['insert', ['link']]
        ]
    });
</script>
