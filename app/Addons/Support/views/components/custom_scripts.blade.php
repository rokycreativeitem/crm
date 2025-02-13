<div class="modal fade" id="multiDelete" aria-labelledby="ajaxModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content pt-2">
            <div class="modal-body text-center">
                <div class="d-flex justify-content-center">
                    <span class="icon-confirm">
                        <svg width="24" height="26" viewBox="0 0 24 26" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15.2812 20.2656C15.7989 20.2656 16.2188 19.8458 16.2188 19.3281V9.95312C16.2188 9.43544 15.7989 9.01562 15.2812 9.01562C14.7636 9.01562 14.3438 9.43544 14.3438 9.95312V19.3281C14.3438 19.8458 14.7636 20.2656 15.2812 20.2656Z"
                                fill="#F8285A" />
                            <path
                                d="M8.71875 20.2656C9.23644 20.2656 9.65625 19.8458 9.65625 19.3281V9.95312C9.65625 9.43544 9.23644 9.01562 8.71875 9.01562C8.20106 9.01562 7.78125 9.43544 7.78125 9.95312V19.3281C7.78125 19.8458 8.20106 20.2656 8.71875 20.2656Z"
                                fill="#F8285A" />
                            <path
                                d="M15.75 1.98438C16.2677 1.98438 16.6875 1.56456 16.6875 1.04688C16.6875 0.529187 16.2677 0.109375 15.75 0.109375H8.25C7.73231 0.109375 7.3125 0.529187 7.3125 1.04688C7.3125 1.56456 7.73231 1.98438 8.25 1.98438H15.75Z"
                                fill="#F8285A" />
                            <path
                                d="M1.6875 2.92188C1.16981 2.92188 0.75 3.34169 0.75 3.85938C0.75 4.37706 1.16981 4.79688 1.6875 4.79688H2.625V22.0469C2.625 24.1655 4.35 25.8906 6.46875 25.8906H17.5312C19.6499 25.8906 21.375 24.1656 21.375 22.0469V4.79688H22.3125C22.8302 4.79688 23.25 4.37706 23.25 3.85938C23.25 3.34169 22.8302 2.92188 22.3125 2.92188H20.4375H3.5625H1.6875ZM19.5 4.79688V22.0469C19.5 23.1344 18.6187 24.0156 17.5312 24.0156H6.46875C5.38125 24.0156 4.5 23.1344 4.5 22.0469V4.79688H19.5Z"
                                fill="#F8285A" />
                        </svg>
                    </span>
                </div>
                <p class="title">{{ get_phrase('Are you sure') }}?</p>
                <p class="">{{ get_phrase('Do you really want to delete these records') }}?</p>
            </div>
            <div class="d-flex align-items-center justify-content-center mb-4">
                <button type="button" class="btn ol-btn-secondary fw-500 me-1"
                    data-bs-dismiss="modal">{{ get_phrase('Cancel') }}</button>
                <a href="javascript:void(0)"
                    class="confirm-btn btn ol-btn-danger fw-500 ms-1">{{ get_phrase('Delete') }}</a>
            </div>
        </div>
    </div>
</div>


@push('js')
    <script>
        "use strict";

        function multiDelete(selectedIds, database_type, url) {
            $("#multiDelete").modal('show');

            $('.confirm-btn').click(function(e) {
                e.preventDefault();

                var url = "{{ route(get_current_user_role() . '.addon.support.multi-delete') }}";
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        ids: selectedIds,
                        type: database_type,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.success) {
                            processServerResponse(response);
                            $("#multiDelete").modal('hide');
                            $('.server-side-datatable').DataTable().ajax.reload(null, false);
                            grid_view();
                        }
                    },
                });
            });
        }
    </script>
    <script>
        "use strict";

        function processServerResponse(response) {
            if (response.success) {
                success(response.success)
            }

            if (response.error) {
                error(response.error)
            }

            if (response.validationError) {
                error(JSON.stringify(response.validationError))
            }
        }

        // When the "Select All" checkbox is changed
        $(document).on('change', '#select-all', function() {
            $('.checkbox-item').prop('checked', this.checked);
            toggleDeleteButton();
        });

        // When any checkbox item is changed
        $(document).on('change', '.checkbox-item', function() {
            if ($('.checkbox-item:checked').length === $('.checkbox-item').length) {
                $('#select-all').prop('checked', true);
            } else {
                $('#select-all').prop('checked', false);
            }
            toggleDeleteButton();
        });

        // Function to toggle delete button visibility
        function toggleDeleteButton() {
            if ($('.checkbox-item:checked').length > 0) {
                $('#delete-selected').removeClass('d-none');
            } else {
                $('#delete-selected').addClass('d-none');
            }
        }

        function loadView(url, element, check_already_loaded) {
            if ($(element).text() == '' && check_already_loaded || !check_already_loaded) {
                $.ajax({
                    url: url,
                    success: function(response) {
                        $(element).html(response);
                    }
                });
            }
        }

        function downloadPDF(elem = ".server-side-datatable", fileName = 'data') {
            try {
                $('.print-d-none:not(.row, .ol-header, .ol-card)').addClass('d-none');
                $('.d-lpaginate').addClass('d-none');

                const table = document.querySelector(elem);
                if (!table) {
                    throw new Error(`Element with selector "${elem}" not found`);
                }

                const options = {
                    margin: 0.5,
                    filename: fileName,
                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },
                    html2canvas: {
                        scale: 2
                    },
                    jsPDF: {
                        unit: 'in',
                        format: 'letter',
                        orientation: 'portrait'
                    }
                };

                html2pdf().from(table).set(options).save().then(() => {
                    setTimeout(() => {
                        $('.print-d-none').removeClass('d-none');
                    }, 2000);
                });

            } catch (error) {
                console.error("Error in downloadPDF function:", error.message);
            }
        }


        function downloadTableAsCSV(elem, filename = 'data.csv') {
            var table = document.querySelector(elem);
            var csv = [];

            var rows = table.rows;
            for (var i = 0; i < rows.length; i++) {
                var row = [],
                    cols = rows[i].cells;

                for (var j = 0; j < cols.length; j++) {
                    row.push(cols[j].innerText);
                }

                csv.push(row.join(','));
            }

            var csvData = csv.join('\n');
            var blob = new Blob([csvData], {
                type: 'text/csv'
            });

            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = filename + '.csv';
            document.body.appendChild(link);
            link.trigger('click');
            document.body.removeChild(link);
        }

        function printDiv(divId) {
            var printContents = document.getElementById(divId).outerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }

        function copy_text(e) {
            var copyText = document.getElementById("generatedAiText");
            console.log(copyText);
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value);
            $(e).html('<i class="far fa-copy"></i> Copied!')
        }
    </script>
@endpush
