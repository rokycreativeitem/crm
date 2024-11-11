<div class="placeholder-content d-none">
    <div class="d-flex justify-content-center align-items-center">
        <div class="spinner-border text-primary spinner-border-lg" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <p class="py-4 text-center">Loading please wait...</p>
</div>


<!-- normal modal -->
<div class="modal global fade ad-modal" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modalLabel"></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<script>
    "use strict";

    function modal(title = '', url = '', size = 'modal-md') {

        // load the spinner on every open
        let placeholder = $('.placeholder-content').html();
        $('#modal .modal-body').empty().html(placeholder);

        // set modal data
        $('#modal .modal-title').html(title);
        $('#modal .modal-dialog').addClass(size);
        $("#modal").modal('show');

        $.ajax({
            type: 'get',
            url: url,
            success: function(response) {
                if (response) {
                    $('#modal .modal-body').empty().html(response);
                }
            }
        });
    }
</script>



<!-- setup offcanvas -->
<div class="offcanvas global p-1" data-bs-scroll="true" tabindex="-1" id="Id1" aria-labelledby="backdrop">
    <div class="offcanvas-header pb-0">
        <h5 class="offcanvas-title" id="backdrop"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body pt-2"></div>
</div>
<script>
    "use strict";

    function rightCanvas(url, title, position = '') {
        let spinner = $('.placeholder-spinner').html();
        let offcanvasBody = $('.global .offcanvas-body').empty().append(spinner);
        let canvasPosition = position == 'right' ? 'offcanvas-end' : 'offcanvas-start';

        $('.global.offcanvas-title').text(title);
        $('.global.offcanvas').addClass(position == '' ? 'offcanvas-end' : canvasPosition);
        $('.global.offcanvas').offcanvas('show');

        $.ajax({
            type: "get",
            url: url,
            success: function(response) {
                if (response) {
                    $('.global.offcanvas .offcanvas-body').empty().html(response);
                }
            }
        });
    }
</script>

<!-- confirm modal -->
<div class="modal fade" id="ajaxModal" aria-labelledby="ajaxModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title text-dark text-16px" id="ajaxModalLabel"></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="w-100 text-center py-5">
                    <div class="spinner-border my-5" role="status">
                        <span class="visually-hidden"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn ol-btn-secondary" data-bs-dismiss="modal">{{ get_phrase('Close') }}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmModal" aria-labelledby="ajaxModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content pt-2">
            <div class="modal-body text-center">

                <div class="d-flex justify-content-center">
                    <span class="icon-confirm">
                        <svg width="24" height="26" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.2812 20.2656C15.7989 20.2656 16.2188 19.8458 16.2188 19.3281V9.95312C16.2188 9.43544 15.7989 9.01562 15.2812 9.01562C14.7636 9.01562 14.3438 9.43544 14.3438 9.95312V19.3281C14.3438 19.8458 14.7636 20.2656 15.2812 20.2656Z" fill="#F8285A" />
                            <path d="M8.71875 20.2656C9.23644 20.2656 9.65625 19.8458 9.65625 19.3281V9.95312C9.65625 9.43544 9.23644 9.01562 8.71875 9.01562C8.20106 9.01562 7.78125 9.43544 7.78125 9.95312V19.3281C7.78125 19.8458 8.20106 20.2656 8.71875 20.2656Z" fill="#F8285A" />
                            <path d="M15.75 1.98438C16.2677 1.98438 16.6875 1.56456 16.6875 1.04688C16.6875 0.529187 16.2677 0.109375 15.75 0.109375H8.25C7.73231 0.109375 7.3125 0.529187 7.3125 1.04688C7.3125 1.56456 7.73231 1.98438 8.25 1.98438H15.75Z" fill="#F8285A" />
                            <path
                                d="M1.6875 2.92188C1.16981 2.92188 0.75 3.34169 0.75 3.85938C0.75 4.37706 1.16981 4.79688 1.6875 4.79688H2.625V22.0469C2.625 24.1655 4.35 25.8906 6.46875 25.8906H17.5312C19.6499 25.8906 21.375 24.1656 21.375 22.0469V4.79688H22.3125C22.8302 4.79688 23.25 4.37706 23.25 3.85938C23.25 3.34169 22.8302 2.92188 22.3125 2.92188H20.4375H3.5625H1.6875ZM19.5 4.79688V22.0469C19.5 23.1344 18.6187 24.0156 17.5312 24.0156H6.46875C5.38125 24.0156 4.5 23.1344 4.5 22.0469V4.79688H19.5Z"
                                fill="#F8285A" />
                        </svg>
                    </span>
                </div>
                <p class="title">{{ get_phrase('Are you sure') }}?</p>
                <p class="">{{ get_phrase('Do you really want to delete these records') }}?</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn ol-btn-secondary fw-500" data-bs-dismiss="modal">{{ get_phrase('Cancel') }}</button>
                <a class="confirm-btn btn ol-btn-danger fw-500">{{ get_phrase('Delete') }}</a>
            </div>
        </div>
    </div>
</div>
<script>
    "use strict";

    function confirmModal(url, elem = false, actionType = null, content = null) {
        $("#confirmModal").modal('show');

        if (elem == false) {
            $('#confirmModal .confirm-btn').click(function(e) {
                e.preventDefault();
                $.ajax({
                    url: url,
                    success: function(response) {
                        $("#confirmModal").modal('hide');
                        processServerResponse(response);
                    }
                });
            });
        } else {
            $('#confirmModal .confirm-btn').attr('href', url);
            $('#confirmModal .confirm-btn').removeAttr('onclick');
        }
    }
</script>

<div class="modal fade" id="multiDelete" aria-labelledby="ajaxModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content pt-2">
            <div class="modal-body text-center">
                <div class="d-flex justify-content-center">
                    <span class="icon-confirm">
                        <svg width="24" height="26" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.2812 20.2656C15.7989 20.2656 16.2188 19.8458 16.2188 19.3281V9.95312C16.2188 9.43544 15.7989 9.01562 15.2812 9.01562C14.7636 9.01562 14.3438 9.43544 14.3438 9.95312V19.3281C14.3438 19.8458 14.7636 20.2656 15.2812 20.2656Z" fill="#F8285A" />
                            <path d="M8.71875 20.2656C9.23644 20.2656 9.65625 19.8458 9.65625 19.3281V9.95312C9.65625 9.43544 9.23644 9.01562 8.71875 9.01562C8.20106 9.01562 7.78125 9.43544 7.78125 9.95312V19.3281C7.78125 19.8458 8.20106 20.2656 8.71875 20.2656Z" fill="#F8285A" />
                            <path d="M15.75 1.98438C16.2677 1.98438 16.6875 1.56456 16.6875 1.04688C16.6875 0.529187 16.2677 0.109375 15.75 0.109375H8.25C7.73231 0.109375 7.3125 0.529187 7.3125 1.04688C7.3125 1.56456 7.73231 1.98438 8.25 1.98438H15.75Z" fill="#F8285A" />
                            <path
                                d="M1.6875 2.92188C1.16981 2.92188 0.75 3.34169 0.75 3.85938C0.75 4.37706 1.16981 4.79688 1.6875 4.79688H2.625V22.0469C2.625 24.1655 4.35 25.8906 6.46875 25.8906H17.5312C19.6499 25.8906 21.375 24.1656 21.375 22.0469V4.79688H22.3125C22.8302 4.79688 23.25 4.37706 23.25 3.85938C23.25 3.34169 22.8302 2.92188 22.3125 2.92188H20.4375H3.5625H1.6875ZM19.5 4.79688V22.0469C19.5 23.1344 18.6187 24.0156 17.5312 24.0156H6.46875C5.38125 24.0156 4.5 23.1344 4.5 22.0469V4.79688H19.5Z"
                                fill="#F8285A" />
                        </svg>
                    </span>
                </div>
                <p class="title">{{ get_phrase('Are you sure') }}?</p>
                <p class="">{{ get_phrase('Do you really want to delete these records') }}?</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn ol-btn-secondary fw-500" data-bs-dismiss="modal">{{ get_phrase('Cancel') }}</button>
                <a class="confirm-btn btn ol-btn-danger fw-500">{{ get_phrase('Delete') }}</a>
            </div>
        </div>
    </div>
</div>
<script>
    "use strict";

    function multiDelete(url, project_codes) {
        $("#multiDelete").modal('show');

        $('.confirm-btn').click(function(e) {
            e.preventDefault();

            ajaxCall("{{ route(get_current_user_role() . '.project.multi-delete') }}", project_codes)
                .done(function(res) {
                    if (res.success) {
                        $("#multiDelete").modal('hide');
                    }
                });
        });
    }
</script>


<div class="offcanvas offcanvas-end" tabindex="-1" id="right-modal" aria-labelledby="right-modalLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title title text-16px" id="right-modalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
    </div>
</div>


<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">AI Assistant</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form class="aiAjaxFormSubmission" action="#open-ai/generate" method="post">
            <input type="hidden" name="_token" value="UQzRLXQ0TGBRQpRQXL94kNkAK4juUyIyQ4hYVMsN" autocomplete="off">
            <div class="mb-3">
                <label class="form-label ol-form-label" for="ai_service_selector">Select your service</label>
                <select class="ol-select2" id="ai_service_selector" name="service_type" onchange="if(this.value == 'Course thumbnail'){$('#aiLanguageField').hide()}else{$('#aiLanguageField').show()}">
                    <option value="Course title" data-select2-id="2">Course title</option>
                    <option value="Course short description">Course short description</option>
                    <option value="Course short description">Course long description</option>
                    <option value="Course requirements">Course requirements</option>
                    <option value="Course outcomes">Course outcomes</option>
                    <option value="Course FAQ">Course faq</option>
                    <option value="Course SEO Tags">Course seo tags</option>
                    <option value="Course lesson text">Course lesson text</option>
                    <option value="Course certificate text">Course certificate text</option>
                    <option value="Course quiz text">Course quiz text</option>
                    <option value="Course blog title">Course blog title</option>
                    <option value="Course blog post">Course blog post</option>
                    <option value="Course thumbnail">Course thumbnail</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label ol-form-label" for="ai_keywords">Enter your keyword</label>
                <input type="text" class="form-control ol-form-control" id="ai_keywords" name="ai_keywords">
            </div>

            <div class="mb-3" id="aiLanguageField">
                <label class="form-label ol-form-label" for="language">Language</label>
                <select class="ol-select2" name="language">
                    <option value="english" class="text-capitalize">English</option>
                    <option value="hindi" class="text-capitalize">Hindi</option>
                    <option value="spanish" class="text-capitalize">Spanish</option>
                </select>
            </div>

            <button type="submit" id="aiSubmissionBtn" class="btn ol-btn-primary w-100">Generate</button>
        </form>

        <div class="row mt-3">
            <div class="col-md-12">
                <h5 id="aiResultHeader"></h5>
                <div id="aiGeneratedText" contenteditable="true"></div>
            </div>
        </div>
    </div>
</div>
