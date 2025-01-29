<link rel="stylesheet" href="{{ asset('assets/datatable/dataTables.bootstrap5.css') }}">
<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/datatable/dataTables.js') }}"></script>
<script src="{{ asset('assets/datatable/dataTables.bootstrap5.js') }}"></script>


<div id="table-data-not-found" class="d-none">
    <div class="no-data py-5">
        <img src="{{ asset('assets/images/no-data.png') }}" alt="No Data" style="max-width: 150px;">
        <h3 class="py-3">{{ get_phrase('No Result Found') }}</h3>
        <p class="pb-4">{{ get_phrase('A few questions to keep you make sure you’ve listened to the past ') }}</p>
    </div>
</div>
<script>
    new DataTable('#basic-datatable', {
        orderCellsTop: true,
        ordering: false
    });

    // server side data table rendering
    function server_side_datatable(columnsParam, url) {
        let columnsArray = Array.isArray(columnsParam) ? columnsParam : JSON.parse(columnsParam);
        if (!Array.isArray(columnsArray)) {
            console.error("{{ get_phrase('The columns parameter should be an array or a JSON-encoded array') }}.");
            return;
        }
        let columns = columnsArray.map(columnKey => {
            return {
                data: columnKey
            };
        });
        const noData = $('#table-data-not-found').html();
        var table = new DataTable('.server-side-datatable', {
            processing: true,
            serverSide: true,
            info: true,
            ajax: {
                url: url,
                type: 'GET',
                data: function(d) {
                    $('#filters-container :input').each(function() {
                        var name = $(this).attr('name');
                        var value = $(this).val();
                        if (name) {
                            d[name] = value || null;
                        }
                    });
                },
                // success: function(response) {
                //     console.log(response.filter_count);
                //     $('#filter-count-display').text(response.filter_count);
                // },
                // error: function(xhr, error, thrown) {
                //     console.log(xhr.responseText);
                // }
            },
            columns: columns,
            orderCellsTop: true,
            ordering: false,
            pageLength: 10,
            paging: true,
            language: {
                emptyTable: noData,
            },
        });

        table.on('xhr', function(e, settings, json) {
            // console.log(json.filter_count);
            if (json.filter_count > 0) {
                $('#filter-count-display').text(json.filter_count).removeClass('d-none');
                $('#filter-reset').removeClass('d-none');
            }
        });

        // $('.server-side-datatable').on('xhr.dt', function(e, settings, json) {
        //     if (json.no_data) {
        //         $('#server_side_table_wrapper').html(json.no_data);
        //     }
        // });


        $('.server-side-datatable tbody').on('contextmenu', 'tr', function(e) {
            e.preventDefault();
            e.stopPropagation();

            var rowData = table.row(this).data();
            var contextMenuData;

            try {
                var rawContextMenu = decodeHtmlEntities(rowData.context_menu);
                contextMenuData = JSON.parse(rawContextMenu);
                // console.log(contextMenuData)
            } catch (e) {
                console.error("Error decoding or parsing context menu JSON:", e);
                return;
            }

            // Build and display context menu
            let menuHtml = '<ul class="custom-context-menu">';
            for (const key in contextMenuData) {
                const item = contextMenuData[key];
                let linkHtml = '';

                if (item.type === 'ajax' && item.name.toLowerCase() === 'edit') {
                    linkHtml = `<a href="javascript:void(0)" onclick="rightCanvas('${item.action_link}')" title="${item.title}">${item.name}</a>`;
                } else if (item.type === 'ajax' && item.name.toLowerCase() === 'delete') {
                    linkHtml = `<a href="javascript:void(0)" onclick="confirmModal('${item.action_link}')" title="${item.title}">${item.name}</a>`;
                } else {
                    linkHtml = `<a href="${item.action_link}" title="${item.title}">${item.name}</a>`;
                }

                menuHtml += `<li>${linkHtml}</li>`;
            }
            menuHtml += '</ul>';

            // Append and position the context menu
            $('body').append(menuHtml);
            $('.custom-context-menu').css({
                top: e.pageY + 'px',
                left: e.pageX + 'px'
            }).show();
        });

        // Utility to decode HTML entities
        function decodeHtmlEntities(str) {
            var textarea = document.createElement('textarea');
            textarea.innerHTML = str;
            return textarea.value;
        }

        // Hide context menu when clicking elsewhere
        $(document).on('click', function() {
            $('.custom-context-menu').remove();
        });

        // Optional: Adjust context menu styling
        $(document).on('contextmenu', function(e) {
            $('.custom-context-menu').remove();
        });

        $('#custom-search-box').on('keyup', function(e) {
            table.ajax.reload();
        });

        $('#page-length-select').on('change', function() {
            var newLength = $(this).val();
            table.page.len(newLength).draw();
        });

    }

    function init_context_menu(context_menu) {
        const contextMenuItems = {};
        $.each(context_menu, function(key, value) {
            contextMenuItems[key] = {
                name: value.name,
                callback: function(itemKey, opt, e) {
                    const url = value.action_link;
                    window.location.href = url;
                }
            };
        });

        // console.log("Initializing context menu with:", contextMenuItems);
        $.contextMenu({
            selector: '.category-context-menu',
            autoHide: false,
            items: contextMenuItems
        });
    }


    $(document).ready(function() {
        // Handle delete-selected button click
        $('#delete-selected').on('click', function() {
            var selectedIds = [];
            $('.table-checkbox:checked').each(function() {
                var rowId = $(this).closest('tr').find('.datatable-row-id').val();
                if (rowId) {
                    selectedIds.push(rowId);
                }
            });

            var database_type = $('#datatable_type').val();
            if (selectedIds.length > 0) {
                multiDelete(selectedIds, database_type); // Call the multiDelete function
                $('#delete-selected').addClass('d-none');
            } else {
                alert('Please select at least one file to delete.');
            }
        });

        // Handle filter button click
        $('#filter').on('click', function() {
            $('.server-side-datatable').DataTable().ajax.reload(null, false); // Reload the DataTable
        });

        // Handle filter-reset button click
        $('#filter-reset').on('click', function() {
            // Reset select elements to 'all'
            $('#status, #client, #staff, #category, #task, #team, #size, #uploaded_by, #type, #user, #payment_method').val('all');

            // Clear specific input fields
            $('#start_date, #end_date, #progress, .minPrice').val('');

            // Hide filter-related elements
            $('.filter-count-display, #filter-reset').addClass('d-none');

            // Reload the DataTable
            $('.server-side-datatable').DataTable().ajax.reload(null, false);
        });
    });
</script>
