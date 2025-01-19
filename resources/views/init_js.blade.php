<script type="text/javascript">
    "use strict";
    $(document).ready(function() {
        //select2
        if ($('select.ol-select2:not(.inited)').length) {
            $('select.ol-select2:not(.inited)').select2();
            $('select.ol-select2:not(.inited)').addClass('inited');
        }

        // Initialize AvalynxSelect
        if ($('select.ol-avalynx-select:not(.inited)').length) {
            $('select.ol-avalynx-select:not(.inited)').each(function() {
                new AvalynxSelect(this, {
                    liveSearch: true, // Enables live search
                    caseSensitive: false, // Case-insensitive search
                    showAll: true, // Show all options when input is empty
                    scrollList: true, // Enable scrolling for long lists
                    scrollItems: 8 // Show 8 items before scrolling
                }, {
                    searchPlaceholder: 'Search...', // Placeholder for the search input
                    selectPlaceholder: 'Please select...' // Placeholder for the dropdown
                });

                // Mark as initialized
                $(this).addClass('inited');
            });
        }

        // datatable
        if (!$.fn.dataTable.isDataTable('#datatable')) {
            var table = new DataTable('#datatable', {
                buttons: [],
                layout: {
                    topStart: "buttons",
                },
            });

            $('#dt-search-0').attr('placeholder', 'Search');
            $('#table-action-btns').removeClass('d-none');
            $('.dt-layout-row').find('.dt-buttons').prepend($('#table-action-btns'));
            $('#datatable').addClass('inited');
            $('#spinnner-before-table').addClass('d-none');
            $('.table-responsive').removeClass('d-none');
        }

        // Date range picker
        if ($('.daterangepicker:not(.inited)').length) {
            $('.daterangepicker:not(.inited)').daterangepicker();
            $('.daterangepicker:not(.inited)').addClass('inited');
        }

        // icon picker
        if ($('.icon-picker:not(.inited)').length) {
            $('.icon-picker:not(.inited)').iconpicker();
            $('.icon-picker:not(.inited)').addClass('inited');
        }

        //Text editor
        if ($('.text_editor:not(.inited)').length) {
            $('.text_editor:not(.inited)').summernote({
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
            $('.text_editor:not(.inited)').addClass('inited');
        }

        $('.tagify:not(.inited)').each(function(index, element) {
            var tagify = new Tagify(element, {
                placeholder: 'Enter your keywords'
            });
            $(element).addClass('inited');
        });

        var formElement;
        if ($('.ajaxForm:not(.initialized)').length > 0) {
            $('.ajaxForm:not(.initialized)').ajaxForm({
                beforeSend: function(data, form) {
                    var formElement = $(form);
                },
                uploadProgress: function(event, position, total, percentComplete) {},
                complete: function(xhr) {

                    setTimeout(function() {
                        distributeServerResponse(xhr.responseText);
                    }, 400);

                    if ($('.ajaxForm.resetable').length > 0) {
                        $('.ajaxForm.resetable')[0].reset();
                    }
                },
                error: function(e) {
                    console.log(e);
                }
            });
            $('.ajaxForm:not(.initialized)').addClass('initialized');
        }
    });
</script>
