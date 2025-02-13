<div class="ol-card">
    <div class="ol-card-body">
        <form action="{{ route(get_current_user_role() . '.addon.faq.store') }}" method="post"
            enctype="multipart/form-data" id="ajaxForm">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="question">{{ get_phrase('Question') }}<span
                                class="required">*</span></label>
                        <textarea name="question" rows="5" class="form-control ol-form-control" placeholder="Enter your question here"
                            id="question"></textarea>
                    </div>

                    <div class="fpb7 mb-2">
                        <label class="form-label ol-form-label" for="answer">{{ get_phrase('Answer') }}<span
                                class="required">*</span></label>
                        <textarea name="answer" rows="5" class="form-control ol-form-control text_editor"
                            placeholder="Enter your answer here" id="answer"></textarea>
                    </div>

                    <div class="fpb7 mb-2">
                        <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Submit') }}</button>
                    </div>

                </div>
            </div>

        </form>
    </div>
</div>
<script>
    $('.text_editor').summernote({
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
@include('ajax')
@include('init_js')
